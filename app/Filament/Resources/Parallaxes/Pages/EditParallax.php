<?php

namespace App\Filament\Resources\Parallaxes\Pages;

use App\Filament\Resources\Parallaxes\ParallaxResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditParallax extends EditRecord
{
    protected static string $resource = ParallaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load translations into form data
        $record = $this->record;
        $translatableFields = ['title', 'description'];

        foreach ($translatableFields as $field) {
            foreach (['ar', 'en'] as $locale) {
                if ($record->hasTranslation($locale)) {
                    $data[$field . ':' . $locale] = $record->translate($locale)?->{$field};
                }
            }
        }

        // Load parallax image directly from database column
        if ($record->image) {
            $data['image'] = $record->image;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store image file path - FileUpload stores file paths as strings (single) or arrays (multiple)
        $this->parallaxImage = is_array($data['image'] ?? null) 
            ? ($data['image'][0] ?? null) 
            : ($data['image'] ?? null);

        // Set image path directly in data
        if ($this->parallaxImage && is_string($this->parallaxImage)) {
            $data['image'] = $this->parallaxImage;
            // Ensure file has public visibility
            if (Storage::disk('public')->exists($this->parallaxImage)) {
                Storage::disk('public')->setVisibility($this->parallaxImage, 'public');
            }
        } elseif (empty($this->parallaxImage)) {
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
