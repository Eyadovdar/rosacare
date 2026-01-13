<?php

namespace App\Filament\Resources\Abouts\Pages;

use App\Filament\Resources\Abouts\AboutResource;
use App\Services\ImageService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateAbout extends CreateRecord
{
    protected static string $resource = AboutResource::class;

    protected array $translations = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);
        
        // Remove translation fields from form data
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

        // Resize and optimize images
        $this->resizeImages();
    }

    protected function extractTranslations(array $data): array
    {
        $translations = [];
        $translatableFields = [
            'story_title', 'story_content',
            'vision_title', 'vision_content',
            'mission_title', 'mission_content',
            'heritage_title', 'heritage_content', 'heritage_subcontent',
            'why_rosacare_title', 'benefits_title',
            'meta_title', 'meta_description', 'meta_keywords',
        ];
        
        foreach ($translatableFields as $field) {
            if (isset($data[$field . ':ar'])) {
                $translations['ar'][$field] = $data[$field . ':ar'];
            }
            if (isset($data[$field . ':en'])) {
                $translations['en'][$field] = $data[$field . ':en'];
            }
        }

        // Handle story_paragraphs - transform from Repeater format to simple array
        foreach (['ar', 'en'] as $locale) {
            if (isset($data['story_paragraphs:' . $locale]) && is_array($data['story_paragraphs:' . $locale])) {
                $translations[$locale]['story_paragraphs'] = array_column($data['story_paragraphs:' . $locale], 'paragraph');
            }
        }

        return $translations;
    }

    protected function removeTranslationFields(array $data): array
    {
        $translatableFields = [
            'story_title', 'story_content', 'story_paragraphs',
            'vision_title', 'vision_content',
            'mission_title', 'mission_content',
            'heritage_title', 'heritage_content', 'heritage_subcontent',
            'why_rosacare_title', 'benefits_title',
            'meta_title', 'meta_description', 'meta_keywords',
        ];

        foreach ($translatableFields as $field) {
            unset($data[$field . ':ar'], $data[$field . ':en']);
        }

        return $data;
    }

    protected function resizeImages(): void
    {
        $imageFields = [
            'hero_image_path' => ['width' => 1920, 'height' => 1080],
            'story_image_path' => ['width' => 1200, 'height' => 800],
            'vision_image_path' => ['width' => 1200, 'height' => 800],
            'mission_image_path' => ['width' => 1200, 'height' => 800],
            'heritage_image_path' => ['width' => 1200, 'height' => 800],
            'benefits_image_path' => ['width' => 1200, 'height' => 800],
            'why_rosacare_image_path' => ['width' => 1200, 'height' => 800],
            'story_icon_path' => ['width' => 128, 'height' => 128],
            'vision_icon_path' => ['width' => 128, 'height' => 128],
            'mission_icon_path' => ['width' => 128, 'height' => 128],
        ];

        foreach ($imageFields as $field => $dimensions) {
            $imagePath = $this->record->$field;
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                try {
                    ImageService::resizeImage(
                        $imagePath,
                        'public',
                        $dimensions['width'],
                        $dimensions['height'],
                        85,
                        'resized'
                    );
                } catch (\Exception $e) {
                    \Log::error("Failed to resize about image: {$field}", [
                        'error' => $e->getMessage(),
                        'path' => $imagePath,
                    ]);
                }
            }
        }
    }
}
