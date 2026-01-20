<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternationalFlightResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\InternationalFlight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InternationalFlightResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = InternationalFlight::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    
    protected static ?string $navigationGroup = 'International Destinations';

    protected static ?int $navigationSort = 2;

    public static function getPermissionKey(): string
    {
        return 'international_flights';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Flight Details')
                    ->schema([
                        Forms\Components\TextInput::make('airline_en')->required()->label('Airline (EN)'),
                        Forms\Components\TextInput::make('airline_ar')->label('Airline (AR)'),
                        Forms\Components\TextInput::make('route_en')->required()->label('Route (EN)'),
                        Forms\Components\TextInput::make('route_ar')->label('Route (AR)'),
                        Forms\Components\TextInput::make('departure_time')->label('Departure Time'),
                        Forms\Components\TextInput::make('arrival_time')->label('Arrival Time'),
                        Forms\Components\TextInput::make('duration')->label('Duration'),
                        Forms\Components\TextInput::make('stops_en')->label('Stops (EN)'),
                        Forms\Components\TextInput::make('stops_ar')->label('Stops (AR)'),
                        Forms\Components\TextInput::make('price')->required()->numeric()->label('Price'),
                        Forms\Components\Toggle::make('active')->label('Active')->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('airline_en')->label('Airline (EN)')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('route_en')->label('Route (EN)')->searchable(),
                Tables\Columns\TextColumn::make('departure_time')->label('Departure'),
                Tables\Columns\TextColumn::make('price')->label('Price')->money('usd', true),
                Tables\Columns\IconColumn::make('active')->boolean()->label('Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListInternationalFlights::route('/'),
            'create' => Pages\CreateInternationalFlight::route('/create'),
            'edit' => Pages\EditInternationalFlight::route('/{record}/edit'),
        ];
    }
}
