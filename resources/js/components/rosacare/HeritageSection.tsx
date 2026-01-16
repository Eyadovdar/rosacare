interface AboutData {
    heritage?: {
        title?: string;
        content?: string;
        subcontent?: string;
        image_url?: string;
        features?: Array<{
            icon_path?: string;
            icon_url?: string;
            title?: string;
            description?: string;
        }>;
    };
}

interface HeritageSectionProps {
    locale?: string;
    about?: AboutData | null;
}

export function HeritageSection({ locale = 'ar', about = null }: HeritageSectionProps) {
    const isRTL = locale === 'ar';

    // Default content if no about data
    const defaultTitle = locale === 'ar' ? 'التراث والحرفية' : 'Heritage & Craftsmanship';
    const defaultContent = [
        locale === 'ar'
            ? 'تمتد جذورنا إلى قرون من الحرفية السورية التقليدية في استخراج الوردة الشامية. نحن نستخدم الطرق التقليدية الأصيلة التي تم تناقلها عبر الأجيال، مما يضمن الحفاظ على الجودة والنقاء والخصائص الطبيعية الفريدة لهذه الزهرة المميزة.'
            : 'Our roots extend to centuries of traditional Syrian craftsmanship in Damask Rose extraction. We use authentic traditional methods passed down through generations, ensuring the preservation of quality, purity, and the unique natural properties of this distinguished flower.',
        locale === 'ar'
            ? 'كل قطرة من منتجاتنا تحمل عبق التاريخ والتراث السوري الأصيل. نعتز بهذا الإرث ونسعى للحفاظ عليه وتقديمه للعالم بأعلى معايير الجودة.'
            : 'Every drop of our products carries the essence of authentic Syrian history and heritage. We cherish this legacy and strive to preserve it and present it to the world with the highest quality standards.',
    ];
    const defaultFeatures = [
        {
            title: locale === 'ar' ? 'الاستخراج التقليدي' : 'Traditional Extraction',
            description: locale === 'ar'
                ? 'طرق استخراج تقليدية محافظة على جميع الخصائص الطبيعية'
                : 'Traditional extraction methods preserving all natural properties',
        },
        {
            title: locale === 'ar' ? 'جودة ممتازة' : 'Excellence in Quality',
            description: locale === 'ar'
                ? 'التزام بأعلى معايير الجودة والنقاء في كل منتج'
                : 'Commitment to the highest standards of quality and purity in every product',
        },
    ];

    // Use about data if available, otherwise use default
    const title = about?.heritage?.title || defaultTitle;
    const content = about?.heritage?.content || defaultContent[0];
    const subcontent = about?.heritage?.subcontent || defaultContent[1];
    const features = about?.heritage?.features && about.heritage.features.length > 0
        ? about.heritage.features
        : defaultFeatures;

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
                @keyframes waterfall {
                    0% {
                        transform: translateY(-100px) translateX(0) rotate(0deg);
                        opacity: 0;
                    }
                    10% {
                        opacity: 0.8;
                    }
                    50% {
                        transform: translateY(50vh) translateX(30px) rotate(180deg);
                        opacity: 1;
                    }
                    90% {
                        opacity: 0.8;
                    }
                    100% {
                        transform: translateY(100vh) translateX(-20px) rotate(360deg);
                        opacity: 0;
                    }
                }
                @keyframes gentleFloat {
                    0%, 100% {
                        transform: translateY(0);
                    }
                    50% {
                        transform: translateY(-10px);
                    }
                }
                @keyframes bloom {
                    0% {
                        transform: scale(0.8);
                        opacity: 0;
                    }
                    100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }
                .heritage-fade-in {
                    animation: fadeInUp 0.8s ease-out both;
                }
                .heritage-petal {
                    position: absolute;
                    width: 35px;
                    height: 35px;
                    background: linear-gradient(135deg, rgba(231, 33, 119, 0.2), rgba(134, 44, 145, 0.2));
                    border-radius: 50% 0 50% 0;
                    pointer-events: none;
                    animation: waterfall 15s infinite linear;
                    filter: blur(0.5px);
                }
                .heritage-petal-small {
                    width: 25px;
                    height: 25px;
                    opacity: 0.6;
                }
                .heritage-petal-medium {
                    width: 35px;
                    height: 35px;
                    opacity: 0.7;
                }
                .heritage-petal-large {
                    width: 45px;
                    height: 45px;
                    opacity: 0.8;
                }
                .heritage-feature-card {
                    animation: fadeInUp 0.8s ease-out both;
                    transition: all 0.3s ease;
                }
                .heritage-feature-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 30px rgba(231, 33, 119, 0.15);
                }
                .heritage-icon {
                    animation: bloom 0.6s ease-out both, gentleFloat 3s ease-in-out infinite;
                }
            `}</style>

            {/* Waterfall Rose Petals Background - Randomly distributed across entire section */}
            <div className="absolute inset-0 overflow-hidden pointer-events-none" style={{ zIndex: 0 }}>
                {/* Generate random petals across the entire width */}
                {Array.from({ length: 30 }).map((_, index) => {
                    // Random horizontal position (5% to 95% of width)
                    const randomLeft = 5 + Math.random() * 90;
                    // Random delay (0s to 12s)
                    const randomDelay = Math.random() * 12;
                    // Random duration (12s to 18s)
                    const randomDuration = 12 + Math.random() * 6;
                    // Random size class
                    const sizeClasses = ['heritage-petal-small', 'heritage-petal-medium', 'heritage-petal-large'];
                    const randomSize = sizeClasses[Math.floor(Math.random() * sizeClasses.length)];

                    return (
                        <div
                            key={index}
                            className={`heritage-petal ${randomSize}`}
                            style={{
                                left: `${randomLeft}%`,
                                animationDelay: `${randomDelay}s`,
                                animationDuration: `${randomDuration}s`,
                            }}
                        />
                    );
                })}
            </div>

            <div className="container mx-auto px-4 relative" style={{ zIndex: 10 }}>
                <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`} style={{ position: 'relative', zIndex: 1 }}>
                    <h2
                        className="text-4xl md:text-5xl font-bold mb-8 text-center heritage-fade-in"
                        style={{
                            fontFamily: "'Alexandria', sans-serif",
                            animationDelay: '0.2s'
                        }}
                    >
                        {title}
                    </h2>
                    <div className="prose prose-lg max-w-none">
                        {content && (
                            <p
                                className="text-lg text-muted-foreground leading-relaxed mb-6 heritage-fade-in"
                                style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    animationDelay: '0.4s'
                                }}
                            >
                                {content}
                            </p>
                        )}
                        {subcontent && (
                            <p
                                className="text-lg text-muted-foreground leading-relaxed mb-6 heritage-fade-in"
                                style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    animationDelay: '0.6s'
                                }}
                            >
                                {subcontent}
                            </p>
                        )}
                        {features.length > 0 && (
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                                {features.map((feature, index) => (
                                    <div
                                        key={index}
                                        className="p-6 bg-background rounded-lg border border-border heritage-feature-card"
                                        style={{
                                            animationDelay: `${0.8 + index * 0.2}s`
                                        }}
                                    >
                                        {'icon_url' in feature && feature.icon_url && (
                                            <div className="mb-4 heritage-icon" style={{ animationDelay: `${1 + index * 0.2}s` }}>
                                                <img
                                                    src={feature.icon_url}
                                                    alt={feature.title || ''}
                                                    className="w-12 h-12 object-contain"
                                                />
                                            </div>
                                        )}
                                        <h3
                                            className="text-xl font-semibold mb-3"
                                            style={{ fontFamily: "'Alexandria', sans-serif" }}
                                        >
                                            {feature.title}
                                        </h3>
                                        {feature.description && (
                                            <p
                                                className="text-muted-foreground"
                                                style={{ fontFamily: "'Alexandria', sans-serif" }}
                                            >
                                                {feature.description}
                                            </p>
                                        )}
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}
