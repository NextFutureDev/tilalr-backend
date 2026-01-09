<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Resources\Pages\ListRecords;

use Illuminate\Database\Eloquent\Builder;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()->label('New Offer'),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        try {
            \Illuminate\Support\Facades\Log::debug('ListOffers::getTableQuery called — Offer count: ' . \App\Models\Offer::count());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::debug('ListOffers::getTableQuery error: ' . $e->getMessage());
        }

        return \App\Models\Offer::query();
    }
}
