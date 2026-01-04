<?php

namespace Database\Seeders;

use App\Models\Welcome;
use App\Models\WelcomeDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WelcomeDetailSeeder extends Seeder
{
    public function run(): void
    {
        $welcome = Welcome::first();

        if (!$welcome) {
            $this->command->error('Welcome section not found. Please run WelcomeSeeder first.');
            return;
        }

        // Create Welcome Details
        $details = [
            [
                'button_url' => '/products?category=skincare',
                'button_color' => '#E91E63',
                'button_text_color' => '#FFFFFF',
                'image_name' => 'skincare-feature.jpg',
                'translations' => [
                    'ar' => [
                        'title' => 'العناية بالبشرة',
                        'description' => 'منتجات عناية بالبشرة مصنوعة من الوردة الشامية الطبيعية، مثالية لجميع أنواع البشرة.',
                        'button_text' => 'تسوق الآن',
                    ],
                    'en' => [
                        'title' => 'Skincare Products',
                        'description' => 'Premium skincare products made from natural Damask Rose, perfect for all skin types.',
                        'button_text' => 'Shop Now',
                    ],
                ],
            ],
            [
                'button_url' => '/products?category=food',
                'button_color' => '#9C27B0',
                'button_text_color' => '#FFFFFF',
                'image_name' => 'food-feature.jpg',
                'translations' => [
                    'ar' => [
                        'title' => 'منتجات غذائية',
                        'description' => 'استمتع بنكهة وطعم الوردة الشامية في منتجاتنا الغذائية الطبيعية واللذيذة.',
                        'button_text' => 'تسوق الآن',
                    ],
                    'en' => [
                        'title' => 'Food Products',
                        'description' => 'Enjoy the flavor and taste of Damask Rose in our natural and delicious food products.',
                        'button_text' => 'Shop Now',
                    ],
                ],
            ],
            [
                'button_url' => '/products?category=aromatic',
                'button_color' => '#673AB7',
                'button_text_color' => '#FFFFFF',
                'image_name' => 'aromatic-feature.jpg',
                'translations' => [
                    'ar' => [
                        'title' => 'منتجات عطرية',
                        'description' => 'استرخي واستمتع بعطور الوردة الشامية الطبيعية التي تنعش حواسك وتريح نفسك.',
                        'button_text' => 'تسوق الآن',
                    ],
                    'en' => [
                        'title' => 'Aromatic Products',
                        'description' => 'Relax and enjoy natural Damask Rose fragrances that refresh your senses and soothe your soul.',
                        'button_text' => 'Shop Now',
                    ],
                ],
            ],
        ];

        // Create directory structure if it doesn't exist
        if (!Storage::disk('public')->exists('welcomes/details')) {
            Storage::disk('public')->makeDirectory('welcomes/details');
        }

        foreach ($details as $index => $detail) {
            $welcomeDetail = WelcomeDetail::create([
                'welcome_id' => $welcome->id,
                'image' => 'welcomes/details/' . $detail['image_name'], // Placeholder - actual image path stored in database column
                'button_url' => $detail['button_url'],
                'button_color' => $detail['button_color'],
                'button_text_color' => $detail['button_text_color'],
            ]);

            // Add translations
            foreach (['ar', 'en'] as $locale) {
                $welcomeDetail->translateOrNew($locale)->fill($detail['translations'][$locale])->save();
            }
        }

        $this->command->info('Welcome details seeded successfully!');
    }
}

