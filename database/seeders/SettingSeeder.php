<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create settings record (singleton pattern)
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                // Non-translatable fields
                'logo_header_path' => null,
                'logo_footer_path' => null,
                'favicon_path' => null,
                'default_meta_image' => null,
                'google_verification_code' => null,
                'phone_number' => null,
                'email' => null,
                'address' => 'Damascus, Syria',
                'google_map_iframe' => null,
                'facebook' => null,
                'twitter' => null,
                'instagram' => null,
                'linkedin' => null,
                'youtube' => null,
                'tiktok' => null,
            ]);
        }

        // Add translations
        $translations = [
            'en' => [
                'site_name' => 'RosaCare',
                'slogan' => 'Rosa from Nature',
                'footer_description' => 'Damascus-based brand in Syria that focuses on creating beauty products inspired by the traditional Damascena rose, a centuries-old symbol of beauty. The brand\'s core ingredients include premium Damascene rose oil and organic Rose Water derived from Rosa Damascena.',
                'default_meta_title' => 'RosaCare - Premium Damask Rose Products from Syria',
                'default_meta_description' => 'Discover premium beauty products inspired by the traditional Damascena rose. Premium Damascene rose oil and organic Rose Water derived from Rosa Damascena. Damascus-based brand in Syria.',
                'default_meta_keywords' => 'RosaCare, Damask Rose, Damascena Rose, Rose Oil, Rose Water, Natural Beauty Products, Syria, Damascus, Organic Rose Products, Premium Rose Oil',
                'contact_page_info_title' => null,
                'contact_page_form_title' => null,
                'google_map_title' => null,
                'footer_copyright' => '© ' . date('Y') . ' RosaCare. All rights reserved. From the heart of Syria.',
            ],
            'ar' => [
                'site_name' => 'روزاكير',
                'slogan' => 'الورد من الطبيعة',
                'footer_description' => 'علامة تجارية دمشقية في سوريا تركز على إنشاء منتجات تجميل مستوحاة من الوردة الشامية التقليدية، رمز الجمال الذي عمره قرون. تشمل المكونات الأساسية للعلامة التجارية زيت الورد الشامي المميز وماء الورد العضوي المستخرج من الوردة الشامية.',
                'default_meta_title' => 'روزاكير - منتجات الوردة الشامية الفاخرة من سوريا',
                'default_meta_description' => 'اكتشف منتجات التجميل الفاخرة المستوحاة من الوردة الشامية التقليدية. زيت الورد الشامي المميز وماء الورد العضوي المستخرج من الوردة الشامية. علامة تجارية دمشقية في سوريا.',
                'default_meta_keywords' => 'روزاكير، الوردة الشامية، زيت الورد، ماء الورد، منتجات تجميل طبيعية، سوريا، دمشق، منتجات الورد العضوية',
                'contact_page_info_title' => null,
                'contact_page_form_title' => null,
                'google_map_title' => null,
                'footer_copyright' => '© ' . date('Y') . ' روزاكير. جميع الحقوق محفوظة. من قلب الشام.',
            ],
        ];

        foreach ($translations as $locale => $translation) {
            $setting->translateOrNew($locale)->fill($translation)->save();
        }
    }
}

