import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface ParallaxProps {
    locale?: string;
    parallax?: {
        id: number;
        image?: string;
        image_url?: string;
        link?: string;
        translations: Array<{
            locale: string;
            title?: string;
            description?: string;
        }>;
    };
}

// Default data matching the original CTABanner
const defaultData = {
    title: {
        ar: 'اكتشف جمال الوردة الشامية',
        en: 'Discover the Beauty of Damask Rose',
    },
    description: {
        ar: 'استكشف مجموعتنا الكاملة من المنتجات الطبيعية الفاخرة',
        en: 'Explore our complete collection of premium natural products',
    },
    link: '/products',
};

export function Parallax({ locale = 'ar', parallax }: ParallaxProps) {
    const isRTL = locale === 'ar';

    // Use parallax data if available, otherwise use defaults
    const title = parallax?.translations?.find(t => t.locale === locale)?.title
        || parallax?.translations?.[0]?.title
        || defaultData.title[locale as 'ar' | 'en']
        || defaultData.title.en;

    const description = parallax?.translations?.find(t => t.locale === locale)?.description
        || parallax?.translations?.[0]?.description
        || defaultData.description[locale as 'ar' | 'en']
        || defaultData.description.en;

    const link = parallax?.link || defaultData.link;
    const imageUrl = parallax?.image_url || (parallax?.image ? `/storage/${parallax.image}` : null);

    return (
        <section
            className="py-20 text-primary-foreground relative overflow-hidden"
            style={{
                backgroundImage: imageUrl ? `url(${imageUrl})` : undefined,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundAttachment: 'fixed', // Parallax effect
            }}
        >
            {/* Overlay for better text readability */}
            <div className="absolute inset-0 bg-gradient-to-r from-primary/30 to-primary10 z-0" />

            <div className="container mx-auto px-4 relative z-10">
                <div className={`max-w-3xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-6">
                        {title}
                    </h2>
                    <p className="text-xl mb-8 opacity-90">
                        {description}
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button asChild size="lg" variant="secondary" className="text-lg px-8 py-6">
                            <Link href={link}>
                                {locale === 'ar' ? 'تصفح المنتجات' : 'Browse Products'}
                            </Link>
                        </Button>
                        <Button asChild size="lg" variant="outline" className="text-lg px-8 py-6 border-primary-foreground text-primary-foreground hover:bg-primary-foreground hover:text-primary">
                            <Link href="/contact">
                                {locale === 'ar' ? 'تواصل معنا' : 'Contact Us'}
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </section>
    );
}

