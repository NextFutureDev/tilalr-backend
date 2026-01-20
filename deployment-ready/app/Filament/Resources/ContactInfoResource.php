<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInfoResource\Pages;
use App\Filament\Resources\ContactInfoResource\RelationManagers;
use App\Models\ContactInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactInfoResource extends Resource
{
    protected static ?string $model = ContactInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?string $navigationLabel = 'Contact Information';
    
    protected static ?string $modelLabel = 'Contact Information';
    
    protected static ?string $pluralModelLabel = 'Contact Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options([
                        'location' => 'Location',
                        'phone' => 'Phone',
                        'email' => 'Email',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('icon', self::getDefaultIcon($state))),
                
                Forms\Components\TextInput::make('icon')
                    ->label('Icon Class')
                    ->helperText('Bootstrap icon class (e.g., bi-geo-alt, bi-telephone, bi-envelope)')
                    ->required(),
                
                Forms\Components\TextInput::make('title.en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('title.ar')
                    ->label('Title (Arabic)')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('content.en')
                    ->label('Content (English)')
                    ->required()
                    ->rows(3)
                    ->helperText('For location: address details. For phone: phone numbers. For email: email addresses.'),
                
                Forms\Components\Textarea::make('content.ar')
                    ->label('Content (Arabic)')
                    ->required()
                    ->rows(3),
                
                Forms\Components\TextInput::make('working_hours')
                    ->label('Working Hours')
                    ->helperText('Only for phone type (e.g., Mon-Fri 9AM-6PM)')
                    ->visible(fn (callable $get) => $get('type') === 'phone')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first'),
                
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Only active items will be displayed on the website'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'location' => 'success',
                        'phone' => 'info',
                        'email' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title (English)')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('content.en')
                    ->label('Content (English)')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('icon')
                    ->label('Icon')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'location' => 'Location',
                        'phone' => 'Phone',
                        'email' => 'Email',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListContactInfos::route('/'),
            'create' => Pages\CreateContactInfo::route('/create'),
            'edit' => Pages\EditContactInfo::route('/{record}/edit'),
        ];
    }
    
    private static function getDefaultIcon($type)
    {
        return match ($type) {
            'location' => 'bi-geo-alt',
            'phone' => 'bi-telephone',
            'email' => 'bi-envelope',
            default => 'bi-info-circle',
        };
    }
}
