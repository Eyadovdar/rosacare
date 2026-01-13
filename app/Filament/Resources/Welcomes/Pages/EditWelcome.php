<?php

namespace App\Filament\Resources\Welcomes\Pages;

use App\Filament\Resources\Welcomes\WelcomeResource;
use App\Services\ImageService;
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

        // Store welcome details with their translations
        $this->welcomeDetails = $data['welcomeDetails'] ?? [];

        // Remove welcomeDetails from form data (will be saved manually after save)
        unset($data['welcomeDetails']);

        // DO NOT manipulate the image field - let Filament FileUpload process it automatically
        // Filament will save the file and store the path in the database column
        // If image was removed, Filament will handle that too

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

        // Refresh the record to get the final image path after Filament processes it
        $this->record->refresh();
        
        // Resize and optimize welcome image
        // Filament FileUpload should have already saved the file
        $imagePath = $this->record->image;
        
        if ($imagePath && is_string($imagePath)) {
            try {
                if (Storage::disk('public')->exists($imagePath)) {
                    // Check if this is a new image upload
                    $originalImagePath = $this->record->getOriginal('image');
                    $isNewImage = $originalImagePath !== $imagePath;
                    
                    if ($isNewImage) {
                        // Resize and optimize the new welcome image
                        $resizedImagePath = ImageService::resizeHeroImage(
                            $imagePath,
                            'public',
                            1920, // Max width for welcome images (Full HD)
                            1080, // Max height for welcome images (Full HD)
                            90    // High quality JPEG
                        );
                        
                        // Update the record with the resized image path if it changed
                        if ($resizedImagePath !== $imagePath) {
                            $this->record->update(['image' => $resizedImagePath]);
                            $imagePath = $resizedImagePath;
                        }
                    }
                    
                    Storage::disk('public')->setVisibility($imagePath, 'public');
                    \Log::info('Welcome image resized and visibility set to public (edit):', ['path' => $imagePath]);
                } else {
                    \Log::warning('Welcome image file not found in storage (edit):', [
                        'path' => $imagePath,
                        'record_id' => $this->record->id,
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error("Failed to resize welcome image (edit): {$imagePath}", [
                    'error' => $e->getMessage(),
                ]);
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
                    
                    // Resize and optimize the image after moving to public storage
                    $processedImagePath = ImageService::resizeProductImage(
                        $publicPath,
                        'public',
                        1200, // Max width for welcome detail images
                        1200, // Max height for welcome detail images
                        85    // High quality JPEG
                    );
                    
                    \Log::info('Welcome detail image moved from private to public storage and resized (edit):', [
                        'from' => $privatePath,
                        'to' => $processedImagePath,
                    ]);
                } catch (\Exception $e) {
                    \Log::error("Failed to move welcome detail image from private to public (edit): {$privatePath}", [
                        'error' => $e->getMessage(),
                    ]);
                    $processedImagePath = $detailImage; // Fallback to original path
                }
            } elseif (Storage::disk('public')->exists($detailImage)) {
                // File is already in public storage - resize and optimize it
                // Check if this is a new image (compare with existing details)
                $existingDetail = $this->record->welcomeDetails->firstWhere('image', $detailImage);
                $isNewImage = !$existingDetail;
                
                if ($isNewImage) {
                    // Resize and optimize new welcome detail image
                    $processedImagePath = ImageService::resizeProductImage(
                        $detailImage,
                        'public',
                        1200, // Max width for welcome detail images
                        1200, // Max height for welcome detail images
                        85    // High quality JPEG
                    );
                } else {
                    // Keep existing image
                    $processedImagePath = $detailImage;
                }
                Storage::disk('public')->setVisibility($processedImagePath, 'public');
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
                    \Log::info('Welcome detail image visibility set to public (edit):', ['path' => $finalImagePath]);
                }
            } catch (\Exception $e) {
                \Log::error("Failed to set visibility for welcome detail image (edit): {$finalImagePath}", [
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
