<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'skincare-body-care',
                'icon' => null,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'translations' => [
                    'en' => [
                        'name' => 'Skincare & Body Care',
                        'description' => 'Premium skincare and body care products made from authentic Damask Rose.',
                        'meta_title' => 'Damask Rose Skincare & Body Care Products',
                        'meta_description' => 'Discover our collection of natural skincare and body care products.',
                    ],
                    'ar' => [
                        'name' => 'العناية بالبشرة والجسم',
                        'description' => 'منتجات فاخرة للعناية بالبشرة والجسم من الوردة الشامية الأصيلة.',
                        'meta_title' => 'منتجات العناية بالبشرة والجسم من الوردة الشامية',
                        'meta_description' => 'اكتشف مجموعتنا من منتجات العناية بالبشرة والجسم الطبيعية.',
                    ],
                ],
            ],
            [
                'slug' => 'food-products',
                'icon' => null,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'translations' => [
                    'en' => [
                        'name' => 'Food Products',
                        'description' => 'Delicious and healthy food products made from Damask Rose.',
                        'meta_title' => 'Damask Rose Food Products',
                        'meta_description' => 'Explore our range of natural food products.',
                    ],
                    'ar' => [
                        'name' => 'منتجات غذائية',
                        'description' => 'منتجات غذائية لذيذة وصحية من الوردة الشامية.',
                        'meta_title' => 'منتجات غذائية من الوردة الشامية',
                        'meta_description' => 'استكشف مجموعتنا من المنتجات الغذائية الطبيعية.',
                    ],
                ],
            ],
            [
                'slug' => 'aromatic-products',
                'icon' => null,
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => true,
                'translations' => [
                    'en' => [
                        'name' => 'Aromatic Products',
                        'description' => 'Premium aromatic products for wellness and relaxation.',
                        'meta_title' => 'Damask Rose Aromatic Products',
                        'meta_description' => 'Discover our aromatic products collection.',
                    ],
                    'ar' => [
                        'name' => 'منتجات عطرية',
                        'description' => 'منتجات عطرية فاخرة للعافية والاسترخاء.',
                        'meta_title' => 'منتجات عطرية من الوردة الشامية',
                        'meta_description' => 'اكتشف مجموعتنا من المنتجات العطرية.',
                    ],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $translations = $categoryData['translations'];
            unset($categoryData['translations']);

            $category = Category::create($categoryData);

            foreach ($translations as $locale => $translation) {
                $category->translateOrNew($locale)->fill($translation)->save();
            }
        }
    }
}
