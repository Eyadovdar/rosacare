import { Link } from '@inertiajs/react';
import { Card, CardContent } from '@/components/ui/card';
import { Sparkles, Heart, Flower } from 'lucide-react';

interface Category {
    id: number;
    slug: string;
    icon?: string;
    image?: string;
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

export function CategoryShowcase({ categories, locale = 'en' }: CategoryShowcaseProps) {
    const isRTL = locale === 'ar';
    const defaultIcons = [Sparkles, Heart, Flower];

    return (
        <section className="py-20 bg-secondary/30">
            <div className="container mx-auto px-4">
                <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    {locale === 'ar' ? 'فئات المنتجات' : 'Product Categories'}
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {categories.map((category, index) => {
                        const translation = category.translations.find(t => t.locale === locale) || category.translations[0];
                        const IconComponent = defaultIcons[index % defaultIcons.length];

                        return (
                            <Link key={category.id} href={`/categories/${category.slug}`}>
                                <Card className="hover:shadow-xl transition-all duration-300 hover:-translate-y-2 h-full cursor-pointer">
                                    <CardContent className="p-8 text-center">
                                        <div className="mb-6 flex justify-center">
                                            {category.icon ? (
                                                <img src={category.icon} alt={translation.name} className="w-16 h-16" />
                                            ) : (
                                                <IconComponent className="w-16 h-16 text-primary" />
                                            )}
                                        </div>
                                        <h3 className="text-2xl font-semibold mb-4">{translation.name}</h3>
                                        {translation.description && (
                                            <p className="text-muted-foreground">{translation.description}</p>
                                        )}
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
