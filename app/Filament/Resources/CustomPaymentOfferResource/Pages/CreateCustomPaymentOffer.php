<?php

namespace App\Filament\Resources\CustomPaymentOfferResource\Pages;

use App\Filament\Resources\CustomPaymentOfferResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCustomPaymentOffer extends CreateRecord
{
    protected static string $resource = CustomPaymentOfferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate unique link
        $uniqueLink = Str::random(32);
        while (\App\Models\CustomPaymentOffer::where('unique_link', $uniqueLink)->exists()) {
            $uniqueLink = Str::random(32);
        }
        
        $data['unique_link'] = $uniqueLink;
        $data['payment_status'] = 'pending';
        $data['created_by'] = auth()->id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
