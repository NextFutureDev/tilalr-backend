<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Filament\Resources\AboutSectionResource\RelationManagers;
use App\Models\AboutSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = -1;
    
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
    
    protected static ?string $navigationLabel = 'About Section';
    
    protected static ?string $modelLabel = 'About Section';
    
    protected static ?string $pluralModelLabel = 'About Sections';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main Content')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_ar')
                            ->label('Title (Arabic)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('paragraph_en')
                            ->label('Paragraph (English)')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('paragraph_ar')
                            ->label('Paragraph (Arabic)')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Mission Card')
                    ->schema([
                        Forms\Components\TextInput::make('mission_title_en')
                            ->label('Mission Title (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mission_title_ar')
                            ->label('Mission Title (Arabic)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('mission_paragraph_en')
                            ->label('Mission Paragraph (English)')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('mission_paragraph_ar')
                            ->label('Mission Paragraph (Arabic)')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Vision Card')
                    ->schema([
                        Forms\Components\TextInput::make('vision_title_en')
                            ->label('Vision Title (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('vision_title_ar')
                            ->label('Vision Title (Arabic)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('vision_paragraph_en')
                            ->label('Vision Paragraph (English)')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('vision_paragraph_ar')
                            ->label('Vision Paragraph (Arabic)')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active about sections will be displayed on the website'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (English)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title_ar')
                    ->label('Title (Arabic)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mission_title_en')
                    ->label('Mission Title (English)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vision_title_en')
                    ->label('Vision Title (English)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->native(false),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutSections::route('/'),
            'create' => Pages\CreateAboutSection::route('/create'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}
