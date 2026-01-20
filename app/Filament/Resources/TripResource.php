<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Trip;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TripResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    
    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Trip')
                ->schema([
                    TextInput::make('title')->hidden(),
                    TextInput::make('title_trans.en')->label('Title (EN)')->required()->maxLength(255),
                    TextInput::make('title_trans.ar')->label('Title (AR)'),
                    TextInput::make('slug')->unique(ignoreRecord: true)->maxLength(255),
                    Select::make('lang')->label('Language')->options(['en' => 'EN', 'ar' => 'AR'])->default('en')->required(),
                    Select::make('city_id')->label('Destination (choose existing)')->options(City::pluck('name', 'id'))->searchable()->placeholder('Select a city'),
                    TextInput::make('city_name')->label('Destination (custom)')->helperText('If set, this text will be used as the destination name instead of the linked city'),
                    TextInput::make('price')->numeric()->prefix('SAR'),
                    TextInput::make('duration')->numeric()->suffix('days'),
                    TextInput::make('type')->maxLength(100),
                    DatePicker::make('start_date'),
                    DatePicker::make('end_date'),
                    FileUpload::make('video')->disk('public')->directory('videos'),
                    Textarea::make('description')->rows(3)->helperText('Legacy single-language field'),
                    Textarea::make('description_trans.en')->label('Description (EN)')->rows(3),
                    Textarea::make('description_trans.ar')->label('Description (AR)')->rows(3),
                    Forms\Components\TagsInput::make('highlights')->label('Highlights')->placeholder('Add a highlight and press Enter'),
                    TextInput::make('group_size')->label('Group Size'),
                    FileUpload::make('image')
                        ->disk('public')
                        ->directory('trips')
                        ->image(),
                    Toggle::make('is_active')->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('city.name')->label('Destination')->sortable(),
                TextColumn::make('price')->money('SAR'),
                IconColumn::make('is_active')->label('Active')->boolean(),
                TextColumn::make('created_at')->dateTime('M d, Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
