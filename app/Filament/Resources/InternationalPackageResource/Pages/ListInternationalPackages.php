<?php

namespace App\Filament\Resources\InternationalPackageResource\Pages;

use App\Filament\Resources\InternationalPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternationalPackages extends ListRecords
{
    protected static string $resource = InternationalPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
