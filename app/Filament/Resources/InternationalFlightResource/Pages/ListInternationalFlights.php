<?php

namespace App\Filament\Resources\InternationalFlightResource\Pages;

use App\Filament\Resources\InternationalFlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternationalFlights extends ListRecords
{
    protected static string $resource = InternationalFlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
