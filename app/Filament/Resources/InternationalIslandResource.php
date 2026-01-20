<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternationalIslandResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\IslandDestination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InternationalIslandResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = IslandDestination::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';
    
    protected static ?string $navigationLabel = 'International Islands';
    
    protected static ?string $modelLabel = 'International Island';
    
    protected static ?string $pluralModelLabel = 'International Islands';
    
    protected static ?string $navigationGroup = 'International Destinations';

    protected static ?int $navigationSort = 5;

    public static function getPermissionKey(): string
    {
        return 'international_islands';
    }

    // Filter query to only show international islands
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'international');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Island Information')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('title_ar')
                            ->label('Title (Arabic)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Hidden::make('type')
                            ->default('international'),

                        Forms\Components\TextInput::make('type_en')
                            ->label('Type (English)')
                            ->default('International Island')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('type_ar')
                            ->label('Type (Arabic)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('location_en')
                            ->label('Location (English)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('location_ar')
                            ->label('Location (Arabic)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->prefix('SAR'),

                        Forms\Components\TextInput::make('rating')
                            ->label('Rating')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1),

                        Forms\Components\FileUpload::make('image')
                            ->label('Island Image')
                            ->disk('public')
                            ->directory('island-destinations'),

                        Forms\Components\Toggle::make('active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Descriptions')
                    ->schema([
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->rows(4),

                        Forms\Components\Textarea::make('description_ar')
                            ->label('Description (Arabic)')
                            ->rows(4),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Details')
                    ->schema([
                        Forms\Components\TagsInput::make('highlights_en')
                            ->label('Highlights (English)')
                            ->placeholder('Add a highlight and press Enter'),

                        Forms\Components\TagsInput::make('highlights_ar')
                            ->label('Highlights (Arabic)')
                            ->placeholder('Add a highlight and press Enter'),

                        Forms\Components\TagsInput::make('includes_en')
                            ->label('Includes (English)')
                            ->placeholder('Add an item and press Enter'),

                        Forms\Components\TagsInput::make('includes_ar')
                            ->label('Includes (Arabic)')
                            ->placeholder('Add an item and press Enter'),

                        Forms\Components\Textarea::make('itinerary_en')
                            ->label('Itinerary (English)')
                            ->rows(3),

                        Forms\Components\Textarea::make('itinerary_ar')
                            ->label('Itinerary (Arabic)')
                            ->rows(3),

                        Forms\Components\TextInput::make('duration_en')
                            ->label('Duration (English)')
                            ->placeholder('e.g., 7 Days / 6 Nights'),

                        Forms\Components\TextInput::make('duration_ar')
                            ->label('Duration (Arabic)'),

                        Forms\Components\TextInput::make('groupSize_en')
                            ->label('Group Size (English)')
                            ->placeholder('e.g., 2-8 People'),

                        Forms\Components\TextInput::make('groupSize_ar')
                            ->label('Group Size (Arabic)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Features')
                    ->schema([
                        Forms\Components\TagsInput::make('features_en')
                            ->label('Features (English)')
                            ->placeholder('Add a feature and press Enter'),

                        Forms\Components\TagsInput::make('features_ar')
                            ->label('Features (Arabic)')
                            ->placeholder('Add a feature and press Enter'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->width(60)
                    ->height(60),

                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_ar')
                    ->label('Title (AR)')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('location_en')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 4.5 => 'success',
                        $state >= 4.0 => 'warning',
                        $state >= 3.0 => 'info',
                        default => 'danger',
                    })
                    ->suffix('/5'),

                Tables\Columns\IconColumn::make('active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Status'),
                
                Tables\Filters\Filter::make('price')
                    ->form([
                        Forms\Components\TextInput::make('price_from')
                            ->numeric()
                            ->label('Price From'),
                        Forms\Components\TextInput::make('price_to')
                            ->numeric()
                            ->label('Price To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['price_from'],
                                fn (Builder $query, $price): Builder => $query->where('price', '>=', $price),
                            )
                            ->when(
                                $data['price_to'],
                                fn (Builder $query, $price): Builder => $query->where('price', '<=', $price),
                            );
                    }),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInternationalIslands::route('/'),
            'create' => Pages\CreateInternationalIsland::route('/create'),
            'edit' => Pages\EditInternationalIsland::route('/{record}/edit'),
        ];
    }
}