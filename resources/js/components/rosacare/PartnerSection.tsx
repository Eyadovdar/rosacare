interface Partner {
    id: number;
    title: string;
    title_ar?: string;
    title_en?: string;
    image?: string;
    image_url?: string;
    url?: string;
}

interface PartnerSectionProps {
    locale?: string;
    partners?: Partner[];
}

export function PartnerSection({ locale = 'ar', partners = [] }: PartnerSectionProps) {
    const isRTL = locale === 'ar';

    if (!partners || partners.length === 0) {
        return null;
    }

    return (
        <section
            id="partners"
            className="py-20 relative"
            style={{
                background: 'linear-gradient(135deg, #ffffff 0%, #faf5f8 50%, #ffffff 100%)'
            }}
        >
            <div className="container mx-auto px-4 relative" style={{ zIndex: 2 }}>
                <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center ${isRTL ? 'rtl' : 'ltr'}`} style={{ fontFamily: "'Alexandria', sans-serif" }}>
                    {locale === 'ar' ? 'شركاؤنا' : 'Our Partners'}
                </h2>
                <div className="flex flex-wrap justify-center items-center gap-6">
                    {partners.map((partner) => (
                        <div
                            key={partner.id}
                            className="fade-in-up group relative bg-white rounded-lg p-4 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col items-center justify-center overflow-hidden"
                            style={{
                                minHeight: '120px',
                                width: 'calc(50% - 12px)',
                                maxWidth: '180px',
                                flex: '0 0 auto',
                                animationDelay: `${partner.id * 0.1}s`,
                            }}
                            onMouseEnter={(e) => {
                                e.currentTarget.style.transform = 'translateY(-5px)';
                                e.currentTarget.style.boxShadow = '0 10px 30px rgba(231, 33, 119, 0.15)';
                            }}
                            onMouseLeave={(e) => {
                                e.currentTarget.style.transform = 'translateY(0)';
                                e.currentTarget.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                            }}
                        >
                            <div className="flex-1 flex items-center justify-center w-full">
                                {partner.url ? (
                                    <a
                                        href={partner.url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-full h-full flex items-center justify-center"
                                    >
                                        {partner.image_url || partner.image ? (
                                            <img
                                                src={partner.image_url || `/storage/${partner.image}`}
                                                alt={partner.title}
                                                className="max-w-full max-h-20 object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300"
                                            />
                                        ) : (
                                            <span className="text-muted-foreground text-sm text-center">{partner.title}</span>
                                        )}
                                    </a>
                                ) : (
                                    <>
                                        {partner.image_url || partner.image ? (
                                            <img
                                                src={partner.image_url || `/storage/${partner.image}`}
                                                alt={partner.title}
                                                className="max-w-full max-h-20 object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300"
                                            />
                                        ) : (
                                            <span className="text-muted-foreground text-sm text-center">{partner.title}</span>
                                        )}
                                    </>
                                )}
                            </div>
                            {/* Partner name that slides up on hover */}
                            <div
                                className="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"
                                style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.95) 0%, rgba(134, 44, 145, 0.95) 100%)',
                                    borderBottomLeftRadius: '0.5rem',
                                    borderBottomRightRadius: '0.5rem',
                                }}
                            >
                                <div className="px-3 py-2">
                                    <p className="text-xs font-medium text-white text-center truncate">
                                        {partner.title}
                                    </p>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

