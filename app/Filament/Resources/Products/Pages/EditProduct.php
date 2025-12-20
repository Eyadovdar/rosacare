<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

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
        $translatableFields = [
            'name', 'description', 'short_description', 
            'meta_title', 'meta_description', 'meta_keywords'
        ];
        $arrayFields = ['ingredients', 'benefits', 'usage_instructions'];
        
        foreach ($translatableFields as $field) {
            foreach (['ar', 'en'] as $locale) {
                if ($record->hasTranslation($locale)) {
                    $data[$field . ':' . $locale] = $record->translate($locale)?->{$field};
                }
            }
        }

        foreach ($arrayFields as $field) {
            foreach (['ar', 'en'] as $locale) {
                if ($record->hasTranslation($locale)) {
                    $value = $record->translate($locale)?->{$field};
                    if (is_array($value)) {
                        $data[$field . ':' . $locale] = array_map(fn($item) => ['item' => $item], $value);
                    }
                }
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
        $translatableFields = [
            'name', 'description', 'short_description', 
            'meta_title', 'meta_description', 'meta_keywords'
        ];
        $arrayFields = ['ingredients', 'benefits', 'usage_instructions'];
        
        foreach ($translatableFields as $field) {
            if (isset($data[$field . ':ar'])) {
                $translations['ar'][$field] = $data[$field . ':ar'];
            }
            if (isset($data[$field . ':en'])) {
                $translations['en'][$field] = $data[$field . ':en'];
            }
        }

        foreach ($arrayFields as $field) {
            if (isset($data[$field . ':ar']) && is_array($data[$field . ':ar'])) {
                $translations['ar'][$field] = array_column($data[$field . ':ar'], 'item');
            }
            if (isset($data[$field . ':en']) && is_array($data[$field . ':en'])) {
                $translations['en'][$field] = array_column($data[$field . ':en'], 'item');
            }
        }

        return $translations;
    }

    protected function removeTranslationFields(array $data): array
    {
        $translatableFields = [
            'name', 'description', 'short_description', 
            'meta_title', 'meta_description', 'meta_keywords'
        ];
        $arrayFields = ['ingredients', 'benefits', 'usage_instructions'];
        $allFields = array_merge($translatableFields, $arrayFields);
        
        foreach ($allFields as $field) {
            unset($data[$field . ':ar'], $data[$field . ':en']);
        }

        return $data;
    }
}
