<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\Concerns\HasResourcePermissions;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Offer as OfferModel;

class OfferResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Offers';
    
    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Language Tools')
                ->schema([
                    Forms\Components\Toggle::make('copy_en_to_ar')
                        ->label(__('offers.copy_en_to_ar'))
                        ->helperText(__('offers.copy_helper'))
                        ->dehydrated(false)
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set, $get, $context) {
                            if ($state && ($context === 'create' || $context === 'edit')) {
                                $set('title_ar', $get('title_en'));
                                $set('description_ar', $get('description_en'));
                                $set('location_ar', $get('location_en'));
                                $set('duration_ar', $get('duration_en') ?? $get('duration'));
                                $set('group_size_ar', $get('group_size_en') ?? $get('group_size'));
                                $set('badge_ar', $get('badge_en') ?? $get('badge'));
                                $set('features_ar', $get('features_en') ?? $get('features') ?? []);
                                $set('highlights_ar', $get('highlights_en') ?? $get('highlights') ?? []);
                                // reset toggle so it can be used again
                                $set('copy_en_to_ar', false);
                            }
                        }),
                ])->columns(1),

            Forms\Components\Tabs::make('Content')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('English')
                        ->schema([
                            // Basic fields
                            Forms\Components\TextInput::make('title_en')->required()->label('Title (EN)'),
                            Forms\Components\Textarea::make('description_en')->label('Description (EN)'),
                            Forms\Components\TextInput::make('location_en')->label('Location (EN)'),

                            // Details
                            Forms\Components\TextInput::make('duration_en')->label('Duration (EN)'),
                            Forms\Components\TextInput::make('group_size_en')->label('Group Size (EN)'),
                            Forms\Components\TextInput::make('badge_en')->label('Badge (EN)'),
                            Forms\Components\TagsInput::make('features_en')->label('Features (EN)')->placeholder('Add a feature and press Enter'),
                            Forms\Components\TagsInput::make('highlights_en')->label('Highlights (EN)')->placeholder('Add a highlight and press Enter'),
                        ])->columnSpanFull(),

                    Forms\Components\Tabs\Tab::make('العربية')
                        ->schema([
                            // Basic fields (Arabic)
                            Forms\Components\TextInput::make('title_ar')->required()->label('Title (AR)')->extraAttributes(['dir'=>'rtl']),
                            Forms\Components\Textarea::make('description_ar')->label('Description (AR)')->extraAttributes(['dir'=>'rtl']),
                            Forms\Components\TextInput::make('location_ar')->label('Location (AR)')->extraAttributes(['dir'=>'rtl']),

                            // Details (Arabic)
                            Forms\Components\TextInput::make('duration_ar')->label('Duration (AR)')->extraAttributes(['dir' => 'rtl']),
                            Forms\Components\TextInput::make('group_size_ar')->label('Group Size (AR)')->extraAttributes(['dir' => 'rtl']),
                            Forms\Components\TextInput::make('badge_ar')->label('Badge (AR)')->extraAttributes(['dir' => 'rtl']),
                            Forms\Components\TagsInput::make('features_ar')->label('Features (AR)')->placeholder('أضف ميزة ثم اضغط Enter')->extraAttributes(['dir' => 'rtl']),
                            Forms\Components\TagsInput::make('highlights_ar')->label('Highlights (AR)')->placeholder('أضف نقطة ثم اضغط Enter')->extraAttributes(['dir' => 'rtl']),
                        ])->columnSpanFull(),
                ])->columnSpanFull(),

            // Keep discount as a single (non-localized) field for now
            Forms\Components\Section::make('Pricing')
                ->schema([
                    Forms\Components\TextInput::make('discount')->label('Discount'),
                ])->columns(1),

            Forms\Components\Section::make('Media & Status')
                ->schema([
                    Forms\Components\FileUpload::make('image')->image()->directory('offers')->label('Image'),
                    Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {        if (app()->environment('local')) {
            try {
                Log::debug('OfferResource::table called — Offer count: ' . OfferModel::count());
            } catch (\Throwable $e) {
                Log::debug('OfferResource::table debug failed: ' . $e->getMessage());
            }
        }
        return $table->columns([
            Tables\Columns\TextColumn::make('title_en')->label('Title (EN)')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('duration')->label('Duration'),
            Tables\Columns\TextColumn::make('discount')->label('Discount'),
            Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }


    public static function getEloquentQuery(): Builder
    {
        // Use a direct unscoped query to avoid any global scopes or accidental filters
        return OfferModel::query();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
