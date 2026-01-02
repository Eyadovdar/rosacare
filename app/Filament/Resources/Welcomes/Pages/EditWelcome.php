<?php

namespace App\Filament\Resources\Welcomes\Pages;

use App\Filament\Resources\Welcomes\WelcomeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditWelcome extends EditRecord
{
    protected static string $resource = WelcomeResource::class;

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

        // Load welcome image directly from database column
        if ($record->image) {
            $data['image'] = $record->image;
        }

        // Load welcome details with translations
        $welcomeDetails = [];
        foreach ($record->welcomeDetails as $detail) {
            $detailData = [
                'image' => $detail->image,
                'button_url' => $detail->button_url,
                'button_color' => $detail->button_color,
                'button_text_color' => $detail->button_text_color,
            ];

            // Load detail translations
            foreach ($translatableFields as $field) {
                foreach (['ar', 'en'] as $locale) {
                    if ($detail->hasTranslation($locale)) {
                        $detailData[$field . ':' . $locale] = $detail->translate($locale)?->{$field};
                    }
                }
            }

            $welcomeDetails[] = $detailData;
        }

        $data['welcomeDetails'] = $welcomeDetails;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Store media file path - FileUpload stores file paths as strings (single) or arrays (multiple)
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
        } elseif (empty($this->welcomeImage)) {
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

        // Handle welcome details
        // Delete existing details (we'll recreate them)
        foreach ($this->record->welcomeDetails as $detail) {
            $detail->delete();
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
