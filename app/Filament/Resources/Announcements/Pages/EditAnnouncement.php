<?php

namespace App\Filament\Resources\Announcements\Pages;

use App\Filament\Resources\Announcements\AnnouncementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditAnnouncement extends EditRecord
{
    protected static string $resource = AnnouncementResource::class;

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
        $translatableFields = ['title', 'description', 'button_text'];

        foreach ($translatableFields as $field) {
            foreach (['ar', 'en'] as $locale) {
                if ($record->hasTranslation($locale)) {
                    $data[$field . ':' . $locale] = $record->translate($locale)?->{$field};
                }
            }
        }

        // Load announcement image path directly from the image column
        if ($record->image) {
            $data['image'] = $record->image;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store image path to save after update
        // Filament FileUpload stores file paths as strings (single) or arrays (multiple)
        $this->announcementImage = is_array($data['image'] ?? null)
            ? ($data['image'][0] ?? null)
            : ($data['image'] ?? null);

        // Store old image path for deletion if a new image is uploaded
        $this->oldImagePath = $this->record->image;

        // Remove image field from form data
        // The image will be saved directly to the image column in afterSave
        unset($data['image']);

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

        // Handle image update
        if ($this->announcementImage && is_string($this->announcementImage)) {
            // Delete old image file if it exists and is different from the new one
            if ($this->oldImagePath && $this->oldImagePath !== $this->announcementImage) {
                if (Storage::disk('public')->exists($this->oldImagePath)) {
                    Storage::disk('public')->delete($this->oldImagePath);
                }
            }

            // Ensure new file has public visibility
            if (Storage::disk('public')->exists($this->announcementImage)) {
                Storage::disk('public')->setVisibility($this->announcementImage, 'public');
            }

            // Update the record with the new image path
            $this->record->update(['image' => $this->announcementImage]);
        } elseif ($this->announcementImage === null && $this->oldImagePath) {
            // If image was removed, delete the old file and clear the column
            if (Storage::disk('public')->exists($this->oldImagePath)) {
                Storage::disk('public')->delete($this->oldImagePath);
            }
            $this->record->update(['image' => null]);
        }
    }

    protected $announcementImage = null;
    protected $oldImagePath = null;

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
