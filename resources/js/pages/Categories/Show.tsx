import { Head, usePage } from '@inertiajs/react';
import { ProductCard } from '@/components/rosacare/ProductCard';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';

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

interface CategoriesShowProps {
    category: Category;
    products: {
        data: Product[];
        links: any;
        meta: any;
    };
    locale?: string;
}

export default function CategoriesShow({ category, products, locale = 'ar' }: CategoriesShowProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];
    const translation = category.translations.find(t => t.locale === locale) || category.translations[0];

    return (
        <>
            <Head title={`${translation.name} - RosaCare`} />
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />
                <section className="py-20 bg-secondary/30">
                    <div className="container mx-auto px-4">
                        <h1 className={`text-4xl md:text-5xl font-bold mb-4 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                            {translation.name}
                        </h1>
                        {translation.description && (
                            <p className={`text-lg text-muted-foreground text-center mb-12 max-w-3xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                                {translation.description}
                            </p>
                        )}

                        {products.data.length > 0 ? (
                            <>
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                    {products.data.map((product) => (
                                        <ProductCard key={product.id} product={product} locale={locale} />
                                    ))}
                                </div>

                                {/* Pagination */}
                                {products.links && products.links.length > 3 && (
                                    <div className="flex justify-center gap-2">
                                        {products.links.map((link: any, index: number) => (
                                            <a
                                                key={index}
                                                href={link.url || '#'}
                                                className={`px-4 py-2 rounded-md ${
                                                    link.active
                                                        ? 'bg-primary text-primary-foreground'
                                                        : 'bg-background border border-border hover:bg-secondary'
                                                } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                                dangerouslySetInnerHTML={{ __html: link.label }}
                                            />
                                        ))}
                                    </div>
                                )}
                            </>
                        ) : (
                            <div className="text-center py-12">
                                <p className="text-muted-foreground text-lg">
                                    {locale === 'ar' ? 'لا توجد منتجات في هذه الفئة' : 'No products in this category'}
                                </p>
                            </div>
                        )}
                    </div>
                </section>
                <Footer locale={locale} />
            </div>
        </>
    );
}
