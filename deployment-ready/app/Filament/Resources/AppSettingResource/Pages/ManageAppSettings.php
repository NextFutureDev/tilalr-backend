<?php

namespace App\Filament\Resources\AppSettingResource\Pages;

use App\Filament\Resources\AppSettingResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;
use App\Models\AppSetting;

class ManageAppSettings extends ManageRecords
{
    protected static string $resource = AppSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->hidden(fn () => AppSetting::query()->exists()),
        ];
    }
}


