<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewReservation extends ViewRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Customer Information')
                    ->schema([
                        Components\TextEntry::make('name')
                            ->label('Full Name'),
                        Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable()
                            ->icon('heroicon-m-envelope'),
                        Components\TextEntry::make('phone')
                            ->label('Phone')
                            ->copyable()
                            ->icon('heroicon-m-phone'),
                    ])
                    ->columns(3),

                Components\Section::make('Trip Details')
                    ->schema([
                        Components\TextEntry::make('trip_type')
                            ->label('Trip Type')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'school' => 'School Trip',
                                'corporate' => 'Corporate Trip',
                                'family' => 'Family Trip',
                                'private' => 'Private Group',
                                default => ucfirst($state),
                            }),
                        Components\TextEntry::make('trip_title')
                            ->label('Trip Title'),
                        Components\TextEntry::make('preferred_date')
                            ->label('Preferred Date')
                            ->date(),
                        Components\TextEntry::make('guests')
                            ->label('Number of Guests'),
                    ])
                    ->columns(2),

                Components\Section::make('Notes & Details')
                    ->schema([
                        Components\TextEntry::make('notes')
                            ->label('Customer Notes')
                            ->columnSpanFull(),
                        Components\TextEntry::make('details_display')
                            ->label('Additional Details')
                            ->columnSpanFull(),
                    ]),

                Components\Section::make('Status Information')
                    ->schema([
                        Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match($state) {
                                'pending' => 'warning',
                                'contacted' => 'info',
                                'confirmed' => 'success',
                                'converted' => 'primary',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                        Components\IconEntry::make('admin_contacted')
                            ->label('Customer Contacted')
                            ->boolean(),
                        Components\TextEntry::make('contacted_at')
                            ->label('Contacted At')
                            ->dateTime(),
                        Components\TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->dateTime(),
                    ])
                    ->columns(4),

                Components\Section::make('Admin Notes')
                    ->schema([
                        Components\TextEntry::make('admin_notes')
                            ->label('Internal Notes')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => filled($record->admin_notes)),
            ]);
    }
}
