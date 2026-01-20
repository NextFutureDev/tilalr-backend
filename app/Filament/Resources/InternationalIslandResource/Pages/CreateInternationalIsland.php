<?php

namespace App\Filament\Resources\InternationalIslandResource\Pages;

use App\Filament\Resources\InternationalIslandResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInternationalIsland extends CreateRecord
{
    protected static string $resource = InternationalIslandResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure type is always set to 'international'
        $data['type'] = 'international';
        
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['title_en'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title_en']);
        }
        
        return $data;
    }
}