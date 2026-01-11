import { Link } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';

interface Category {
    id: number;
    slug: string;
    icon?: string;
    image?: string;
    image_url?: string;
    translations: Array<{
        locale: string;
        name: string;
        description?: string;
    }>;
}

interface CategoryShowcaseProps {
    categories: Category[];
    locale?: string;
}

export function CategoryShowcase({ categories, locale = 'ar' }: CategoryShowcaseProps) {
    const isRTL = locale === 'ar';

    return (
        <section className="py-20 bg-secondary/30">
            <div className="container mx-auto px-4">
                <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    {locale === 'ar' ? 'فئات المنتجات' : 'Product Categories'}
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {categories.map((category) => {
                        const translation = category.translations.find(t => t.locale === locale) || category.translations[0];
                        
                        // Get image URL - prioritize image_url accessor, then image path, then icon
                        const imageUrl = category.image_url 
                            || (category.image ? `/storage/${category.image}` : null)
                            || category.icon || null;

                        return (
                            <Link key={category.id} href={`/categories/${category.slug}`}>
                                <Card className="hover:shadow-xl transition-all duration-300 hover:-translate-y-2 h-full cursor-pointer overflow-hidden">
                                    <CardContent className="p-0">
                                        {/* Image Section */}
                                        {imageUrl && (
                                            <div className="relative h-48 w-full overflow-hidden bg-secondary/20">
                                                <img 
                                                    src={imageUrl} 
                                                    alt={translation.name} 
                                                    className="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
                                                />
                                            </div>
                                        )}
                                        {/* Content Section */}
                                        <div className="p-8 text-center">
                                            <h3 className="text-2xl font-semibold mb-4">{translation.name}</h3>
                                            {translation.description && (
                                                <p className="text-muted-foreground">{translation.description}</p>
                                            )}
                                        </div>
                                    </CardContent>
                                </Card>
                            </Link>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
