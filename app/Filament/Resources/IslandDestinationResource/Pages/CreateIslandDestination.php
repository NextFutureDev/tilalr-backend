<?php

namespace App\Filament\Resources\IslandDestinationResource\Pages;

use App\Filament\Resources\IslandDestinationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIslandDestination extends CreateRecord
{
    protected static string $resource = IslandDestinationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure type is always set to 'local'
        $data['type'] = 'local';
        
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['title_en'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title_en']);
        }
        
        return $data;
    }
}
