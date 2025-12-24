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
import { Navbar } from '@/components/rosacare/Navbar';
import { HeroCarousel } from '@/components/rosacare/HeroCarousel';

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

interface NavigationMenuItem {
    id: number;
    type: string;
    url?: string;
    icon?: string;
    page?: string;
    category_id?: number;
    open_in_new_tab: boolean;
    sort_order: number;
    is_active: boolean;
    translations: Array<{
        locale: string;
        label: string;
    }>;
    category?: {
        slug: string;
        translations: Array<{
            locale: string;
            name: string;
        }>;
    };
}

interface CarouselItem {
    id?: number;
    title: string;
    description: string;
    image?: string;
    buttonText?: string;
    buttonLink?: string;
}

interface HomeProps {
    categories: Category[];
    featuredProducts: Product[];
    menuItems?: NavigationMenuItem[];
    locale?: string;
    carouselItems?: CarouselItem[];
}

export default function Home({ categories, featuredProducts, menuItems = [], locale = 'ar', carouselItems = [] }: HomeProps) {
    const isRTL = locale === 'ar';

    return (
        <>
            <Head title="RosaCare - Authentic Damask Rose Products" />
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />
                {carouselItems.length > 0 ? (
                    <HeroCarousel items={carouselItems} locale={locale} />
                ) : (
                    <HeroSection locale={locale} />
                )}
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
