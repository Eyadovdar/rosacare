<?php

namespace App\Filament\Resources\Parallaxes\Pages;

use App\Filament\Resources\Parallaxes\ParallaxResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateParallax extends CreateRecord
{
    protected static string $resource = ParallaxResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store image file path - FileUpload stores paths as strings (single) or arrays (multiple)
        $this->parallaxImage = is_array($data['image'] ?? null) 
            ? ($data['image'][0] ?? null) 
            : ($data['image'] ?? null);

        // Remove translation fields from form data (image will be saved directly)
        // Set image path directly in data
        if ($this->parallaxImage && is_string($this->parallaxImage)) {
            $data['image'] = $this->parallaxImage;
            // Ensure file has public visibility
            if (Storage::disk('public')->exists($this->parallaxImage)) {
                Storage::disk('public')->setVisibility($this->parallaxImage, 'public');
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

    protected $parallaxImage = null;

    protected array $translations = [];

    protected function extractTranslations(array $data): array
    {
        $translations = [];
        $translatableFields = ['title', 'description'];
        
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
        $translatableFields = ['title', 'description'];
        
        foreach ($translatableFields as $field) {
            unset($data[$field . ':ar'], $data[$field . ':en']);
        }

        return $data;
    }
}
