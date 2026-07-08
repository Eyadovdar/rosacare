import { SparklesIcon, HeartIcon, BeakerIcon, SunIcon } from '@heroicons/react/24/outline';

interface Benefit {
    icon: React.ReactNode;
    title: string;
    description: string;
    language?: string;
}

interface AboutData {
    benefits?: {
        title?: string;
        items?: Array<{
            icon_path?: string;
            icon_url?: string;
            title?: string;
            description?: string;
            language?: string;
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

    // Use about data if available, otherwise use default
    const title = about?.benefits?.title || (locale === 'ar' ? 'فوائد الوردة الشامية' : 'Benefits of Damask Rose');


    const benefitsItems = about?.benefits?.items && about.benefits.items.length > 0
        ? about.benefits.items
            .filter(item => item.language === locale)
            .map((item, index) => {
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
        : [];

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
