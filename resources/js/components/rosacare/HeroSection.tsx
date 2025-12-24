import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface HeroSectionProps {
    locale?: string;
}

export function HeroSection({ locale = 'ar' }: HeroSectionProps) {
    const isRTL = locale === 'ar';

    return (
        <section className="relative min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-primary/10 via-secondary to-primary/5 overflow-hidden">
            {/* Decorative background elements */}
            <div className="absolute inset-0 opacity-10">
                <div className="absolute top-20 left-10 w-72 h-72 bg-primary rounded-full blur-3xl"></div>
                <div className="absolute bottom-20 right-10 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
            </div>

            <div className="container relative z-10 mx-auto px-4 py-20">
                <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 text-foreground">
                        {locale === 'ar' ? 'روزاكير' : 'RosaCare'}
                    </h1>
                    <p className="text-xl md:text-2xl text-muted-foreground mb-8 leading-relaxed">
                        {locale === 'ar' 
                            ? 'من قلب الشام، أرقى منتجات الوردة الشامية الأصيلة'
                            : 'From the heart of Syria, the finest authentic Damask Rose products'}
                    </p>
                    <p className="text-lg text-muted-foreground mb-12 max-w-2xl mx-auto">
                        {locale === 'ar'
                            ? 'اكتشف جمال الطبيعة في أنقى صورها. منتجات طبيعية 100% مستخرجة بعناية فائقة من الوردة الشامية الأصيلة.'
                            : 'Discover nature\'s beauty in its purest form. 100% natural products carefully extracted from authentic Damask Roses.'}
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button asChild size="lg" className="text-lg px-8 py-6">
                            <Link href="/products">
                                {locale === 'ar' ? 'استكشف المنتجات' : 'Explore Products'}
                            </Link>
                        </Button>
                        <Button asChild variant="outline" size="lg" className="text-lg px-8 py-6">
                            <Link href="/about">
                                {locale === 'ar' ? 'قصتنا' : 'Our Story'}
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </section>
    );
}
