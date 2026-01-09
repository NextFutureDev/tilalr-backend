<?php

namespace App\Filament\Resources\InternationalDestinationResource\Pages;

use App\Filament\Resources\InternationalDestinationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternationalDestinations extends ListRecords
{
    protected static string $resource = InternationalDestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
