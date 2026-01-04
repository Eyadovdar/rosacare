<?php

namespace App\Filament\Resources\Heroes\Pages;

use App\Filament\Resources\Heroes\HeroResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateHero extends CreateRecord
{
    protected static string $resource = HeroResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store media file path - FileUpload stores paths as strings (single) or arrays (multiple)
        $this->heroImage = is_array($data['image'] ?? null) 
            ? ($data['image'][0] ?? null) 
            : ($data['image'] ?? null);

        // Remove translation fields from form data (image will be saved directly)
        // Set image path directly in data
        if ($this->heroImage && is_string($this->heroImage)) {
            $data['image'] = $this->heroImage;
            // Ensure file has public visibility
            if (Storage::disk('public')->exists($this->heroImage)) {
                Storage::disk('public')->setVisibility($this->heroImage, 'public');
            }
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

    protected $heroImage = null;

    protected array $translations = [];

    protected function extractTranslations(array $data): array
    {
        $translations = [];
        $translatableFields = ['title', 'description', 'button_text'];
        
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
        $translatableFields = ['title', 'description', 'button_text'];
        
        foreach ($translatableFields as $field) {
            unset($data[$field . ':ar'], $data[$field . ':en']);
        }

        return $data;
    }
}
