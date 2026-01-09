<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternationalHotelResource\Pages;
use App\Models\InternationalHotel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InternationalHotelResource extends Resource
{
    protected static ?string $model = InternationalHotel::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $navigationGroup = 'International';

    // Only Executive Manager and Super Admin can access
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && ($user->hasRole('executive_manager') || $user->hasRole('super_admin'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hotel Details')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')->required()->label('Name (EN)'),
                        Forms\Components\TextInput::make('name_ar')->label('Name (AR)'),
                        Forms\Components\TextInput::make('location_en')->required()->label('Location (EN)'),
                        Forms\Components\TextInput::make('location_ar')->label('Location (AR)'),
                        Forms\Components\TextInput::make('stars')->numeric()->minValue(1)->maxValue(5)->label('Stars'),
                        Forms\Components\TextInput::make('price_per_night')->required()->numeric()->label('Price per Night'),
                        Forms\Components\Textarea::make('description_en')->label('Description (EN)'),
                        Forms\Components\Textarea::make('description_ar')->label('Description (AR)'),
                        Forms\Components\FileUpload::make('image')->image()->directory('hotels')->label('Image'),
                        Forms\Components\Toggle::make('active')->label('Active')->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')->label('Name (EN)')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('location_en')->label('Location (EN)')->searchable(),
                Tables\Columns\TextColumn::make('stars')->label('Stars'),
                Tables\Columns\TextColumn::make('price_per_night')->label('Price')->money('usd', true),
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
            'index' => Pages\ListInternationalHotels::route('/'),
            'create' => Pages\CreateInternationalHotel::route('/create'),
            'edit' => Pages\EditInternationalHotel::route('/{record}/edit'),
        ];
    }
}
