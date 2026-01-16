import { SparklesIcon, HeartIcon, BeakerIcon, SunIcon } from '@heroicons/react/24/outline';

interface Benefit {
    icon: React.ReactNode;
    title: string;
    description: string;
}

interface AboutData {
    benefits?: {
        title?: string;
        items?: Array<{
            icon_path?: string;
            icon_url?: string;
            title?: string;
            description?: string;
        }>;
        image_url?: string;
    };
}

interface BenefitsSectionProps {
    locale?: string;
    about?: AboutData | null;
}

export function BenefitsSection({ locale = 'ar', about = null }: BenefitsSectionProps) {
    const isRTL = locale === 'ar';

    // Default benefits if no about data
    const defaultBenefits: Benefit[] = [
        {
            icon: <SparklesIcon className="w-12 h-12" />,
            title: locale === 'ar' ? 'فوائد للبشرة' : 'Skin Benefits',
            description: locale === 'ar'
                ? 'ترطيب عميق وتنعيم البشرة وتقليل التجاعيد والخطوط الدقيقة'
                : 'Deep hydration, skin smoothing, and reduction of wrinkles and fine lines',
        },
        {
            icon: <HeartIcon className="w-12 h-12" />,
            title: locale === 'ar' ? 'العافية والاسترخاء' : 'Wellness & Relaxation',
            description: locale === 'ar'
                ? 'خصائص مهدئة طبيعية تساعد على الاسترخاء وتخفيف التوتر'
                : 'Natural soothing properties that help with relaxation and stress relief',
        },
        {
            icon: <SunIcon className="w-12 h-12" />,
            title: locale === 'ar' ? 'القيمة الغذائية' : 'Nutritional Value',
            description: locale === 'ar'
                ? 'غنية بالفيتامينات ومضادات الأكسدة الطبيعية المفيدة للصحة'
                : 'Rich in vitamins and natural antioxidants beneficial for health',
        },
        {
            icon: <BeakerIcon className="w-12 h-12" />,
            title: locale === 'ar' ? '100% طبيعي' : '100% Natural',
            description: locale === 'ar'
                ? 'منتجات طبيعية خالصة بدون إضافات كيميائية أو مواد حافظة'
                : 'Pure natural products without chemical additives or preservatives',
        },
    ];

    // Use about data if available, otherwise use default
    const title = about?.benefits?.title || (locale === 'ar' ? 'فوائد الوردة الشامية' : 'Benefits of Damask Rose');
    const benefitsItems = about?.benefits?.items && about.benefits.items.length > 0
        ? about.benefits.items.map((item, index) => {
            const iconComponents = [SparklesIcon, HeartIcon, SunIcon, BeakerIcon];
            const IconComponent = iconComponents[index % 4] || SparklesIcon;
            return {
                icon: item.icon_url ? (
                    <img src={item.icon_url} alt={item.title || ''} className="w-12 h-12 object-contain" />
                ) : (
                    <IconComponent className="w-12 h-12" />
                ),
                title: item.title || '',
                description: item.description || '',
            };
        })
        : defaultBenefits;

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center ${isRTL ? 'rtl' : 'ltr'}`} style={{ fontFamily: "'Alexandria', sans-serif" }}>
                    {title}
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {benefitsItems.map((benefit, index) => (
                        <div
                            key={index}
                            className="text-center p-6 rounded-lg bg-secondary/50 hover:bg-secondary transition-colors duration-300"
                        >
                            <div className="flex justify-center mb-4 text-primary">
                                {benefit.icon}
                            </div>
                            <h3 className="text-xl font-semibold mb-3" style={{ fontFamily: "'Alexandria', sans-serif" }}>{benefit.title}</h3>
                            <p className="text-muted-foreground" style={{ fontFamily: "'Alexandria', sans-serif" }}>{benefit.description}</p>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
