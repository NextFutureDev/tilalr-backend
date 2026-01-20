<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSectionResource\Pages;
use App\Filament\Resources\HeroSectionResource\RelationManagers;
use App\Models\HeroSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?string $navigationLabel = 'Hero Section';
    
    protected static ?string $modelLabel = 'Hero Section';
    
    protected static ?string $pluralModelLabel = 'Hero Sections';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\TextInput::make('headline_en')
                            ->label('Headline (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('headline_ar')
                            ->label('Headline (Arabic)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('paragraph_en')
                            ->label('Paragraph (English)')
                            ->required()
                            ->rows(3),
                        Forms\Components\Textarea::make('paragraph_ar')
                            ->label('Paragraph (Arabic)')
                            ->required()
                            ->rows(3),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Social Media Links')
                    ->schema([
                        Forms\Components\TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->placeholder('https://linkedin.com/company/your-company'),
                        Forms\Components\TextInput::make('twitter_url')
                            ->label('X (Twitter) URL')
                            ->url()
                            ->placeholder('https://x.com/your-username'),
                        Forms\Components\TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->placeholder('https://facebook.com/your-page'),
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->placeholder('https://instagram.com/your-username'),
                        Forms\Components\TextInput::make('snapchat_url')
                            ->label('Snapchat URL')
                            ->url()
                            ->placeholder('https://snapchat.com/add/your-username'),
                        Forms\Components\TextInput::make('tiktok_url')
                            ->label('TikTok URL')
                            ->url()
                            ->placeholder('https://tiktok.com/@your-username'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only one hero section can be active at a time'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('headline_en')
                    ->label('Headline (EN)')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('headline_ar')
                    ->label('Headline (AR)')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
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
            'index' => Pages\ListHeroSections::route('/'),
            'create' => Pages\CreateHeroSection::route('/create'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }
}
