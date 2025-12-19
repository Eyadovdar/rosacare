<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $skincareCategory = Category::where('slug', 'skincare-body-care')->first();
        $foodCategory = Category::where('slug', 'food-products')->first();
        $aromaticCategory = Category::where('slug', 'aromatic-products')->first();

        if (! $skincareCategory || ! $foodCategory) {
            $this->command->warn('Categories not found. Please run CategorySeeder first.');
            return;
        }

        $products = [
            [
                'category_id' => $skincareCategory->id,
                'slug' => 'damask-rose-water',
                'price' => 29.99,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Damask Rose Water',
                        'short_description' => 'Pure natural rose water for skincare and wellness.',
                        'description' => 'Premium quality Damask Rose Water extracted using traditional methods. Perfect for skincare, aromatherapy, and culinary uses.',
                        'ingredients' => ['100% Pure Damask Rose Water'],
                        'benefits' => [
                            'Natural moisturizer for all skin types',
                            'Soothes and calms irritated skin',
                            'Antioxidant properties',
                            'Aromatherapy benefits',
                        ],
                        'usage_instructions' => [
                            'Apply directly to face as toner',
                            'Use as facial mist throughout the day',
                            'Add to bath water for relaxation',
                        ],
                    ],
                    'ar' => [
                        'name' => 'ماء الورد الشامي',
                        'short_description' => 'ماء ورد طبيعي خالص للعناية بالبشرة والعافية.',
                        'description' => 'ماء الورد الشامي عالي الجودة المستخرج بطرق تقليدية. مثالي للعناية بالبشرة والعلاج بالعطور والاستخدامات الطهي.',
                        'ingredients' => ['100% ماء ورد شامي خالص'],
                        'benefits' => [
                            'مرطب طبيعي لجميع أنواع البشرة',
                            'يهدئ ويلطف البشرة المتهيجة',
                            'خصائص مضادة للأكسدة',
                            'فوائد العلاج بالعطور',
                        ],
                        'usage_instructions' => [
                            'ضع مباشرة على الوجه كتونر',
                            'استخدم كبخاخ للوجه خلال النهار',
                            'أضف إلى ماء الاستحمام للاسترخاء',
                        ],
                    ],
                ],
            ],
            [
                'category_id' => $foodCategory->id,
                'slug' => 'damask-rose-jam',
                'price' => 24.99,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Damask Rose Jam',
                        'short_description' => 'Delicious natural rose jam made from authentic Damask Roses.',
                        'description' => 'Traditional Syrian rose jam made from the finest Damask Rose petals. Perfect for breakfast, desserts, and tea.',
                        'ingredients' => ['Damask Rose Petals', 'Sugar', 'Lemon Juice', 'Water'],
                        'benefits' => [
                            'Rich in antioxidants',
                            'Natural source of vitamins',
                            'Supports digestive health',
                        ],
                        'usage_instructions' => [
                            'Enjoy with bread or pastries',
                            'Perfect for desserts',
                            'Add to tea for flavor',
                        ],
                    ],
                    'ar' => [
                        'name' => 'مربى الورد الشامي',
                        'short_description' => 'مربى ورد لذيذ طبيعي من الوردة الشامية الأصيلة.',
                        'description' => 'مربى الورد السوري التقليدي المصنوع من أجود بتلات الوردة الشامية. مثالي للإفطار والحلويات والشاي.',
                        'ingredients' => ['بتلات الوردة الشامية', 'سكر', 'عصير ليمون', 'ماء'],
                        'benefits' => [
                            'غني بمضادات الأكسدة',
                            'مصدر طبيعي للفيتامينات',
                            'يدعم صحة الجهاز الهضمي',
                        ],
                        'usage_instructions' => [
                            'استمتع به مع الخبز أو المعجنات',
                            'مثالي للحلويات',
                            'أضف للشاي للنكهة',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $translations = $productData['translations'];
            unset($productData['translations']);

            $product = Product::create($productData);

            foreach ($translations as $locale => $translation) {
                $product->translateOrNew($locale)->fill($translation)->save();
            }
        }
    }
}
