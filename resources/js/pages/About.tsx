import { Head, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { HeritageSection } from '@/components/rosacare/HeritageSection';
import { WhyRosaCareSection } from '@/components/rosacare/WhyRosaCareSection';
import { BenefitsSection } from '@/components/rosacare/BenefitsSection';
import { Navbar } from '@/components/rosacare/Navbar';

interface AboutProps {
    locale?: string;
}

export default function About({ locale = 'ar' }: AboutProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];

    return (
        <>
            <Head title={locale === 'ar' ? 'من نحن - روزاكير' : 'About Us - RosaCare'} />
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />
                <section className="py-20 bg-secondary/30">
                    <div className="container mx-auto px-4">
                        <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                            <h1 className="text-5xl md:text-6xl font-bold mb-8 text-center">
                                {locale === 'ar' ? 'قصتنا' : 'Our Story'}
                            </h1>
                            <div className="prose prose-lg max-w-none mb-12">
                                <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                                    {locale === 'ar'
                                        ? 'روزاكير هي أكثر من مجرد علامة تجارية - إنها رحلة نحو الطبيعة والأصالة. تأسست من حب عميق للوردة الشامية وتقدير للتراث السوري الأصيل، نسعى لنقل جمال ونقاء هذه الزهرة المميزة إلى العالم.'
                                        : 'RosaCare is more than just a brand - it\'s a journey towards nature and authenticity. Founded from a deep love for the Damask Rose and appreciation for authentic Syrian heritage, we strive to bring the beauty and purity of this distinguished flower to the world.'}
                                </p>
                                <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                                    {locale === 'ar'
                                        ? 'بدأت رحلتنا من قلب سوريا، حيث تُزرع أجود أنواع الوردة الشامية في العالم. نحن نعمل مباشرة مع المزارعين المحليين الذين يحافظون على التقاليد القديمة في زراعة وجني الورد، مما يضمن أن كل منتج يحمل جوهر الأصالة والجودة.'
                                        : 'Our journey began from the heart of Syria, where the finest Damask Roses in the world are grown. We work directly with local farmers who preserve ancient traditions in growing and harvesting roses, ensuring that every product carries the essence of authenticity and quality.'}
                                </p>
                                <h2 className="text-3xl font-bold mt-12 mb-6">
                                    {locale === 'ar' ? 'رؤيتنا' : 'Our Vision'}
                                </h2>
                                <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                                    {locale === 'ar'
                                        ? 'أن نكون الرائدين العالميين في تقديم منتجات الوردة الشامية الطبيعية والأصيلة، مع الحفاظ على التراث السوري وتمكين المجتمعات المحلية.'
                                        : 'To be the global leaders in providing natural and authentic Damask Rose products, while preserving Syrian heritage and empowering local communities.'}
                                </p>
                                <h2 className="text-3xl font-bold mt-12 mb-6">
                                    {locale === 'ar' ? 'مهمتنا' : 'Our Mission'}
                                </h2>
                                <p className="text-lg text-muted-foreground leading-relaxed">
                                    {locale === 'ar'
                                        ? 'تقديم منتجات طبيعية 100% من أعلى جودة، مستخرجة بطرق تقليدية أصيلة، مع الالتزام بالاستدامة والمسؤولية البيئية والاجتماعية.'
                                        : 'To deliver 100% natural products of the highest quality, extracted using authentic traditional methods, while committing to sustainability and environmental and social responsibility.'}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                <BenefitsSection locale={locale} />
                <HeritageSection locale={locale} />
                <WhyRosaCareSection locale={locale} />
                <Footer locale={locale} />
            </div>
        </>
    );
}
