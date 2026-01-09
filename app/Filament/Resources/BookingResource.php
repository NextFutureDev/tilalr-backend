<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Reservations & Bookings';
    
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    // Executive Manager, Consultant, and Super Admin can access
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && ($user->hasRole('executive_manager') || $user->hasRole('consultant') || $user->hasRole('super_admin'));
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('user_id')
                            ->label('User ID')
                            ->numeric()
                            ->default(null)
                            ->helperText('Leave empty for guest bookings'),
                        Forms\Components\TextInput::make('details.name')
                            ->label('Customer Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('details.email')
                            ->label('Customer Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('details.phone')
                            ->label('Customer Phone')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Booking Details')
                    ->schema([
                        Forms\Components\TextInput::make('service_id')
                            ->label('Service/Trip ID')
                            ->numeric()
                            ->default(null),
                        Forms\Components\TextInput::make('details.trip_title')
                            ->label('Trip Title')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date')
                            ->label('Booking Date'),
                        Forms\Components\TextInput::make('guests')
                            ->label('Number of Guests')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                        Forms\Components\TextInput::make('details.amount')
                            ->label('Amount (SAR)')
                            ->numeric()
                            ->prefix('SAR'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->native(false)
                            ->default('pending'),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])
                            ->required()
                            ->native(false)
                            ->default('pending'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Details')
                    ->schema([
                        Forms\Components\KeyValue::make('details')
                            ->label('All Details')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('details.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('details.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('details.trip_title')
                    ->label('Trip')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guests')
                    ->label('Guests')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('details.amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' SAR' : '-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('confirmBooking')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'confirmed']);
                        Notification::make()
                            ->title('Booking confirmed')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Booking $record) => $record->status === 'pending'),
                Tables\Actions\Action::make('markPaid')
                    ->label('Mark Paid')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Booking $record) {
                        $record->update(['payment_status' => 'paid']);
                        Notification::make()
                            ->title('Payment marked as paid')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Booking $record) => $record->payment_status !== 'paid'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('confirmAll')
                        ->label('Confirm Selected')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(fn ($record) => $record->update(['status' => 'confirmed']));
                            Notification::make()
                                ->title('Selected bookings confirmed')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
