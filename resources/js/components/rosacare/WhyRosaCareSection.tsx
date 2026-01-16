import { CheckCircle2 } from 'lucide-react';
import { useEffect, useState } from 'react';

interface AboutData {
    whyRosaCare?: {
        title?: string;
        reasons?: Array<{
            icon_path?: string;
            icon_url?: string;
            title?: string;
            description?: string;
        }>;
        image_url?: string;
    };
}

interface WhyRosaCareSectionProps {
    locale?: string;
    about?: AboutData | null;
}

export function WhyRosaCareSection({ locale = 'ar', about = null }: WhyRosaCareSectionProps) {
    const isRTL = locale === 'ar';
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        setIsVisible(true);
    }, []);

    // Default reasons if no about data
    const defaultReasons = [
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

    // Use about data if available, otherwise use default
    const title = about?.whyRosaCare?.title || (locale === 'ar' ? 'لماذا روزاكير؟' : 'Why RosaCare?');
    const reasons = about?.whyRosaCare?.reasons && about.whyRosaCare.reasons.length > 0
        ? about.whyRosaCare.reasons
        : defaultReasons;

    return (
        <section className="py-20 bg-gradient-to-br from-secondary/50 to-background relative overflow-hidden">
            <style>{`
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
                .why-rosacare-fade-in {
                    animation: fadeInUp 0.8s ease-out both;
                }
                .why-rosacare-card {
                    animation: fadeInUp 0.8s ease-out both;
                    transition: all 0.3s ease;
                    position: relative;
                    overflow: hidden;
                }
                .why-rosacare-card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg, transparent, rgba(231, 33, 119, 0.1), transparent);
                    transition: left 0.5s ease;
                }
                .why-rosacare-card:hover::before {
                    left: 100%;
                }
                .why-rosacare-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 15px 40px rgba(231, 33, 119, 0.2);
                }
            `}</style>

            <div className="container mx-auto px-4 relative" style={{ zIndex: 10 }}>
                <div className={`max-w-5xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`} style={{ position: 'relative', zIndex: 1 }}>
                    <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center why-rosacare-fade-in ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{
                        fontFamily: "'Alexandria', sans-serif",
                        color: '#545759',
                        letterSpacing: '0.05em',
                        animationDelay: '0.2s'
                    }}>
                        {title}
                    </h2>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {reasons.map((reason, index) => (
                            <div
                                key={index}
                                className="why-rosacare-card flex gap-6 p-8 rounded-2xl bg-background/80 backdrop-blur-sm border border-border"
                                style={{
                                    animationDelay: `${0.3 + index * 0.1}s`,
                                    boxShadow: '0 10px 30px rgba(231, 33, 119, 0.1)',
                                }}
                            >
                                <div className="flex-shrink-0">
                                    <div className="w-16 h-16 rounded-full flex items-center justify-center" style={{
                                        background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.1), rgba(134, 44, 145, 0.1))',
                                        border: '2px solid rgba(231, 33, 119, 0.2)'
                                    }}>
                                        {('icon_url' in reason && reason.icon_url) ? (
                                            <img
                                                src={reason.icon_url}
                                                alt={reason.title || ''}
                                                className="w-10 h-10 object-contain"
                                            />
                                        ) : (
                                            <CheckCircle2 className="w-10 h-10 text-primary" style={{ color: '#e72177' }} />
                                        )}
                                    </div>
                                </div>
                                <div className={`flex-1 ${isRTL ? 'rtl' : 'ltr'}`}>
                                    <h3
                                        className="text-xl md:text-2xl font-semibold mb-3"
                                        style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            color: '#862b90',
                                            letterSpacing: '0.05em'
                                        }}
                                    >
                                        {reason.title}
                                    </h3>
                                    {reason.description && (
                                        <p
                                            className="text-base md:text-lg leading-relaxed"
                                            style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 300,
                                                color: '#545759',
                                                lineHeight: '1.8'
                                            }}
                                        >
                                            {reason.description}
                                        </p>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}
