<?php

namespace App\Filament\Resources\InternationalIslandResource\Pages;

use App\Filament\Resources\InternationalIslandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternationalIslands extends ListRecords
{
    protected static string $resource = InternationalIslandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}