<?php

namespace App\Filament\Resources\Positions\Pages;

use App\Filament\Resources\Positions\PositionResource;
use Filament\Resources\Pages\EditRecord;

class EditPosition extends EditRecord
{
    protected static string $resource = PositionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load translations into form data
        $record = $this->record;
        $translatableFields = ['name', 'description', 'qualifications', 'responsibilities', 'button_text'];

        foreach ($translatableFields as $field) {
            foreach (['ar', 'en'] as $locale) {
                if ($record->hasTranslation($locale)) {
                    $data[$field . ':' . $locale] = $record->translate($locale)?->{$field};
                }
            }
        }

        // Load position image directly from database column
        if ($record->image) {
            $data['image'] = $record->image;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Handle image file path
        $this->positionImage = is_array($data['image'] ?? null)
            ? ($data['image'][0] ?? null)
            : ($data['image'] ?? null);

        // Set image path directly in data
        if ($this->positionImage && is_string($this->positionImage)) {
            $data['image'] = $this->positionImage;
        } elseif (empty($this->positionImage)) {
            // If image was removed, set to null
            $data['image'] = null;
        }

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

    protected $positionImage = null;

    protected array $translations = [];

    protected function extractTranslations(array $data): array
    {
        $translations = [];
        $translatableFields = ['name', 'description', 'qualifications', 'responsibilities', 'button_text'];

        foreach ($translatableFields as $field) {
            if (isset($data[$field . ':ar'])) {
                $translations['ar'][$field] = $data[$field . ':ar'];
            }
            if (isset($data[$field . ':en'])) {
                $translations['en'][$field] = $data[$field . ':en'];
            }
        }

        return $translations;
    }

    protected function removeTranslationFields(array $data): array
    {
        $translatableFields = ['name', 'description', 'qualifications', 'responsibilities', 'button_text'];

        foreach ($translatableFields as $field) {
            unset($data[$field . ':ar'], $data[$field . ':en']);
        }

        return $data;
    }
}

