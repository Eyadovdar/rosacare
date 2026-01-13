<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create about record (singleton pattern)
        $about = About::first();

        if (!$about) {
            $about = About::create([
                // Non-translatable fields
                'hero_image_path' => null,
                'story_image_path' => null,
                'story_icon_path' => null,
                'vision_image_path' => null,
                'vision_icon_path' => null,
                'mission_image_path' => null,
                'mission_icon_path' => null,
                'heritage_image_path' => null,
                'benefits_image_path' => null,
                'why_rosacare_image_path' => null,
                'benefits' => [
                    [
                        'icon_path' => null,
                        'title' => 'Skin Benefits',
                        'description' => 'Deep hydration, skin smoothing, and reduction of wrinkles and fine lines',
                    ],
                    [
                        'icon_path' => null,
                        'title' => 'Wellness & Relaxation',
                        'description' => 'Natural soothing properties that help with relaxation and stress relief',
                    ],
                    [
                        'icon_path' => null,
                        'title' => 'Nutritional Value',
                        'description' => 'Rich in vitamins and natural antioxidants beneficial for health',
                    ],
                    [
                        'icon_path' => null,
                        'title' => '100% Natural',
                        'description' => 'Pure natural products without chemical additives or preservatives',
                    ],
                ],
                'reasons' => [
                    [
                        'icon_path' => null,
                        'title' => 'Natural Ingredients',
                        'description' => '100% natural products extracted from the finest Damask Roses',
                    ],
                    [
                        'icon_path' => null,
                        'title' => 'No Chemicals',
                        'description' => 'Completely free from chemicals and synthetic preservatives',
                    ],
                    [
                        'icon_path' => null,
                        'title' => 'Trusted Heritage',
                        'description' => 'Authentic traditional Syrian methods passed down through generations',
                    ],
                    [
                        'icon_path' => null,
                        'title' => 'Sustainable Practices',
                        'description' => 'Commitment to sustainability and environmental responsibility in all our operations',
                    ],
                ],
                'heritage_features' => [
                    [
                        'icon_path' => null,
                        'title' => 'Traditional Extraction',
                        'description' => 'Traditional extraction methods preserving all natural properties',
                    ],
                    [
                        'icon_path' => null,
                        'title' => 'Excellence in Quality',
                        'description' => 'Commitment to the highest standards of quality and purity in every product',
                    ],
                ],
                'is_active' => true,
            ]);
        }

        // Add Arabic translations
        $about->translateOrNew('ar')->fill([
            'story_title' => 'قصتنا',
            'story_paragraphs' => [
                'روزاكير هي أكثر من مجرد علامة تجارية - إنها رحلة نحو الطبيعة والأصالة. تأسست من حب عميق للوردة الشامية وتقدير للتراث السوري الأصيل، نسعى لنقل جمال ونقاء هذه الزهرة المميزة إلى العالم.',
                'بدأت رحلتنا من قلب سوريا، حيث تُزرع أجود أنواع الوردة الشامية في العالم. نحن نعمل مباشرة مع المزارعين المحليين الذين يحافظون على التقاليد القديمة في زراعة وجني الورد، مما يضمن أن كل منتج يحمل جوهر الأصالة والجودة.',
            ],
            'story_content' => 'روزاكير هي أكثر من مجرد علامة تجارية - إنها رحلة نحو الطبيعة والأصالة. تأسست من حب عميق للوردة الشامية وتقدير للتراث السوري الأصيل، نسعى لنقل جمال ونقاء هذه الزهرة المميزة إلى العالم.',
            'vision_title' => 'رؤيتنا',
            'vision_content' => 'أن نكون الرائدين العالميين في تقديم منتجات الوردة الشامية الطبيعية والأصيلة، مع الحفاظ على التراث السوري وتمكين المجتمعات المحلية.',
            'mission_title' => 'مهمتنا',
            'mission_content' => 'تقديم منتجات طبيعية 100% من أعلى جودة، مستخرجة بطرق تقليدية أصيلة، مع الالتزام بالاستدامة والمسؤولية البيئية والاجتماعية.',
            'heritage_title' => 'التراث والحرفية',
            'heritage_content' => 'تمتد جذورنا إلى قرون من الحرفية السورية التقليدية في استخراج الوردة الشامية. نحن نستخدم الطرق التقليدية الأصيلة التي تم تناقلها عبر الأجيال، مما يضمن الحفاظ على الجودة والنقاء والخصائص الطبيعية الفريدة لهذه الزهرة المميزة.',
            'heritage_subcontent' => 'كل قطرة من منتجاتنا تحمل عبق التاريخ والتراث السوري الأصيل. نعتز بهذا الإرث ونسعى للحفاظ عليه وتقديمه للعالم بأعلى معايير الجودة.',
            'why_rosacare_title' => 'لماذا روزاكير؟',
            'benefits_title' => 'فوائد الوردة الشامية',
            'meta_title' => 'من نحن - روزاكير',
            'meta_description' => 'روزاكير هي علامة تجارية دمشقية تركز على إنشاء منتجات تجميل مستوحاة من الوردة الشامية التقليدية. اكتشف قصتنا ورؤيتنا ومهمتنا.',
            'meta_keywords' => 'روزاكير، من نحن، الوردة الشامية، التراث السوري، منتجات طبيعية، دمشق، سوريا',
        ])->save();

        // Add English translations
        $about->translateOrNew('en')->fill([
            'story_title' => 'Our Story',
            'story_paragraphs' => [
                'RosaCare is more than just a brand - it\'s a journey towards nature and authenticity. Founded from a deep love for the Damask Rose and appreciation for authentic Syrian heritage, we strive to bring the beauty and purity of this distinguished flower to the world.',
                'Our journey began from the heart of Syria, where the finest Damask Roses in the world are grown. We work directly with local farmers who preserve ancient traditions in growing and harvesting roses, ensuring that every product carries the essence of authenticity and quality.',
            ],
            'story_content' => 'RosaCare is more than just a brand - it\'s a journey towards nature and authenticity. Founded from a deep love for the Damask Rose and appreciation for authentic Syrian heritage, we strive to bring the beauty and purity of this distinguished flower to the world.',
            'vision_title' => 'Our Vision',
            'vision_content' => 'To be the global leaders in providing natural and authentic Damask Rose products, while preserving Syrian heritage and empowering local communities.',
            'mission_title' => 'Our Mission',
            'mission_content' => 'To deliver 100% natural products of the highest quality, extracted using authentic traditional methods, while committing to sustainability and environmental and social responsibility.',
            'heritage_title' => 'Heritage & Craftsmanship',
            'heritage_content' => 'Our roots extend to centuries of traditional Syrian craftsmanship in Damask Rose extraction. We use authentic traditional methods passed down through generations, ensuring the preservation of quality, purity, and the unique natural properties of this distinguished flower.',
            'heritage_subcontent' => 'Every drop of our products carries the essence of authentic Syrian history and heritage. We cherish this legacy and strive to preserve it and present it to the world with the highest quality standards.',
            'why_rosacare_title' => 'Why RosaCare?',
            'benefits_title' => 'Benefits of Damask Rose',
            'meta_title' => 'About Us - RosaCare',
            'meta_description' => 'RosaCare is a Damascus-based brand focused on creating beauty products inspired by the traditional Damask Rose. Discover our story, vision, and mission.',
            'meta_keywords' => 'RosaCare, About Us, Damask Rose, Syrian Heritage, Natural Products, Damascus, Syria',
        ])->save();

        // Note: benefits, reasons, and heritage_features are JSON fields (not translatable)
        // They are stored in English. The frontend components handle translations.
        // If you want to make them translatable, you would need to refactor the model structure.

        $this->command->info('About page content seeded successfully!');
    }
}
