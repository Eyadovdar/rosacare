import { CheckCircle2 } from 'lucide-react';

interface WhyRosaCareSectionProps {
    locale?: string;
}

export function WhyRosaCareSection({ locale = 'ar' }: WhyRosaCareSectionProps) {
    const isRTL = locale === 'ar';

    const reasons = [
        {
            title: locale === 'ar' ? 'مكونات طبيعية' : 'Natural Ingredients',
            description: locale === 'ar'
                ? '100% منتجات طبيعية مستخرجة من أجود أنواع الوردة الشامية'
                : '100% natural products extracted from the finest Damask Roses',
        },
        {
            title: locale === 'ar' ? 'بدون مواد كيميائية' : 'No Chemicals',
            description: locale === 'ar'
                ? 'خالية تماماً من المواد الكيميائية والمواد الحافظة الصناعية'
                : 'Completely free from chemicals and synthetic preservatives',
        },
        {
            title: locale === 'ar' ? 'تراث موثوق' : 'Trusted Heritage',
            description: locale === 'ar'
                ? 'طرق تقليدية سورية أصيلة تم تناقلها عبر الأجيال'
                : 'Authentic traditional Syrian methods passed down through generations',
        },
        {
            title: locale === 'ar' ? 'ممارسات مستدامة' : 'Sustainable Practices',
            description: locale === 'ar'
                ? 'التزام بالاستدامة والمسؤولية البيئية في جميع عملياتنا'
                : 'Commitment to sustainability and environmental responsibility in all our operations',
        },
    ];

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    {locale === 'ar' ? 'لماذا روزاكير؟' : 'Why RosaCare?'}
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    {reasons.map((reason, index) => (
                        <div key={index} className="flex gap-4 p-6 rounded-lg bg-secondary/50 hover:bg-secondary transition-colors">
                            <div className="flex-shrink-0">
                                <CheckCircle2 className="w-8 h-8 text-primary" />
                            </div>
                            <div className={isRTL ? 'rtl' : 'ltr'}>
                                <h3 className="text-xl font-semibold mb-2">{reason.title}</h3>
                                <p className="text-muted-foreground">{reason.description}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
