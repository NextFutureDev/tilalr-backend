<?php

namespace App\Filament\Resources\CustomPaymentOfferResource\Pages;

use App\Filament\Resources\CustomPaymentOfferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomPaymentOffers extends ListRecords
{
    protected static string $resource = CustomPaymentOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
