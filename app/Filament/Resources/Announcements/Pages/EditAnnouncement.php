<?php

namespace App\Filament\Resources\Announcements\Pages;

use App\Filament\Resources\Announcements\AnnouncementResource;
use App\Models\Media;
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

        // Load announcement image using the image relationship
        $image = $record->image;
        if ($image instanceof Media) {
            $data['image'] = ($image->path ? $image->path . '/' : '') . $image->file_name;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store media file to save after update
        // Filament FileUpload stores file paths as strings (single) or arrays (multiple)
        $this->announcementImage = is_array($data['image'] ?? null)
            ? ($data['image'][0] ?? null)
            : ($data['image'] ?? null);

        // Remove media fields from form data
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

        // Delete existing image media for this announcement
        $existingImage = $this->record->image;
        if ($existingImage instanceof Media) {
            $existingImage->delete();
        }

        // Save announcement image
        if ($this->announcementImage && is_string($this->announcementImage)) {
            $this->saveMediaFile($this->announcementImage, 'announcements', 0);
        }
    }

    protected $announcementImage = null;

    protected function saveMediaFile(string $filePath, string $collection, int $sortOrder): void
    {
        try {
            // FileUpload stores paths relative to storage/app/public
            // Check if file exists
            if (!Storage::disk('public')->exists($filePath)) {
                \Log::warning("Media file not found: {$filePath}");
                return;
            }

            // Ensure file has public visibility
            Storage::disk('public')->setVisibility($filePath, 'public');

            $fileInfo = pathinfo($filePath);
            $dirname = $fileInfo['dirname'] !== '.' ? $fileInfo['dirname'] : '';

            Media::create([
                'model_type' => get_class($this->record),
                'model_id' => $this->record->id,
                'collection_name' => $collection,
                'file_name' => $fileInfo['basename'],
                'mime_type' => Storage::disk('public')->mimeType($filePath) ?: 'image/jpeg',
                'size' => Storage::disk('public')->size($filePath),
                'disk' => 'public',
                'path' => $dirname,
                'sort_order' => $sortOrder,
            ]);
        } catch (\Exception $e) {
            \Log::error("Failed to save media file: {$filePath}", [
                'error' => $e->getMessage(),
                'collection' => $collection,
            ]);
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
