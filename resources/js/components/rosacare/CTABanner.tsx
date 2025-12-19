import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface CTABannerProps {
    locale?: string;
}

export function CTABanner({ locale = 'en' }: CTABannerProps) {
    const isRTL = locale === 'ar';

    return (
        <section className="py-20 bg-gradient-to-r from-primary to-primary/80 text-primary-foreground">
            <div className="container mx-auto px-4">
                <div className={`max-w-3xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-6">
                        {locale === 'ar' 
                            ? 'اكتشف جمال الوردة الشامية' 
                            : 'Discover the Beauty of Damask Rose'}
                    </h2>
                    <p className="text-xl mb-8 opacity-90">
                        {locale === 'ar'
                            ? 'استكشف مجموعتنا الكاملة من المنتجات الطبيعية الفاخرة'
                            : 'Explore our complete collection of premium natural products'}
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button asChild size="lg" variant="secondary" className="text-lg px-8 py-6">
                            <Link href="/products">
                                {locale === 'ar' ? 'تصفح المنتجات' : 'Browse Products'}
                            </Link>
                        </Button>
                        <Button asChild size="lg" variant="outline" className="text-lg px-8 py-6 border-primary-foreground text-primary-foreground hover:bg-primary-foreground hover:text-primary">
                            <Link href="/contact">
                                {locale === 'ar' ? 'تواصل معنا' : 'Contact Us'}
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </section>
    );
}
