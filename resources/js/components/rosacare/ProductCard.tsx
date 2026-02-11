import { Link, usePage } from '@inertiajs/react';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import categories from '@/routes/categories';

interface Product {
    id: number;
    slug: string;
    price?: number;
    sale_price?: number;
    translations: Array<{
        locale: string;
        name: string;
        short_description?: string;
    }>;
    category?: {
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

interface ProductCardProps {
    product: Product;
    locale?: string;
}

export function ProductCard({ product, locale = 'ar' }: ProductCardProps) {
    const translation = product.translations.find(t => t.locale === locale) || product.translations[0];
    const featuredImage = product.media?.find(m => m.collection_name === 'featured') || product.media?.[0];
    const categoryTranslation = product.category?.translations?.find(t => t.locale === locale) || product.category?.translations?.[0];
    const page = usePage<any>();
    const settings = page.props.settings;

    // Convert prices to numbers to handle string values from database
    const price = product.price ? Number(product.price) : null;
    const salePrice = product.sale_price ? Number(product.sale_price) : null;
    const currentPrice = salePrice ?? price;

    // Check if prices should be shown (truthy: 1 or true)
    const showPrice = !!settings?.show_price_in_products;

    const isRTL = locale === 'ar';

    return (
        <Card className="group hover:shadow-xl transition-shadow duration-300 overflow-hidden h-full flex flex-col">
            <div className="relative overflow-hidden aspect-square">
                {featuredImage ? (
                    <img
                        src={`/storage/${featuredImage.path}/${featuredImage.file_name}`}
                        alt={translation.name}
                        className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    />
                ) : (
                    <div className="w-full h-full bg-secondary flex items-center justify-center">
                        <span className="text-muted-foreground">{translation.name}</span>
                    </div>
                )}
                {salePrice && price && salePrice < price && (
                    <div className="absolute top-2 right-2 bg-accent text-accent-foreground px-2 py-1 rounded-md text-sm font-semibold z-10">
                        {locale === 'ar' ? 'خصم' : 'Sale'}
                    </div>
                )}
                {categoryTranslation && (
                    <div className={`absolute bottom-3 ${isRTL ? 'left-3' : 'right-3'} z-10`}>
                        <Link
                            href={`/categories/${product.category?.slug}`}
                            className="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-300 hover:scale-105 shadow-lg"
                            style={{
                                background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.95), rgba(134, 44, 145, 0.95))',
                                color: '#ffffff',
                                fontFamily: "'Alexandria', sans-serif",
                                backdropFilter: 'blur(10px)',
                                border: '1px solid rgba(255, 255, 255, 0.2)',
                                boxShadow: '0 4px 15px rgba(231, 33, 119, 0.4)',
                            }}
                            onMouseEnter={(e) => {
                                e.currentTarget.style.boxShadow = '0 6px 20px rgba(231, 33, 119, 0.6)';
                                e.currentTarget.style.transform = 'translateY(-2px)';
                            }}
                            onMouseLeave={(e) => {
                                e.currentTarget.style.boxShadow = '0 4px 15px rgba(231, 33, 119, 0.4)';
                                e.currentTarget.style.transform = 'translateY(0)';
                            }}
                        >
                            {categoryTranslation.name}
                        </Link>
                    </div>
                )}
            </div>
            <CardHeader>
                <h3 className="text-xl font-semibold mb-2">{translation.name}</h3>
                {translation.short_description && (
                    <p className="text-muted-foreground text-sm line-clamp-2">
                        {translation.short_description}
                    </p>
                )}
            </CardHeader>
            <CardContent className="flex-1">
                {showPrice && currentPrice !== null && currentPrice !== undefined && (
                    <div className={`flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
                        {salePrice && price && salePrice < price && (
                            <span className="text-muted-foreground line-through text-sm">
                                {price.toFixed(2)} {settings?.default_currency || (locale === 'ar' ? 'ل.س' : 'SYP')}
                            </span>
                        )}
                        <span className="text-2xl font-bold text-primary">
                            {currentPrice.toFixed(2)} {settings?.default_currency || (locale === 'ar' ? 'ل.س' : 'SYP')}
                        </span>
                    </div>
                )}
            </CardContent>
            <CardFooter className={`flex flex-row p-0 -mx-6 -mb-6 mt-auto ${isRTL ? 'flex-row-reverse' : ''}`}>
                {(() => {
                    const whatsappUrl = settings?.whatsapp;

                    return (
                        <>
                            <Button
                                asChild
                                className="flex-1 rounded-none"
                                variant="outline"
                                style={{
                                    borderRight: whatsappUrl && !isRTL ? 'none' : undefined,
                                    borderLeft: whatsappUrl && isRTL ? 'none' : undefined,
                                    borderRadius: 0,
                                    borderBottomLeftRadius: isRTL ? (whatsappUrl ? 0 : '0.75rem') : (whatsappUrl ? '0.75rem' : '0.75rem'),
                                    borderBottomRightRadius: isRTL ? (whatsappUrl ? '0.75rem' : '0.75rem') : (whatsappUrl ? 0 : '0.75rem'),
                                    margin: 0
                                }}
                            >
                                <Link href={`/products/${product.slug}`}>
                                    {locale === 'ar' ? 'عرض التفاصيل' : 'View Details'}
                                </Link>
                            </Button>
                            {whatsappUrl && (() => {

                                // Build WhatsApp message with product information
                                const productName = translation.name;
                                const productPrice = showPrice && currentPrice !== null && currentPrice !== undefined
                                    ? `${currentPrice.toFixed(2)} ${settings?.default_currency || (locale === 'ar' ? 'ل.س' : 'SYP')}`
                                    : '';
                                const productCategory = categoryTranslation?.name || '';
                                const productUrl = typeof window !== 'undefined' ? `${window.location.origin}/products/${product.slug}` : `/products/${product.slug}`;

                                // Create message based on locale
                                let message = '';
                                if (locale === 'ar') {
                                    message = `مرحباً، أريد طلب المنتج التالي:\n\n`;
                                    message += `📦 المنتج: ${productName}\n`;
                                    if (productCategory) {
                                        message += `🏷️ الفئة: ${productCategory}\n`;
                                    }
                                    if (productPrice) {
                                        message += `💰 السعر: ${productPrice}\n`;
                                    }
                                    message += `🔗 الرابط: ${productUrl}\n\n`;
                                    message += `شكراً لك`;
                                } else {
                                    message = `Hello, I would like to order the following product:\n\n`;
                                    message += `📦 Product: ${productName}\n`;
                                    if (productCategory) {
                                        message += `🏷️ Category: ${productCategory}\n`;
                                    }
                                    if (productPrice) {
                                        message += `💰 Price: ${productPrice}\n`;
                                    }
                                    message += `🔗 Link: ${productUrl}\n\n`;
                                    message += `Thank you`;
                                }

                                // Format WhatsApp URL with message
                                const encodedMessage = encodeURIComponent(message);
                                const whatsappLink = whatsappUrl.includes('?')
                                    ? `${whatsappUrl}&text=${encodedMessage}`
                                    : `${whatsappUrl}?text=${encodedMessage}`;

                                return (
                                    <Button
                                        asChild
                                        className="flex-1 rounded-none"
                                        style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            fontWeight: 500,
                                            background: 'linear-gradient(135deg, #e72177, #862b90)',
                                            border: 'none',
                                            borderRadius: 0,
                                            borderBottomLeftRadius: isRTL ? '0.75rem' : 0,
                                            borderBottomRightRadius: isRTL ? 0 : '0.75rem',
                                            boxShadow: 'none',
                                            margin: 0,
                                            transition: 'all 0.3s ease'
                                        }}
                                        onMouseEnter={(e) => {
                                            e.currentTarget.style.opacity = '0.9';
                                            e.currentTarget.style.transform = 'translateY(-1px)';
                                        }}
                                        onMouseLeave={(e) => {
                                            e.currentTarget.style.opacity = '1';
                                            e.currentTarget.style.transform = 'translateY(0)';
                                        }}
                                    >
                                        <a
                                            href={whatsappLink}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            {locale === 'ar' ? 'اطلب الآن' : 'Order Now'}
                                        </a>
                                    </Button>
                                );
                            })()}
                        </>
                    );
                })()}
            </CardFooter>
        </Card>
    );
}
