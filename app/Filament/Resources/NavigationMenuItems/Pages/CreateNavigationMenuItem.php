<?php

namespace App\Filament\Resources\NavigationMenuItems\Pages;

use App\Filament\Resources\NavigationMenuItems\NavigationMenuItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNavigationMenuItem extends CreateRecord
{
    protected static string $resource = NavigationMenuItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);
        return $this->removeTranslationFields($data);
    }

    protected function afterCreate(): void
    {
        // Save translations after record is created
        if (isset($this->translations)) {
            foreach ($this->translations as $locale => $fields) {
                $this->record->translateOrNew($locale)->fill($fields)->save();
            }
        }
    }

    protected array $translations = [];

    protected function extractTranslations(array $data): array
    {
        $translations = [];
        
        if (isset($data['label:ar'])) {
            $translations['ar']['label'] = $data['label:ar'];
        }
        if (isset($data['label:en'])) {
            $translations['en']['label'] = $data['label:en'];
        }

        return $translations;
    }

    protected function removeTranslationFields(array $data): array
    {
        unset($data['label:ar'], $data['label:en']);
        return $data;
    }
}
