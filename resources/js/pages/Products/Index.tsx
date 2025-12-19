import { Head, Link } from '@inertiajs/react';
import { ProductCard } from '@/components/rosacare/ProductCard';
import { Footer } from '@/components/rosacare/Footer';
import { Button } from '@/components/ui/button';

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

interface Category {
    id: number;
    slug: string;
    translations: Array<{
        locale: string;
        name: string;
    }>;
}

interface ProductsIndexProps {
    products: {
        data: Product[];
        links: any;
        meta: any;
    };
    categories: Category[];
    selectedCategory?: number;
    locale?: string;
}

export default function ProductsIndex({ products, categories, selectedCategory, locale = 'en' }: ProductsIndexProps) {
    const isRTL = locale === 'ar';

    return (
        <>
            <Head title={locale === 'ar' ? 'المنتجات - روزاكير' : 'Products - RosaCare'} />
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <section className="py-20 bg-secondary/30">
                    <div className="container mx-auto px-4">
                        <h1 className={`text-4xl md:text-5xl font-bold mb-8 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                            {locale === 'ar' ? 'جميع المنتجات' : 'All Products'}
                        </h1>
                        
                        {/* Category Filter */}
                        <div className="flex flex-wrap gap-4 justify-center mb-12">
                            <Button
                                asChild
                                variant={!selectedCategory ? 'default' : 'outline'}
                            >
                                <Link href="/products">
                                    {locale === 'ar' ? 'الكل' : 'All'}
                                </Link>
                            </Button>
                            {categories.map((category) => {
                                const translation = category.translations.find(t => t.locale === locale) || category.translations[0];
                                return (
                                    <Button
                                        key={category.id}
                                        asChild
                                        variant={selectedCategory === category.id ? 'default' : 'outline'}
                                    >
                                        <Link href={`/products?category=${category.id}`}>
                                            {translation.name}
                                        </Link>
                                    </Button>
                                );
                            })}
                        </div>

                        {/* Products Grid */}
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
                                            <Button
                                                key={index}
                                                asChild
                                                variant={link.active ? 'default' : 'outline'}
                                                disabled={!link.url}
                                            >
                                                {link.url ? (
                                                    <Link href={link.url} dangerouslySetInnerHTML={{ __html: link.label }} />
                                                ) : (
                                                    <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                                )}
                                            </Button>
                                        ))}
                                    </div>
                                )}
                            </>
                        ) : (
                            <div className="text-center py-12">
                                <p className="text-muted-foreground text-lg">
                                    {locale === 'ar' ? 'لا توجد منتجات متاحة' : 'No products available'}
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
