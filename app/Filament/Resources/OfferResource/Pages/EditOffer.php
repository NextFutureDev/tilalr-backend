<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Resources\Pages\EditRecord;

class EditOffer extends EditRecord
{
    protected static string $resource = OfferResource::class;

    protected function afterSave(): void
    {
        try {
            \Illuminate\Support\Facades\Log::debug('EditOffer::afterSave - Offer saved: ' . json_encode($this->record->toArray()));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::debug('EditOffer::afterSave error: ' . $e->getMessage());
        }
    }
}
