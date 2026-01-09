<?php

namespace App\Filament\Resources\IslandDestinationResource\Pages;

use App\Filament\Resources\IslandDestinationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIslandDestination extends EditRecord
{
    protected static string $resource = IslandDestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
