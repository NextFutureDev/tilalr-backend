<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternationalPackageResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\InternationalPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InternationalPackageResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = InternationalPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    
    protected static ?string $navigationGroup = 'International Destinations';

    protected static ?int $navigationSort = 4;

    public static function getPermissionKey(): string
    {
        return 'international_packages';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Package Details')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')->required()->label('Title (EN)'),
                        Forms\Components\TextInput::make('title_ar')->label('Title (AR)'),
                        Forms\Components\TextInput::make('destination_en')->required()->label('Destination (EN)'),
                        Forms\Components\TextInput::make('destination_ar')->label('Destination (AR)'),
                        Forms\Components\TextInput::make('duration_en')->label('Duration (EN)'),
                        Forms\Components\TextInput::make('duration_ar')->label('Duration (AR)'),
                        Forms\Components\TextInput::make('price')->required()->numeric()->label('Price'),
                        Forms\Components\Textarea::make('description_en')->label('Description (EN)'),
                        Forms\Components\Textarea::make('description_ar')->label('Description (AR)'),
                        Forms\Components\FileUpload::make('image')->image()->directory('packages')->label('Image'),
                        Forms\Components\Toggle::make('active')->label('Active')->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')->label('Title (EN)')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('destination_en')->label('Destination (EN)')->searchable(),
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
            'index' => Pages\ListInternationalPackages::route('/'),
            'create' => Pages\CreateInternationalPackage::route('/create'),
            'edit' => Pages\EditInternationalPackage::route('/{record}/edit'),
        ];
    }
}
