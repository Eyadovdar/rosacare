<?php

namespace App\Filament\Resources\Announcements\Pages;

use App\Filament\Resources\Announcements\AnnouncementResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store image path to save after creation
        // Filament FileUpload stores file paths as strings (single) or arrays (multiple)
        $this->announcementImage = is_array($data['image'] ?? null)
            ? ($data['image'][0] ?? null)
            : ($data['image'] ?? null);

        // Remove image and translation fields from form data
        // The image will be saved directly to the image column in afterCreate
        unset($data['image']);

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

        // Save announcement image path directly to the image column
        if ($this->announcementImage && is_string($this->announcementImage)) {
            // Ensure file has public visibility
            if (Storage::disk('public')->exists($this->announcementImage)) {
                Storage::disk('public')->setVisibility($this->announcementImage, 'public');
            }
            
            // Update the record with the image path
            $this->record->update(['image' => $this->announcementImage]);
        }
    }

    protected $announcementImage = null;

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
