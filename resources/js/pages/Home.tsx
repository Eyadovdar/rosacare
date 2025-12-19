import { Head } from '@inertiajs/react';
import { HeroSection } from '@/components/rosacare/HeroSection';
import { AboutSection } from '@/components/rosacare/AboutSection';
import { CategoryShowcase } from '@/components/rosacare/CategoryShowcase';
import { ProductCard } from '@/components/rosacare/ProductCard';
import { BenefitsSection } from '@/components/rosacare/BenefitsSection';
import { HeritageSection } from '@/components/rosacare/HeritageSection';
import { WhyRosaCareSection } from '@/components/rosacare/WhyRosaCareSection';
import { CTABanner } from '@/components/rosacare/CTABanner';
import { Footer } from '@/components/rosacare/Footer';

interface Category {
    id: number;
    slug: string;
    translations: Array<{
        locale: string;
        name: string;
        description?: string;
    }>;
}

interface Product {
    id: number;
    slug: string;
    translations: Array<{
        locale: string;
        name: string;
        short_description?: string;
    }>;
    media?: Array<{
        id: number;
        file_name: string;
        path: string;
        collection_name: string;
    }>;
}

interface HomeProps {
    categories: Category[];
    featuredProducts: Product[];
    locale?: string;
}

export default function Home({ categories, featuredProducts, locale = 'en' }: HomeProps) {
    const isRTL = locale === 'ar';

    return (
        <>
            <Head title="RosaCare - Authentic Damask Rose Products" />
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <HeroSection locale={locale} />
                <AboutSection locale={locale} />
                {categories.length > 0 && <CategoryShowcase categories={categories} locale={locale} />}
                {featuredProducts.length > 0 && (
                    <section className="py-20 bg-background">
                        <div className="container mx-auto px-4">
                            <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                                {locale === 'ar' ? 'منتجات مميزة' : 'Featured Products'}
                            </h2>
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                {featuredProducts.map((product) => (
                                    <ProductCard key={product.id} product={product} locale={locale} />
                                ))}
                            </div>
                        </div>
                    </section>
                )}
                <BenefitsSection locale={locale} />
                <HeritageSection locale={locale} />
                <WhyRosaCareSection locale={locale} />
                <CTABanner locale={locale} />
                <Footer locale={locale} />
            </div>
        </>
    );
}
