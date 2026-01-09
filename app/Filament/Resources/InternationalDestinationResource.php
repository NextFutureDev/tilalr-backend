<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternationalDestinationResource\Pages;
use App\Models\InternationalDestination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InternationalDestinationResource extends Resource
{
    protected static ?string $model = InternationalDestination::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    
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
                Forms\Components\Section::make('Destination Details')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')->required()->label('Name (EN)'),
                        Forms\Components\TextInput::make('name_ar')->label('Name (AR)'),
                        Forms\Components\TextInput::make('country_en')->required()->label('Country (EN)'),
                        Forms\Components\TextInput::make('country_ar')->label('Country (AR)'),
                        Forms\Components\Textarea::make('description_en')->label('Description (EN)'),
                        Forms\Components\Textarea::make('description_ar')->label('Description (AR)'),
                        Forms\Components\FileUpload::make('image')->image()->directory('destinations')->label('Image'),
                        Forms\Components\Toggle::make('active')->label('Active')->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')->label('Name (EN)')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('country_en')->label('Country (EN)')->searchable(),
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
            'index' => Pages\ListInternationalDestinations::route('/'),
            'create' => Pages\CreateInternationalDestination::route('/create'),
            'edit' => Pages\EditInternationalDestination::route('/{record}/edit'),
        ];
    }
}
