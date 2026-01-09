<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IslandDestinationResource\Pages;
use App\Models\IslandDestination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IslandDestinationResource extends Resource
{
    protected static ?string $model = IslandDestination::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    
    protected static ?string $navigationLabel = 'Island Destinations';
    
    protected static ?string $modelLabel = 'Island Destination';
    
    protected static ?string $navigationGroup = 'Destinations';

    // Executive Manager, Consultant, and Super Admin can access
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && ($user->hasRole('executive_manager') || $user->hasRole('consultant') || $user->hasRole('super_admin'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Destination Type')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'local' => 'Local (Saudi Arabia)',
                                'international' => 'International',
                            ])
                            ->label('Destination Type')
                            ->helperText('Select whether this is a local (Saudi) or international destination')
                            ->searchable(),
                    ])->columns(1),

                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->required()
                            ->label('Title (English)'),
                        Forms\Components\TextInput::make('title_ar')
                            ->required()
                            ->label('Title (Arabic)')
                            ->extraAttributes(['dir' => 'rtl']),
                    ])->columns(2),

                Forms\Components\Section::make('Description & Location')
                    ->schema([
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->rows(3),
                        Forms\Components\Textarea::make('description_ar')
                            ->label('Description (Arabic)')
                            ->rows(3)
                            ->extraAttributes(['dir' => 'rtl']),
                        Forms\Components\TextInput::make('location_en')
                            ->label('Location (English)'),
                        Forms\Components\TextInput::make('location_ar')
                            ->label('Location (Arabic)')
                            ->extraAttributes(['dir' => 'rtl']),
                    ])->columns(2),

                Forms\Components\Section::make('Duration & Group Size')
                    ->schema([
                        Forms\Components\TextInput::make('duration_en')
                            ->label('Duration (English)'),
                        Forms\Components\TextInput::make('duration_ar')
                            ->label('Duration (Arabic)')
                            ->extraAttributes(['dir' => 'rtl']),
                        Forms\Components\TextInput::make('groupSize_en')
                            ->label('Group Size (English)'),
                        Forms\Components\TextInput::make('groupSize_ar')
                            ->label('Group Size (Arabic)')
                            ->extraAttributes(['dir' => 'rtl']),
                    ])->columns(2),

                Forms\Components\Section::make('Features')
                    ->schema([
                        Forms\Components\TagsInput::make('features_en')
                            ->label('Features (English)')
                            ->placeholder('Enter features and press Enter'),
                        Forms\Components\TagsInput::make('features_ar')
                            ->label('Features (Arabic)')
                            ->placeholder('أدخل الميزات واضغط Enter')
                            ->extraAttributes(['dir' => 'rtl']),
                    ])->columns(2),

                Forms\Components\Section::make('Pricing & Rating')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->label('Price (USD)'),
                        Forms\Components\TextInput::make('rating')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(5)
                            ->label('Rating (0-5)'),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Status')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('islands')
                            ->label('Island Image'),
                        Forms\Components\Toggle::make('active')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'local' => 'success',
                        'international' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'local' => 'Local',
                        'international' => 'International',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location_en')
                    ->label('Location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('usd', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'local' => 'Local',
                        'international' => 'International',
                    ])
                    ->label('Destination Type'),
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Active'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIslandDestinations::route('/'),
            'create' => Pages\CreateIslandDestination::route('/create'),
            'edit' => Pages\EditIslandDestination::route('/{record}/edit'),
        ];
    }
}
