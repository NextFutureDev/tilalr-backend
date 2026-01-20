<?php

namespace App\Filament\Resources\InternationalIslandResource\Pages;

use App\Filament\Resources\InternationalIslandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternationalIsland extends EditRecord
{
    protected static string $resource = InternationalIslandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure type remains 'international'
        $data['type'] = 'international';
        
        return $data;
    }
}