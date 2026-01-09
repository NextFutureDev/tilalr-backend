<?php

namespace App\Filament\Resources\InternationalPackageResource\Pages;

use App\Filament\Resources\InternationalPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternationalPackage extends EditRecord
{
    protected static string $resource = InternationalPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
