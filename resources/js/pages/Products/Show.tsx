import { Head, Link, usePage } from '@inertiajs/react';
import { ProductCard } from '@/components/rosacare/ProductCard';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

interface Product {
    id: number;
    slug: string;
    price?: number;
    sale_price?: number;
    translations: Array<{
        locale: string;
        name: string;
        description?: string;
        short_description?: string;
        ingredients?: string[];
        benefits?: string[];
        usage_instructions?: string[];
    }>;
    category: {
        slug: string;
        translations: Array<{
            locale: string;
            name: string;
        }>;
    };
    media?: Array<{
        id: number;
        file_name: string;
        path: string;
        collection_name: string;
    }>;
}

interface ProductsShowProps {
    product: Product;
    relatedProducts: Product[];
    locale?: string;
}

export default function ProductsShow({ product, relatedProducts, locale = 'ar' }: ProductsShowProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];
    const translation = product.translations.find(t => t.locale === locale) || product.translations[0];
    const categoryTranslation = product.category.translations.find(t => t.locale === locale) || product.category.translations[0];
    const featuredImage = product.media?.find(m => m.collection_name === 'featured') || product.media?.[0];
    const galleryImages = product.media?.filter(m => m.collection_name === 'gallery') || [];
    const currentPrice = product.sale_price ?? product.price;

    return (
        <>
            <Head title={`${translation.name} - RosaCare`} />
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />
                <section className="py-20 bg-background">
                    <div className="container mx-auto px-4">
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                            {/* Product Images */}
                            <div>
                                {featuredImage && (
                                    <div className="mb-4">
                                        <img
                                            src={`/storage/${featuredImage.path}/${featuredImage.file_name}`}
                                            alt={translation.name}
                                            className="w-full rounded-lg"
                                        />
                                    </div>
                                )}
                                {galleryImages.length > 0 && (
                                    <div className="grid grid-cols-4 gap-4">
                                        {galleryImages.map((image) => (
                                            <img
                                                key={image.id}
                                                src={`/storage/${image.path}/${image.file_name}`}
                                                alt={translation.name}
                                                className="w-full rounded-lg cursor-pointer hover:opacity-75 transition-opacity"
                                            />
                                        ))}
                                    </div>
                                )}
                            </div>

                            {/* Product Details */}
                            <div>
                                <Link
                                    href={`/categories/${product.category.slug}`}
                                    className="text-primary hover:underline mb-4 inline-block"
                                >
                                    {categoryTranslation.name}
                                </Link>
                                <h1 className="text-4xl font-bold mb-4">{translation.name}</h1>
                                
                                {currentPrice && (
                                    <div className={`flex items-center gap-4 mb-6 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                        {product.sale_price && product.price && (
                                            <span className="text-muted-foreground line-through text-xl">
                                                {product.price.toFixed(2)} {locale === 'ar' ? 'ل.س' : 'USD'}
                                            </span>
                                        )}
                                        <span className="text-3xl font-bold text-primary">
                                            {currentPrice.toFixed(2)} {locale === 'ar' ? 'ل.س' : 'USD'}
                                        </span>
                                    </div>
                                )}

                                {translation.short_description && (
                                    <p className="text-lg text-muted-foreground mb-6">
                                        {translation.short_description}
                                    </p>
                                )}

                                {translation.description && (
                                    <div className="prose max-w-none mb-6">
                                        <p className="text-muted-foreground whitespace-pre-line">
                                            {translation.description}
                                        </p>
                                    </div>
                                )}

                                {translation.ingredients && translation.ingredients.length > 0 && (
                                    <Card className="mb-6">
                                        <CardContent className="p-6">
                                            <h3 className="font-semibold text-lg mb-3">
                                                {locale === 'ar' ? 'المكونات' : 'Ingredients'}
                                            </h3>
                                            <ul className="list-disc list-inside space-y-1 text-muted-foreground">
                                                {translation.ingredients.map((ingredient, index) => (
                                                    <li key={index}>{ingredient}</li>
                                                ))}
                                            </ul>
                                        </CardContent>
                                    </Card>
                                )}

                                {translation.benefits && translation.benefits.length > 0 && (
                                    <Card className="mb-6">
                                        <CardContent className="p-6">
                                            <h3 className="font-semibold text-lg mb-3">
                                                {locale === 'ar' ? 'الفوائد' : 'Benefits'}
                                            </h3>
                                            <ul className="list-disc list-inside space-y-1 text-muted-foreground">
                                                {translation.benefits.map((benefit, index) => (
                                                    <li key={index}>{benefit}</li>
                                                ))}
                                            </ul>
                                        </CardContent>
                                    </Card>
                                )}

                                {translation.usage_instructions && translation.usage_instructions.length > 0 && (
                                    <Card className="mb-6">
                                        <CardContent className="p-6">
                                            <h3 className="font-semibold text-lg mb-3">
                                                {locale === 'ar' ? 'طريقة الاستخدام' : 'Usage Instructions'}
                                            </h3>
                                            <ul className="list-disc list-inside space-y-1 text-muted-foreground">
                                                {translation.usage_instructions.map((instruction, index) => (
                                                    <li key={index}>{instruction}</li>
                                                ))}
                                            </ul>
                                        </CardContent>
                                    </Card>
                                )}

                                <Button size="lg" className="w-full md:w-auto">
                                    {locale === 'ar' ? 'إضافة إلى السلة' : 'Add to Cart'}
                                </Button>
                            </div>
                        </div>

                        {/* Related Products */}
                        {relatedProducts.length > 0 && (
                            <div>
                                <h2 className={`text-3xl font-bold mb-8 ${isRTL ? 'rtl' : 'ltr'}`}>
                                    {locale === 'ar' ? 'منتجات ذات صلة' : 'Related Products'}
                                </h2>
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                    {relatedProducts.map((relatedProduct) => (
                                        <ProductCard key={relatedProduct.id} product={relatedProduct} locale={locale} />
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </section>
                <Footer locale={locale} />
            </div>
        </>
    );
}
