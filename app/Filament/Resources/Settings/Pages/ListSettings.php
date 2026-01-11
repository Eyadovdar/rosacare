<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use App\Filament\Resources\Settings\Pages\EditSetting;
use App\Models\Setting;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    public function mount(): void
    {
        // Always redirect to edit page for the first (or only) settings record
        $setting = Setting::first();
        
        if (!$setting) {
            // Create a default setting record if none exists
            $setting = Setting::create([]);
            // Load default translations
            $setting->translateOrNew('ar')->save();
            $setting->translateOrNew('en')->save();
        }

        // Redirect to edit the settings record
        $this->redirect(EditSetting::getUrl(['record' => $setting->id]));
    }
}
