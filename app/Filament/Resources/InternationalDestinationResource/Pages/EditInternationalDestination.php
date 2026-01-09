<?php

namespace App\Filament\Resources\InternationalDestinationResource\Pages;

use App\Filament\Resources\InternationalDestinationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternationalDestination extends EditRecord
{
    protected static string $resource = InternationalDestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
