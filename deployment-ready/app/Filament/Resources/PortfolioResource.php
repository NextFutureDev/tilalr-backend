<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Filament\Resources\PortfolioResource\RelationManagers;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Portfolio Content')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('category.en')
                                    ->label('Category (English)')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Tabs\Tab::make('العربية')
                            ->schema([
                                TextInput::make('name.ar')
                                    ->label('الاسم (العربية)')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('category.ar')
                                    ->label('الفئة (العربية)')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('General Settings')
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->image()
                            ->previewable()
                            ->openable()
                            ->downloadable()
                            ->imageResizeMode('cover')
                            ->maxSize(5120)
                            ->imageEditor()
                            ->imageCropAspectRatio('3:2')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('200')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->directory('portfolio')
                            ->visibility('public'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('image')
                    ->label('Image')
                    ->view('admin.columns.image')
                    ->getStateUsing(fn($record) => $record->image),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable(),
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }

    public static function getNavigationLabel(): string
    {
        return 'Portfolios';
    }

    public static function getModelLabel(): string
    {
        return 'Portfolio';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Portfolios';
    }
}
