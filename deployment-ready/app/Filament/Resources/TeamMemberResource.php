<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Resources\TeamMemberResource\RelationManagers;
use App\Models\TeamMember;
use App\Models\Role;
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
use Filament\Forms\Components\Select;


class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Team Management';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Role Selection')
                    ->schema([
                        Select::make('role_id')
                            ->label('Role')
                            ->options(Role::active()->ordered()->get()->pluck('title_en', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Select a role for this team member'),
                    ]),
                    
                Tabs::make('Team Member Content')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('bio.en')
                                    ->label('Bio (English)')
                                    ->required()
                                    ->maxLength(1000)
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('العربية')
                            ->schema([
                                TextInput::make('name.ar')
                                    ->label('الاسم (العربية)')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('bio.ar')
                                    ->label('السيرة الذاتية (العربية)')
                                    ->required()
                                    ->maxLength(1000)
                                    ->columnSpanFull(),
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
                            ->imageCropAspectRatio('1:1')
                            ->maxSize(2048)
                            ->directory('team-members/images')
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
                Tables\Columns\TextColumn::make('roleRelation.title_en')
                    ->label('Role')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('bio')
                    ->label('Bio')
                    ->limit(40),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
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
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
