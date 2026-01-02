<?php

namespace App\Filament\Resources\Welcomes\Pages;

use App\Filament\Resources\Welcomes\WelcomeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateWelcome extends CreateRecord
{
    protected static string $resource = WelcomeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store media file path - FileUpload stores paths as strings (single) or arrays (multiple)
        $this->welcomeImage = is_array($data['image'] ?? null) 
            ? ($data['image'][0] ?? null) 
            : ($data['image'] ?? null);

        // Store welcome details with their translations
        $this->welcomeDetails = $data['welcomeDetails'] ?? [];

        // Remove translation fields from form data (image will be saved directly)
        unset($data['welcomeDetails']);

        // Set image path directly in data
        if ($this->welcomeImage && is_string($this->welcomeImage)) {
            $data['image'] = $this->welcomeImage;
            // Ensure file has public visibility
            if (Storage::disk('public')->exists($this->welcomeImage)) {
                Storage::disk('public')->setVisibility($this->welcomeImage, 'public');
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

        // Save welcome details with translations
        if (!empty($this->welcomeDetails)) {
            foreach ($this->welcomeDetails as $detailData) {
                $this->saveWelcomeDetail($detailData);
            }
        }
    }

    protected $welcomeImage = null;
    protected array $welcomeDetails = [];

    protected function saveWelcomeDetail(array $detailData): void
    {
        // Extract translations
        $translations = [];
        $translatableFields = ['title', 'description', 'button_text'];
        
        foreach ($translatableFields as $field) {
            if (isset($detailData[$field . ':ar'])) {
                $translations['ar'][$field] = $detailData[$field . ':ar'];
            }
            if (isset($detailData[$field . ':en'])) {
                $translations['en'][$field] = $detailData[$field . ':en'];
            }
        }

        // Get image path
        $detailImage = is_array($detailData['image'] ?? null) 
            ? ($detailData['image'][0] ?? null) 
            : ($detailData['image'] ?? null);

        // Remove translation fields from detail data
        foreach ($translatableFields as $field) {
            unset($detailData[$field . ':ar'], $detailData[$field . ':en']);
        }

        // Set image path directly
        if ($detailImage && is_string($detailImage)) {
            $detailData['image'] = $detailImage;
            // Ensure file has public visibility
            if (Storage::disk('public')->exists($detailImage)) {
                Storage::disk('public')->setVisibility($detailImage, 'public');
            }
        } else {
            $detailData['image'] = null;
        }

        // Create welcome detail
        $welcomeDetail = $this->record->welcomeDetails()->create($detailData);

        // Save translations
        if (!empty($translations)) {
            foreach ($translations as $locale => $fields) {
                $welcomeDetail->translateOrNew($locale)->fill($fields)->save();
            }
        }
    }

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
