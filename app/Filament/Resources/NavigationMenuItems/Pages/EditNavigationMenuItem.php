<?php

namespace App\Filament\Resources\NavigationMenuItems\Pages;

use App\Filament\Resources\NavigationMenuItems\NavigationMenuItemResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNavigationMenuItem extends EditRecord
{
    protected static string $resource = NavigationMenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load translations into form data
        $record = $this->record;
        
        foreach (['ar', 'en'] as $locale) {
            if ($record->hasTranslation($locale)) {
                $data['label:' . $locale] = $record->translate($locale)?->label;
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);
        return $this->removeTranslationFields($data);
    }

    protected function afterSave(): void
    {
        // Save translations after record is updated
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
