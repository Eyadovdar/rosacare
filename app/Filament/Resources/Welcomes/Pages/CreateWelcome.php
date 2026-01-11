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

        // Store welcome details with their translations
        $this->welcomeDetails = $data['welcomeDetails'] ?? [];

        // Remove welcomeDetails from form data (will be saved manually after creation)
        unset($data['welcomeDetails']);

        // DO NOT manipulate the image field - let Filament FileUpload process it automatically
        // Filament will save the file and store the path in the database column

        return $this->removeTranslationFields($data);
    }

    protected function afterCreate(): void
    {
        // Refresh the record to get the final image path after Filament processes it
        $this->record->refresh();

        // Save translations after record is created
        if (isset($this->translations)) {
            foreach ($this->translations as $locale => $fields) {
                $this->record->translateOrNew($locale)->fill($fields)->save();
            }
        }

        // Ensure welcome image file has public visibility
        // Filament FileUpload should have already saved the file
        $imagePath = $this->record->image;

        if ($imagePath && is_string($imagePath)) {
            try {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->setVisibility($imagePath, 'public');
                    \Log::info('Welcome image visibility set to public:', ['path' => $imagePath]);
                } else {
                    \Log::warning('Welcome image file not found in storage:', [
                        'path' => $imagePath,
                        'record_id' => $this->record->id,
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error("Failed to set visibility for welcome image: {$imagePath}", [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Save welcome details with translations
        if (!empty($this->welcomeDetails)) {
            foreach ($this->welcomeDetails as $detailData) {
                $this->saveWelcomeDetail($detailData);
            }
        }
    }

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

        // Get image path - Filament FileUpload automatically uploads files
        // The path is relative to storage/app/public (e.g., "welcomes/details/filename.jpg")
        $detailImage = is_array($detailData['image'] ?? null)
            ? ($detailData['image'][0] ?? null)
            : ($detailData['image'] ?? null);

        // Remove translation fields from detail data
        foreach ($translatableFields as $field) {
            unset($detailData[$field . ':ar'], $detailData[$field . ':en']);
        }

        // Process image file - check if it's in private storage and move to public
        $processedImagePath = null;
        if ($detailImage && is_string($detailImage)) {
            $privatePath = null;
            $filename = basename($detailImage);

            // Check multiple possible locations in private storage
            $possiblePrivatePaths = [
                $detailImage, // As-is
                "welcomes/{$filename}", // In welcomes subdirectory
                "welcomes/details/{$filename}", // In welcomes/details subdirectory
            ];

            foreach ($possiblePrivatePaths as $path) {
                if (Storage::disk('local')->exists($path)) {
                    $privatePath = $path;
                    break;
                }
            }

            if ($privatePath) {
                // File is in private storage, move it to public storage
                $publicPath = 'welcomes/details/' . $filename;
                try {
                    $fileContents = Storage::disk('local')->get($privatePath);
                    Storage::disk('public')->put($publicPath, $fileContents);
                    Storage::disk('public')->setVisibility($publicPath, 'public');
                    Storage::disk('local')->delete($privatePath);
                    $processedImagePath = $publicPath;
                    \Log::info('Welcome detail image moved from private to public storage:', [
                        'from' => $privatePath,
                        'to' => $publicPath,
                    ]);
                } catch (\Exception $e) {
                    \Log::error("Failed to move welcome detail image from private to public: {$privatePath}", [
                        'error' => $e->getMessage(),
                    ]);
                    $processedImagePath = $detailImage; // Fallback to original path
                }
            } elseif (Storage::disk('public')->exists($detailImage)) {
                // File is already in public storage
                $processedImagePath = $detailImage;
                Storage::disk('public')->setVisibility($detailImage, 'public');
            } else {
                // Try to use the path as-is (might be relative to public disk)
                $processedImagePath = $detailImage;
            }
        }

        $detailData['image'] = $processedImagePath;

        // Create welcome detail
        $welcomeDetail = $this->record->welcomeDetails()->create($detailData);

        // Refresh to get the final image path
        $welcomeDetail->refresh();

        // Ensure detail image file has public visibility
        $finalImagePath = $welcomeDetail->image;
        if ($finalImagePath && is_string($finalImagePath)) {
            try {
                if (Storage::disk('public')->exists($finalImagePath)) {
                    Storage::disk('public')->setVisibility($finalImagePath, 'public');
                    \Log::info('Welcome detail image visibility set to public:', ['path' => $finalImagePath]);
                }
            } catch (\Exception $e) {
                \Log::error("Failed to set visibility for welcome detail image: {$finalImagePath}", [
                    'error' => $e->getMessage(),
                ]);
            }
        }

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
