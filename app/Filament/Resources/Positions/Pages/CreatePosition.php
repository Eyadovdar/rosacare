<?php

namespace App\Filament\Resources\Positions\Pages;

use App\Filament\Resources\Positions\PositionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePosition extends CreateRecord
{
    protected static string $resource = PositionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
        }

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

