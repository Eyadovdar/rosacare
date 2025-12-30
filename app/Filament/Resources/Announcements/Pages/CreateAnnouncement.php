<?php

namespace App\Filament\Resources\Announcements\Pages;

use App\Filament\Resources\Announcements\AnnouncementResource;
use App\Models\Media;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store media file to save after creation
        $this->announcementImage = is_array($data['announcement_image'] ?? null)
            ? ($data['announcement_image'][0] ?? null)
            : ($data['announcement_image'] ?? null);

        // Remove media and translation fields from form data
        unset($data['announcement_image']);

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

        // Save announcement image
        if ($this->announcementImage && is_string($this->announcementImage)) {
            $this->saveMediaFile($this->announcementImage, 'images', 0);
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
