<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOffer extends CreateRecord
{
    protected static string $resource = OfferResource::class;

    protected function afterCreate(): void
    {
        try {
            \Illuminate\Support\Facades\Log::debug('CreateOffer::afterCreate - Offer created: ' . json_encode($this->record->toArray()));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::debug('CreateOffer::afterCreate error: ' . $e->getMessage());
        }
    }
}
