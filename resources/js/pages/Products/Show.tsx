import { Head, Link, usePage } from '@inertiajs/react';
import { ProductCard } from '@/components/rosacare/ProductCard';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { useState, useEffect } from 'react';

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
    const settings = page.props.settings;
    const translation = product.translations.find(t => t.locale === locale) || product.translations[0];
    const categoryTranslation = product.category.translations.find(t => t.locale === locale) || product.category.translations[0];

    // Combine all images: featured first, then gallery images
    const featuredImage = product.media?.find(m => m.collection_name === 'featured') || product.media?.[0];
    const galleryImages = product.media?.filter(m => m.collection_name === 'gallery') || [];

    // Create combined array with featured image first
    const allImages = featuredImage
        ? [featuredImage, ...galleryImages.filter(img => img.id !== featuredImage.id)]
        : [...galleryImages];

    const [selectedImageIndex, setSelectedImageIndex] = useState(0);
    const [isFading, setIsFading] = useState(false);
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        setIsVisible(true);
    }, []);

    const handleImageClick = (index: number) => {
        if (index === selectedImageIndex) return;

        setIsFading(true);
        setTimeout(() => {
            setSelectedImageIndex(index);
            setIsFading(false);
        }, 300); // Half of fade animation duration
    };

    const getImageUrl = (image: typeof allImages[0]) => {
        return `/storage/${image.path}/${image.file_name}`;
    };

    // Convert prices to numbers to handle string values from database
    const price = product.price ? Number(product.price) : null;
    const salePrice = product.sale_price ? Number(product.sale_price) : null;
    const currentPrice = salePrice ?? price;

    // Check if prices should be shown (truthy: 1 or true)
    const showPrice = !!settings?.show_price_in_products;

    return (
        <>
            <Head title={`${translation.name} - RosaCare`} />
            <style>{`
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                @keyframes float {
                    0%, 100% {
                        transform: translate(0, 0) rotate(0deg);
                    }
                    33% {
                        transform: translate(30px, -30px) rotate(120deg);
                    }
                    66% {
                        transform: translate(-30px, 30px) rotate(240deg);
                    }
                }
                @keyframes imageFade {
                    0% { opacity: 0; }
                    50% { opacity: 0; }
                    100% { opacity: 1; }
                }
                .rose-petals {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                    z-index: 1;
                    overflow: hidden;
                }
                .rose-petals::before,
                .rose-petals::after {
                    content: '';
                    position: absolute;
                    width: 250px;
                    height: 250px;
                    border-radius: 50% 0 50% 0;
                    background: linear-gradient(135deg, rgba(231, 33, 119, 0.08), rgba(134, 44, 145, 0.08));
                    animation: float 20s infinite ease-in-out;
                }
                .rose-petals::before {
                    top: 20%;
                    left: 5%;
                    animation-delay: 0s;
                }
                .rose-petals::after {
                    top: 50%;
                    right: 5%;
                    animation-delay: 10s;
                }
                .product-content {
                    position: relative;
                    z-index: 2;
                }
                .fade-in-up {
                    animation: fadeInUp 1s ease-out both;
                }
                .fade-in {
                    animation: fadeIn 1s ease-out both;
                }
                .image-fade {
                    animation: imageFade 0.6s ease-in-out;
                }
                .main-image-container {
                    position: relative;
                    overflow: hidden;
                }
                .main-image {
                    transition: opacity 0.6s ease-in-out;
                }
                .main-image.fading {
                    opacity: 0;
                }
                .gallery-scroll {
                    display: flex;
                    gap: 1rem;
                    overflow-x: auto;
                    padding: 0.5rem 0;
                    scrollbar-width: thin;
                    scrollbar-color: rgba(231, 33, 119, 0.3) transparent;
                }
                .gallery-scroll::-webkit-scrollbar {
                    height: 6px;
                }
                .gallery-scroll::-webkit-scrollbar-track {
                    background: transparent;
                }
                .gallery-scroll::-webkit-scrollbar-thumb {
                    background: rgba(231, 33, 119, 0.3);
                    border-radius: 3px;
                }
                .gallery-scroll::-webkit-scrollbar-thumb:hover {
                    background: rgba(231, 33, 119, 0.5);
                }
                .gallery-thumb {
                    flex-shrink: 0;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    border: 2px solid transparent;
                }
                .gallery-thumb:hover {
                    transform: scale(1.05);
                    border-color: #e72177;
                }
                .gallery-thumb.active {
                    border-color: #e72177;
                    box-shadow: 0 0 0 3px rgba(231, 33, 119, 0.2);
                }
            `}</style>
            <div className={`min-h-screen relative ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                {/* Animated Rose Petals Background */}
                <div className="rose-petals" />

                <Navbar menuItems={menuItems} locale={locale} />
                <section className="py-20 relative" style={{
                    background: 'linear-gradient(135deg, #f5f5f5 0%, #ffffff 50%, #fafafa 100%)',
                    minHeight: 'calc(100vh - 4rem)'
                }}>
                    <div className="container mx-auto px-4 max-w-7xl product-content">
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                            {/* Product Images */}
                            <div className={`fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '0.3s' }}>
                                {allImages.length > 0 && (
                                    <>
                                        {/* Main Image */}
                                        <div className="main-image-container mb-6 rounded-lg overflow-hidden" style={{
                                            background: 'rgba(255, 255, 255, 0.8)',
                                            boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                        }}>
                                            <img
                                                src={getImageUrl(allImages[selectedImageIndex])}
                                                alt={translation.name}
                                                className={`main-image w-full h-auto object-cover ${isFading ? 'fading' : ''}`}
                                                style={{
                                                    maxHeight: '600px',
                                                    minHeight: '400px',
                                                    objectFit: 'contain'
                                                }}
                                            />
                                        </div>

                                        {/* Gallery Thumbnails - All images next to each other */}
                                        {allImages.length > 1 && (
                                            <div className="gallery-scroll">
                                                {allImages.map((image, index) => (
                                                    <div
                                                        key={image.id}
                                                        onClick={() => handleImageClick(index)}
                                                        className={`gallery-thumb rounded-lg overflow-hidden ${index === selectedImageIndex ? 'active' : ''}`}
                                                        style={{
                                                            width: '120px',
                                                            height: '120px',
                                                            background: '#ffffff'
                                                        }}
                                                    >
                                                        <img
                                                            src={getImageUrl(image)}
                                                            alt={`${translation.name} - ${index + 1}`}
                                                            className="w-full h-full object-cover"
                                                        />
                                                    </div>
                                                ))}
                                            </div>
                                        )}
                                    </>
                                )}
                            </div>

                            {/* Product Details */}
                            <div className={`fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '0.5s' }}>
                                <div style={{
                                    padding: '2rem',
                                    background: 'rgba(255, 255, 255, 0.8)',
                                    borderRadius: '20px',
                                    boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                }}>
                                    <Link
                                        href={`/categories/${product.category.slug}`}
                                        className="text-[#e72177] hover:underline mb-4 inline-block"
                                        style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            fontWeight: 400
                                        }}
                                    >
                                        {categoryTranslation.name}
                                    </Link>
                                    <h1 className="text-4xl md:text-5xl font-light mb-6" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        color: '#545759',
                                        letterSpacing: '0.05em'
                                    }}>
                                        {translation.name}
                                    </h1>

                                    {showPrice && currentPrice !== null && currentPrice !== undefined && (
                                        <div className={`flex items-center gap-4 mb-6 ${isRTL ? 'flex-row-reverse' : ''}`}>
                                            {salePrice && price && salePrice < price && (
                                                <span className="text-muted-foreground line-through text-xl" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    color: '#bdc4c8'
                                                }}>
                                                    {price.toFixed(2)} {locale === 'ar' ? 'ل.س' : 'USD'}
                                                </span>
                                            )}
                                            <span className="text-3xl font-medium" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                color: '#e72177'
                                            }}>
                                                {currentPrice.toFixed(2)} {locale === 'ar' ? 'ل.س' : 'USD'}
                                            </span>
                                        </div>
                                    )}

                                    {translation.short_description && (
                                        <p className="text-lg mb-6" style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            fontWeight: 300,
                                            color: '#545759',
                                            lineHeight: '1.8'
                                        }}>
                                            {translation.short_description}
                                        </p>
                                    )}

                                    {translation.description && (
                                        <div className="prose max-w-none mb-6">
                                            <p className="whitespace-pre-line" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 300,
                                                color: '#545759',
                                                lineHeight: '1.8'
                                            }}>
                                                {translation.description}
                                            </p>
                                        </div>
                                    )}


                                    <Button
                                        size="lg"
                                        className="w-full md:w-auto"
                                        style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            fontWeight: 500,
                                            background: 'linear-gradient(135deg, #e72177, #862b90)',
                                            border: 'none',
                                            boxShadow: '0 5px 20px rgba(231, 33, 119, 0.3)'
                                        }}
                                    >
                                        {locale === 'ar' ? 'اطلب الآن' : 'Order Now'}
                                    </Button>
                                </div>
                            </div>
                        </div>

                        {/* Ingredients, Benefits, and Usage Instructions - Three Columns */}
                        {((translation.ingredients?.length ?? 0) > 0 || (translation.benefits?.length ?? 0) > 0 || (translation.usage_instructions?.length ?? 0) > 0) && (
                            <div className={`mb-16 fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '0.6s' }}>
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    {/* Ingredients */}
                                    {translation.ingredients && translation.ingredients.length > 0 && (
                                        <Card style={{
                                            background: 'rgba(255, 255, 255, 0.8)',
                                            border: '2px solid #bdc4c8',
                                            borderRadius: '20px',
                                            boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                        }}>
                                            <CardContent className="p-6">
                                                <h3 className="font-medium text-xl mb-4 text-center" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    color: '#862b90',
                                                    letterSpacing: '0.05em'
                                                }}>
                                                    {locale === 'ar' ? 'المكونات' : 'Ingredients'}
                                                </h3>
                                                <div className="divider" style={{
                                                    width: '60px',
                                                    height: '2px',
                                                    background: 'linear-gradient(90deg, transparent, #e72177, transparent)',
                                                    margin: '0 auto 1.5rem'
                                                }} />
                                                <ul className="space-y-2" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    color: '#545759'
                                                }}>
                                                    {translation.ingredients.map((ingredient, index) => (
                                                        <li key={index} className="flex items-start gap-2">
                                                            <span className="text-[#e72177] mt-1" style={{ fontSize: '0.75rem' }}>●</span>
                                                            <span>{ingredient}</span>
                                                        </li>
                                                    ))}
                                                </ul>
                                            </CardContent>
                                        </Card>
                                    )}

                                    {/* Benefits */}
                                    {translation.benefits && translation.benefits.length > 0 && (
                                        <Card style={{
                                            background: 'rgba(255, 255, 255, 0.8)',
                                            border: '2px solid #bdc4c8',
                                            borderRadius: '20px',
                                            boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                        }}>
                                            <CardContent className="p-6">
                                                <h3 className="font-medium text-xl mb-4 text-center" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    color: '#862b90',
                                                    letterSpacing: '0.05em'
                                                }}>
                                                    {locale === 'ar' ? 'الفوائد' : 'Benefits'}
                                                </h3>
                                                <div className="divider" style={{
                                                    width: '60px',
                                                    height: '2px',
                                                    background: 'linear-gradient(90deg, transparent, #e72177, transparent)',
                                                    margin: '0 auto 1.5rem'
                                                }} />
                                                <ul className="space-y-2" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    color: '#545759'
                                                }}>
                                                    {translation.benefits.map((benefit, index) => (
                                                        <li key={index} className="flex items-start gap-2">
                                                            <span className="text-[#e72177] mt-1" style={{ fontSize: '0.75rem' }}>●</span>
                                                            <span>{benefit}</span>
                                                        </li>
                                                    ))}
                                                </ul>
                                            </CardContent>
                                        </Card>
                                    )}

                                    {/* Usage Instructions */}
                                    {translation.usage_instructions && translation.usage_instructions.length > 0 && (
                                        <Card style={{
                                            background: 'rgba(255, 255, 255, 0.8)',
                                            border: '2px solid #bdc4c8',
                                            borderRadius: '20px',
                                            boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                        }}>
                                            <CardContent className="p-6">
                                                <h3 className="font-medium text-xl mb-4 text-center" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    color: '#862b90',
                                                    letterSpacing: '0.05em'
                                                }}>
                                                    {locale === 'ar' ? 'طريقة الاستخدام' : 'Usage Instructions'}
                                                </h3>
                                                <div className="divider" style={{
                                                    width: '60px',
                                                    height: '2px',
                                                    background: 'linear-gradient(90deg, transparent, #e72177, transparent)',
                                                    margin: '0 auto 1.5rem'
                                                }} />
                                                <ul className="space-y-2" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    color: '#545759'
                                                }}>
                                                    {translation.usage_instructions.map((instruction, index) => (
                                                        <li key={index} className="flex items-start gap-2">
                                                            <span className="text-[#e72177] mt-1" style={{ fontSize: '0.75rem' }}>●</span>
                                                            <span>{instruction}</span>
                                                        </li>
                                                    ))}
                                                </ul>
                                            </CardContent>
                                        </Card>
                                    )}
                                </div>
                            </div>
                        )}

                        {/* Related Products */}
                        {relatedProducts.length > 0 && (
                            <div className={`fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '0.7s' }}>
                                <h2 className={`text-3xl md:text-4xl font-light mb-8 ${isRTL ? 'rtl' : 'ltr'}`} style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    color: '#545759',
                                    letterSpacing: '0.05em'
                                }}>
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
