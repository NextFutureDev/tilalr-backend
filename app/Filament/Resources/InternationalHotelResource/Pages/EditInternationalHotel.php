<?php

namespace App\Filament\Resources\InternationalHotelResource\Pages;

use App\Filament\Resources\InternationalHotelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternationalHotel extends EditRecord
{
    protected static string $resource = InternationalHotelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
