interface AboutSectionProps {
    locale?: string;
}

export function AboutSection({ locale = 'en' }: AboutSectionProps) {
    const isRTL = locale === 'ar';

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-8 text-center text-foreground">
                        {locale === 'ar' ? 'عن روزاكير' : 'About RosaCare'}
                    </h2>
                    <div className="prose prose-lg max-w-none">
                        <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                            {locale === 'ar'
                                ? 'روزاكير هي علامة تجارية فاخرة متخصصة في منتجات الوردة الشامية (الوردة الدمشقية)، المستخرجة من أجود أنواع الورد في العالم من قلب سوريا. نحن نؤمن بالجودة والأصالة والطبيعية في كل منتج نقدمه.'
                                : 'RosaCare is a premium brand specialized in Damask Rose products, extracted from the finest roses in the world from the heart of Syria. We believe in quality, authenticity, and naturalness in every product we offer.'}
                        </p>
                        <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                            {locale === 'ar'
                                ? 'نستخدم طرق الاستخراج التقليدية السورية الأصيلة التي تم تناقلها عبر الأجيال، مما يضمن الحفاظ على الخصائص الطبيعية والفوائد الصحية الفريدة للوردة الشامية.'
                                : 'We use traditional authentic Syrian extraction methods passed down through generations, ensuring the preservation of the natural properties and unique health benefits of the Damask Rose.'}
                        </p>
                        <p className="text-lg text-muted-foreground leading-relaxed">
                            {locale === 'ar'
                                ? 'جميع منتجاتنا طبيعية 100%، خالية من المواد الكيميائية والمواد الحافظة، ومستخرجة بعناية فائقة لضمان أعلى مستويات الجودة والنقاء.'
                                : 'All our products are 100% natural, free from chemicals and preservatives, carefully extracted to ensure the highest levels of quality and purity.'}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    );
}
