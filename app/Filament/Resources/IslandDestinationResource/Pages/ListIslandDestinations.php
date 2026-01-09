<?php

namespace App\Filament\Resources\IslandDestinationResource\Pages;

use App\Filament\Resources\IslandDestinationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIslandDestinations extends ListRecords
{
    protected static string $resource = IslandDestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
