<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Project Content')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('description.en')
                                    ->label('Description (English)')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'strike', 'bulletList', 'orderedList', 'link', 'blockquote', 'codeBlock', 'h2', 'h3', 'undo', 'redo'
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('العربية')
                            ->schema([
                                TextInput::make('name.ar')
                                    ->label('الاسم (العربية)')
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('description.ar')
                                    ->label('الوصف (العربية)')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'strike', 'bulletList', 'orderedList', 'link', 'blockquote', 'codeBlock', 'h2', 'h3', 'undo', 'redo'
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('General Settings')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->disk('public')
                            ->image()
                            ->previewable()
                            ->openable()
                            ->downloadable()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->maxSize(2048)
                            ->directory('projects/images')
                            ->visibility('public'),
                        DatePicker::make('project_date')
                            ->label('Project Date'),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Project')
                            ->helperText('Mark this project as featured (max 3 featured projects allowed)')
                            ->afterStateUpdated(function ($state, $set, $get, $context) {
                                if ($context === 'create' || $context === 'edit') {
                                    // Check if we're trying to set as featured
                                    if ($state) {
                                        // Count current featured projects (excluding this one if editing)
                                        $currentFeaturedCount = \App\Models\Project::where('is_featured', true)->count();
                                        if ($context === 'edit') {
                                            $currentFeaturedCount = \App\Models\Project::where('is_featured', true)
                                                ->where('id', '!=', request()->route('record'))
                                                ->count();
                                        }
                                        
                                        if ($currentFeaturedCount >= 3) {
                                            $set('is_featured', false);
                                            \Filament\Notifications\Notification::make()
                                                ->warning()
                                                ->title('Maximum Featured Projects Reached')
                                                ->body('You can only have up to 3 featured projects at a time.')
                                                ->send();
                                        }
                                    }
                                }
                            }),
                    ])
                    ->columns(2),
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
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->getStateUsing(function (Project $record) {
                        $text = $record->getTranslation('description', app()->getLocale());
                        $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5);
                        $stripped = strip_tags($decoded);
                        return preg_replace('/\s+/u', ' ', $stripped);
                    })
                    ->limit(40),
                Tables\Columns\TextColumn::make('project_date')
                    ->label('Project Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Projects')
                    ->placeholder('All Projects')
                    ->trueLabel('Featured Only')
                    ->falseLabel('Not Featured'),
                Tables\Filters\SelectFilter::make('project_date')
                    ->options([
                        'this_month' => 'This Month',
                        'last_month' => 'Last Month',
                        'this_year' => 'This Year',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            'this_month' => $query->whereMonth('project_date', now()->month),
                            'last_month' => $query->whereMonth('project_date', now()->subMonth()->month),
                            'this_year' => $query->whereYear('project_date', now()->year),
                            default => $query,
                        };
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
            ->paginated([10, 25, 50, 100]);
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
