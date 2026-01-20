<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Models\Training;
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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Training Programs';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = 3;

    // Ensure the resource is always visible in the navigation
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getNavigationLabel(): string
    {
        return 'Training Programs';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Training Content')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('short_description')
                                    ->label('Short Description (English)')
                                    ->maxLength(255)
                                    ->rows(3),
                                RichEditor::make('description')
                                    ->label('Description (English)')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'strike', 'bulletList', 'orderedList', 'link', 'blockquote', 'codeBlock', 'h2', 'h3', 'undo', 'redo'
                                    ])
                                    ->columnSpanFull()
                                    ->helperText('Detailed description that appears on the training page'),
                            ]),
                        Tabs\Tab::make('العربية')
                            ->schema([
                                TextInput::make('name_ar')
                                    ->label('الاسم (العربية)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('short_description_ar')
                                    ->label('الوصف المختصر (العربية)')
                                    ->maxLength(255)
                                    ->rows(3),
                                RichEditor::make('description_ar')
                                    ->label('الوصف (العربية)')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'strike', 'bulletList', 'orderedList', 'link', 'blockquote', 'codeBlock', 'h2', 'h3', 'undo', 'redo'
                                    ])
                                    ->columnSpanFull()
                                    ->helperText('وصف تفصيلي يظهر على صفحة التدريب'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('General Settings')
                    ->schema([
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL-friendly identifier, auto-generated from name.'),
                        FileUpload::make('icon')
                            ->label('Card Icon Image')
                            ->disk('public')
                            ->image()
                            ->previewable()
                            ->openable()
                            ->downloadable()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->maxSize(2048)
                            ->directory('trainings/icons')
                            ->visibility('public')
                            ->helperText('Image displayed above the title on the card'),
                        FileUpload::make('image')
                            ->disk('public')
                            ->image()
                            ->previewable()
                            ->openable()
                            ->downloadable()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->maxSize(5120)
                            ->directory('trainings/images')
                            ->visibility('public')
                            ->helperText('Main image for the training page'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('icon')
                    ->label('Icon')
                    ->view('admin.columns.image')
                    ->getStateUsing(fn($record) => $record->icon),
                Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('short_description')->label('Short Description')->limit(60),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime('M d, Y'),
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
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}
