import { Link } from '@inertiajs/react';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

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
    
    // Convert prices to numbers to handle string values from database
    const price = product.price ? Number(product.price) : null;
    const salePrice = product.sale_price ? Number(product.sale_price) : null;
    const currentPrice = salePrice ?? price;
    
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
                    <div className="absolute top-2 right-2 bg-accent text-accent-foreground px-2 py-1 rounded-md text-sm font-semibold">
                        {locale === 'ar' ? 'خصم' : 'Sale'}
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
                {currentPrice !== null && currentPrice !== undefined && (
                    <div className={`flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
                        {salePrice && price && salePrice < price && (
                            <span className="text-muted-foreground line-through text-sm">
                                {price.toFixed(2)} {locale === 'ar' ? 'ل.س' : 'USD'}
                            </span>
                        )}
                        <span className="text-2xl font-bold text-primary">
                            {currentPrice.toFixed(2)} {locale === 'ar' ? 'ل.س' : 'USD'}
                        </span>
                    </div>
                )}
            </CardContent>
            <CardFooter>
                <Button asChild className="w-full" variant="outline">
                    <Link href={`/products/${product.slug}`}>
                        {locale === 'ar' ? 'عرض التفاصيل' : 'View Details'}
                    </Link>
                </Button>
            </CardFooter>
        </Card>
    );
}
