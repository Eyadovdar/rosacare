interface HeritageSectionProps {
    locale?: string;
}

export function HeritageSection({ locale = 'en' }: HeritageSectionProps) {
    const isRTL = locale === 'ar';

    return (
        <section className="py-20 bg-gradient-to-br from-secondary/50 to-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-8 text-center">
                        {locale === 'ar' ? 'التراث والحرفية' : 'Heritage & Craftsmanship'}
                    </h2>
                    <div className="prose prose-lg max-w-none">
                        <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                            {locale === 'ar'
                                ? 'تمتد جذورنا إلى قرون من الحرفية السورية التقليدية في استخراج الوردة الشامية. نحن نستخدم الطرق التقليدية الأصيلة التي تم تناقلها عبر الأجيال، مما يضمن الحفاظ على الجودة والنقاء والخصائص الطبيعية الفريدة لهذه الزهرة المميزة.'
                                : 'Our roots extend to centuries of traditional Syrian craftsmanship in Damask Rose extraction. We use authentic traditional methods passed down through generations, ensuring the preservation of quality, purity, and the unique natural properties of this distinguished flower.'}
                        </p>
                        <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                            {locale === 'ar'
                                ? 'كل قطرة من منتجاتنا تحمل عبق التاريخ والتراث السوري الأصيل. نعتز بهذا الإرث ونسعى للحفاظ عليه وتقديمه للعالم بأعلى معايير الجودة.'
                                : 'Every drop of our products carries the essence of authentic Syrian history and heritage. We cherish this legacy and strive to preserve it and present it to the world with the highest quality standards.'}
                        </p>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                            <div className="p-6 bg-background rounded-lg border border-border">
                                <h3 className="text-xl font-semibold mb-3">
                                    {locale === 'ar' ? 'الاستخراج التقليدي' : 'Traditional Extraction'}
                                </h3>
                                <p className="text-muted-foreground">
                                    {locale === 'ar'
                                        ? 'طرق استخراج تقليدية محافظة على جميع الخصائص الطبيعية'
                                        : 'Traditional extraction methods preserving all natural properties'}
                                </p>
                            </div>
                            <div className="p-6 bg-background rounded-lg border border-border">
                                <h3 className="text-xl font-semibold mb-3">
                                    {locale === 'ar' ? 'جودة ممتازة' : 'Excellence in Quality'}
                                </h3>
                                <p className="text-muted-foreground">
                                    {locale === 'ar'
                                        ? 'التزام بأعلى معايير الجودة والنقاء في كل منتج'
                                        : 'Commitment to the highest standards of quality and purity in every product'}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
