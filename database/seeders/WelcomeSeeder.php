<?php

namespace Database\Seeders;

use App\Models\Welcome;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WelcomeSeeder extends Seeder
{
    public function run(): void
    {
        // Create Welcome section
        $welcome = Welcome::create([
            'image' => 'welcomes/images/welcome-main.jpg', // Placeholder - actual image path stored in database column
            'button_url' => '/products',
        ]);

        // Add translations
        $welcome->translateOrNew('ar')->fill([
            'title' => 'مرحباً بك في روسا كير',
            'description' => 'اكتشف جمال ومزايا الوردة الشامية مع منتجاتنا المميزة المصنوعة بعناية فائقة من أفضل أنواع الورود الطبيعية.',
            'button_text' => 'استكشف المنتجات',
        ])->save();

        $welcome->translateOrNew('en')->fill([
            'title' => 'Welcome to RosaCare',
            'description' => 'Discover the beauty and benefits of Damask Rose with our premium products, carefully crafted from the finest natural roses.',
            'button_text' => 'Explore Products',
        ])->save();

        // Create directory structure if it doesn't exist
        if (!Storage::disk('public')->exists('welcomes/images')) {
            Storage::disk('public')->makeDirectory('welcomes/images');
        }

        $this->command->info('Welcome section seeded successfully!');
    }
}

