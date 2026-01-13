<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Media;
use App\Services\ImageService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);
        
        // Store media files to save after creation
        // Filament FileUpload stores file paths as strings (single) or arrays (multiple)
        $this->featuredImage = is_array($data['featured_image'] ?? null) 
            ? ($data['featured_image'][0] ?? null) 
            : ($data['featured_image'] ?? null);
        $this->galleryImages = is_array($data['gallery_images'] ?? null) 
            ? $data['gallery_images'] 
            : (($data['gallery_images'] ?? null) ? [$data['gallery_images']] : []);
        
        // Remove media fields from form data
        unset($data['featured_image'], $data['gallery_images']);
        
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
        
        // Save featured image
        if ($this->featuredImage && is_string($this->featuredImage)) {
            // Resize and optimize featured image
            $resizedImagePath = ImageService::resizeProductImage(
                $this->featuredImage,
                'public',
                1200, // Max width for product images
                1200, // Max height for product images (square)
                85    // High quality JPEG
            );
            $this->saveMediaFile($resizedImagePath, 'featured', 0);
        }
        
        // Save gallery images
        if (!empty($this->galleryImages)) {
            foreach ($this->galleryImages as $index => $imagePath) {
                if (is_string($imagePath)) {
                    // Resize and optimize gallery image
                    $resizedImagePath = ImageService::resizeProductImage(
                        $imagePath,
                        'public',
                        1200, // Max width for product images
                        1200, // Max height for product images
                        85    // High quality JPEG
                    );
                    $this->saveMediaFile($resizedImagePath, 'gallery', $index);
                }
            }
        }
    }
    
    protected $featuredImage = null;
    protected array $galleryImages = [];
    
    protected function saveMediaFile(string $filePath, string $collection, int $sortOrder): void
    {
        try {
            // FileUpload stores paths relative to storage/app/public
            // Check if file exists
            if (!Storage::disk('public')->exists($filePath)) {
                \Log::warning("Media file not found: {$filePath}");
                return;
            }
            
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
        $translatableFields = [
            'name', 'description', 'short_description', 
            'meta_title', 'meta_description', 'meta_keywords'
        ];
        $arrayFields = ['ingredients', 'benefits', 'usage_instructions'];
        
        foreach ($translatableFields as $field) {
            if (isset($data[$field . ':ar'])) {
                $translations['ar'][$field] = $data[$field . ':ar'];
            }
            if (isset($data[$field . ':en'])) {
                $translations['en'][$field] = $data[$field . ':en'];
            }
        }

        foreach ($arrayFields as $field) {
            if (isset($data[$field . ':ar']) && is_array($data[$field . ':ar'])) {
                $translations['ar'][$field] = array_column($data[$field . ':ar'], 'item');
            }
            if (isset($data[$field . ':en']) && is_array($data[$field . ':en'])) {
                $translations['en'][$field] = array_column($data[$field . ':en'], 'item');
            }
        }

        return $translations;
    }

    protected function removeTranslationFields(array $data): array
    {
        $translatableFields = [
            'name', 'description', 'short_description', 
            'meta_title', 'meta_description', 'meta_keywords'
        ];
        $arrayFields = ['ingredients', 'benefits', 'usage_instructions'];
        $allFields = array_merge($translatableFields, $arrayFields);
        
        foreach ($allFields as $field) {
            unset($data[$field . ':ar'], $data[$field . ':en']);
        }

        return $data;
    }
}
