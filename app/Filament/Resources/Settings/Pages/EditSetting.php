<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use App\Models\Setting;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No delete action - we want to keep at least one settings record
        ];
    }

    public function mount(int|string $record = null): void
    {
        // Always use the first settings record, ignore the passed record parameter
        // Only one settings record should exist
        $setting = Setting::first();
        
        if (!$setting) {
            $setting = Setting::create([]);
            // Load default translations
            $setting->translateOrNew('ar')->save();
            $setting->translateOrNew('en')->save();
        }

        // Call parent mount with the first record's ID to ensure proper initialization
        parent::mount($setting->id);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load translations into form data
        $record = $this->record ?? Setting::first();
        
        if (!$record) {
            return $data;
        }

        $translatableFields = [
            'site_name',
            'slogan',
            'footer_description',
            'default_meta_title',
            'default_meta_description',
            'default_meta_keywords',
            'contact_page_info_title',
            'contact_page_form_title',
            'google_map_title',
            'footer_copyright',
        ];

        foreach ($translatableFields as $field) {
            foreach (['ar', 'en'] as $locale) {
                if ($record->hasTranslation($locale)) {
                    $data[$field . ':' . $locale] = $record->translate($locale)?->{$field};
                }
            }
        }

        // Load file paths directly from database
        if ($record->logo_header_path) {
            $data['logo_header_path'] = $record->logo_header_path;
        }
        if ($record->logo_footer_path) {
            $data['logo_footer_path'] = $record->logo_footer_path;
        }
        if ($record->favicon_path) {
            $data['favicon_path'] = $record->favicon_path;
        }
        if ($record->default_meta_image) {
            $data['default_meta_image'] = $record->default_meta_image;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract and store translations separately
        $this->translations = $this->extractTranslations($data);

        // Handle file uploads - FileUpload stores file paths as strings (single) or arrays (multiple)
        $fileFields = ['logo_header_path', 'logo_footer_path', 'favicon_path', 'default_meta_image'];
        
        foreach ($fileFields as $field) {
            $filePath = is_array($data[$field] ?? null) 
                ? ($data[$field][0] ?? null) 
                : ($data[$field] ?? null);

            if ($filePath && is_string($filePath)) {
                $data[$field] = $filePath;
                // Ensure file has public visibility
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->setVisibility($filePath, 'public');
                }
            } elseif (empty($filePath)) {
                // Keep existing value if no new file uploaded
                if (isset($this->record) && $this->record->{$field}) {
                    $data[$field] = $this->record->{$field};
                }
            }
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

    protected array $translations = [];

    protected function extractTranslations(array $data): array
    {
        $translations = [];
        $translatableFields = [
            'site_name',
            'slogan',
            'footer_description',
            'default_meta_title',
            'default_meta_description',
            'default_meta_keywords',
            'contact_page_info_title',
            'contact_page_form_title',
            'google_map_title',
            'footer_copyright',
        ];
        
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
        $translatableFields = [
            'site_name',
            'slogan',
            'footer_description',
            'default_meta_title',
            'default_meta_description',
            'default_meta_keywords',
            'contact_page_info_title',
            'contact_page_form_title',
            'google_map_title',
            'footer_copyright',
        ];
        
        foreach ($translatableFields as $field) {
            unset($data[$field . ':ar'], $data[$field . ':en']);
        }

        return $data;
    }
}
