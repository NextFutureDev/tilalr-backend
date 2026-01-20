<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppSettingResource\Pages;
use App\Models\AppSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppSettingResource extends Resource
{
    protected static ?string $model = AppSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Website';
    protected static ?string $navigationLabel = 'Settings';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('whatsapp_phone')
                ->label('WhatsApp Phone (international format)')
                ->helperText('Example: 9665XXXXXXXX')
                ->tel()
                ->maxLength(30),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('whatsapp_phone')->label('WhatsApp Phone'),
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Updated'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAppSettings::route('/'),
        ];
    }
}


