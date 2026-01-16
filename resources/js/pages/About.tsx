import { Head, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { useState, useEffect } from 'react';

interface AboutData {
    id?: number;
    story?: {
        title?: string;
        paragraphs?: string[];
        content?: string;
        image_url?: string;
        icon_url?: string;
    };
    vision?: {
        title?: string;
        content?: string;
        image_url?: string;
        icon_url?: string;
    };
    mission?: {
        title?: string;
        content?: string;
        image_url?: string;
        icon_url?: string;
    };
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
    meta?: {
        title?: string;
        description?: string;
        keywords?: string;
    };
}

interface AboutProps {
    locale?: string;
    about?: AboutData | null;
}

export default function About({ locale = 'ar', about = null }: AboutProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        setIsVisible(true);
    }, []);

    // Default static content (fallback)
    const defaultStory = {
        title: locale === 'ar' ? 'قصتنا' : 'Our Story',
        paragraphs: locale === 'ar' 
            ? [
                'روزاكير هي أكثر من مجرد علامة تجارية - إنها رحلة نحو الطبيعة والأصالة. تأسست من حب عميق للوردة الشامية وتقدير للتراث السوري الأصيل، نسعى لنقل جمال ونقاء هذه الزهرة المميزة إلى العالم.',
                'بدأت رحلتنا من قلب سوريا، حيث تُزرع أجود أنواع الوردة الشامية في العالم. نحن نعمل مباشرة مع المزارعين المحليين الذين يحافظون على التقاليد القديمة في زراعة وجني الورد، مما يضمن أن كل منتج يحمل جوهر الأصالة والجودة.'
            ]
            : [
                'RosaCare is more than just a brand - it\'s a journey towards nature and authenticity. Founded from a deep love for the Damask Rose and appreciation for authentic Syrian heritage, we strive to bring the beauty and purity of this distinguished flower to the world.',
                'Our journey began from the heart of Syria, where the finest Damask Roses in the world are grown. We work directly with local farmers who preserve ancient traditions in growing and harvesting roses, ensuring that every product carries the essence of authenticity and quality.'
            ]
    };

    const defaultVision = {
        title: locale === 'ar' ? 'رؤيتنا' : 'Our Vision',
        content: locale === 'ar'
            ? 'أن نكون الرائدين العالميين في تقديم منتجات الوردة الشامية الطبيعية والأصيلة، مع الحفاظ على التراث السوري وتمكين المجتمعات المحلية.'
            : 'To be the global leaders in providing natural and authentic Damask Rose products, while preserving Syrian heritage and empowering local communities.'
    };

    const defaultMission = {
        title: locale === 'ar' ? 'مهمتنا' : 'Our Mission',
        content: locale === 'ar'
            ? 'تقديم منتجات طبيعية 100% من أعلى جودة، مستخرجة بطرق تقليدية أصيلة، مع الالتزام بالاستدامة والمسؤولية البيئية والاجتماعية.'
            : 'To deliver 100% natural products of the highest quality, extracted using authentic traditional methods, while committing to sustainability and environmental and social responsibility.'
    };

    const defaultHeritage = {
        title: locale === 'ar' ? 'التراث والحرفية' : 'Heritage & Craftsmanship',
        content: locale === 'ar'
            ? 'تمتد جذورنا إلى قرون من الحرفية السورية التقليدية في استخراج الوردة الشامية. نحن نستخدم الطرق التقليدية الأصيلة التي تم تناقلها عبر الأجيال، مما يضمن الحفاظ على الجودة والنقاء والخصائص الطبيعية الفريدة لهذه الزهرة المميزة.'
            : 'Our roots extend to centuries of traditional Syrian craftsmanship in Damask Rose extraction. We use authentic traditional methods passed down through generations, ensuring the preservation of quality, purity, and the unique natural properties of this distinguished flower.',
        subcontent: locale === 'ar'
            ? 'كل قطرة من منتجاتنا تحمل عبق التاريخ والتراث السوري الأصيل. نعتز بهذا الإرث ونسعى للحفاظ عليه وتقديمه للعالم بأعلى معايير الجودة.'
            : 'Every drop of our products carries the essence of authentic Syrian history and heritage. We cherish this legacy and strive to preserve it and present it to the world with the highest quality standards.',
        features: locale === 'ar'
            ? [
                { title: 'الاستخراج التقليدي', description: 'طرق استخراج تقليدية محافظة على جميع الخصائص الطبيعية' },
                { title: 'جودة ممتازة', description: 'التزام بأعلى معايير الجودة والنقاء في كل منتج' }
            ]
            : [
                { title: 'Traditional Extraction', description: 'Traditional extraction methods preserving all natural properties' },
                { title: 'Excellence in Quality', description: 'Commitment to the highest standards of quality and purity in every product' }
            ]
    };

    const defaultBenefits = {
        title: locale === 'ar' ? 'فوائد الوردة الشامية' : 'Benefits of Damask Rose',
        items: locale === 'ar'
            ? [
                { title: 'فوائد للبشرة', description: 'ترطيب عميق وتنعيم البشرة وتقليل التجاعيد والخطوط الدقيقة' },
                { title: 'العافية والاسترخاء', description: 'خصائص مهدئة طبيعية تساعد على الاسترخاء وتخفيف التوتر' },
                { title: 'القيمة الغذائية', description: 'غنية بالفيتامينات ومضادات الأكسدة الطبيعية المفيدة للصحة' },
                { title: '100% طبيعي', description: 'منتجات طبيعية خالصة بدون إضافات كيميائية أو مواد حافظة' }
            ]
            : [
                { title: 'Skin Benefits', description: 'Deep hydration, skin smoothing, and reduction of wrinkles and fine lines' },
                { title: 'Wellness & Relaxation', description: 'Natural soothing properties that help with relaxation and stress relief' },
                { title: 'Nutritional Value', description: 'Rich in vitamins and natural antioxidants beneficial for health' },
                { title: '100% Natural', description: 'Pure natural products without chemical additives or preservatives' }
            ]
    };

    const defaultWhyRosaCare = {
        title: locale === 'ar' ? 'لماذا روزاكير؟' : 'Why RosaCare?',
        reasons: locale === 'ar'
            ? [
                { title: 'مكونات طبيعية', description: '100% منتجات طبيعية مستخرجة من أجود أنواع الوردة الشامية' },
                { title: 'بدون مواد كيميائية', description: 'خالية تماماً من المواد الكيميائية والمواد الحافظة الصناعية' },
                { title: 'تراث موثوق', description: 'طرق تقليدية سورية أصيلة تم تناقلها عبر الأجيال' },
                { title: 'ممارسات مستدامة', description: 'التزام بالاستدامة والمسؤولية البيئية في جميع عملياتنا' }
            ]
            : [
                { title: 'Natural Ingredients', description: '100% natural products extracted from the finest Damask Roses' },
                { title: 'No Chemicals', description: 'Completely free from chemicals and synthetic preservatives' },
                { title: 'Trusted Heritage', description: 'Authentic traditional Syrian methods passed down through generations' },
                { title: 'Sustainable Practices', description: 'Commitment to sustainability and environmental responsibility in all our operations' }
            ]
    };

    // Use database data or fallback to defaults
    const story = about?.story || defaultStory;
    const vision = about?.vision || defaultVision;
    const mission = about?.mission || defaultMission;
    const heritage = about?.heritage || defaultHeritage;
    const benefits = about?.benefits || defaultBenefits;
    const whyRosaCare = about?.whyRosaCare || defaultWhyRosaCare;

    const storyParagraphs = story.paragraphs && story.paragraphs.length > 0 
        ? story.paragraphs 
        : (story.content ? [story.content] : defaultStory.paragraphs);

    return (
        <>
            <Head 
                title={about?.meta?.title || (locale === 'ar' ? 'من نحن - روزاكير' : 'About Us - RosaCare')}
            >
                {about?.meta?.description && (
                    <meta name="description" content={about.meta.description} />
                )}
                {about?.meta?.keywords && (
                    <meta name="keywords" content={about.meta.keywords} />
                )}
            </Head>
            <style>{`
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
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
                @keyframes float {
                    0%, 100% {
                        transform: translate(0, 0) rotate(0deg);
                    }
                    33% {
                        transform: translate(30px, -30px) rotate(120deg);
                    }
                    66% {
                        transform: translate(-30px, 30px) rotate(240deg);
                    }
                }
                @keyframes petalFloat {
                    0%, 100% {
                        transform: translateY(0) rotate(0deg);
                        opacity: 0.6;
                    }
                    50% {
                        transform: translateY(-20px) rotate(180deg);
                        opacity: 1;
                    }
                }
                @keyframes shimmer {
                    0% { background-position: -1000px 0; }
                    100% { background-position: 1000px 0; }
                }
                .rose-petals {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                    z-index: 1;
                    overflow: hidden;
                }
                .rose-petals::before,
                .rose-petals::after {
                    content: '';
                    position: absolute;
                    width: 250px;
                    height: 250px;
                    border-radius: 50% 0 50% 0;
                    background: linear-gradient(135deg, rgba(231, 33, 119, 0.08), rgba(134, 44, 145, 0.08));
                    animation: float 20s infinite ease-in-out;
                }
                .rose-petals::before {
                    top: 20%;
                    left: 5%;
                    animation-delay: 0s;
                }
                .rose-petals::after {
                    top: 50%;
                    right: 5%;
                    animation-delay: 10s;
                }
                .about-content {
                    position: relative;
                    z-index: 2;
                }
                .fade-in-up {
                    animation: fadeInUp 1s ease-out both;
                }
                .fade-in {
                    animation: fadeIn 1s ease-out both;
                }
                .section-card {
                    background: rgba(255, 255, 255, 0.8);
                    border-radius: 20px;
                    box-shadow: 0 10px 40px rgba(231, 33, 119, 0.1);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                .section-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 15px 50px rgba(231, 33, 119, 0.15);
                }
                .icon-wrapper {
                    animation: petalFloat 3s ease-in-out infinite;
                }
                .divider {
                    width: 100px;
                    height: 2px;
                    background: linear-gradient(90deg, transparent, #e72177, transparent);
                    margin: 2rem auto;
                }
            `}</style>
            <div className={`min-h-screen relative ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                {/* Animated Rose Petals Background */}
                <div className="rose-petals" />

                <Navbar menuItems={menuItems} locale={locale} />
                <section className="py-20 relative" style={{
                    background: 'linear-gradient(135deg, #f5f5f5 0%, #ffffff 50%, #fafafa 100%)',
                    minHeight: 'calc(100vh - 4rem)'
                }}>
                    <div className="container mx-auto px-4 max-w-7xl about-content">
                        {/* Story Section */}
                        <div className={`mb-16 fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '0.3s' }}>
                            <div className="max-w-4xl mx-auto section-card" style={{ padding: '3rem 2rem' }}>
                                {story.icon_url && (
                                    <div className="flex justify-center mb-6 icon-wrapper">
                                        <img 
                                            src={story.icon_url} 
                                            alt="Story Icon" 
                                            className="w-20 h-20 object-contain"
                                        />
                                    </div>
                                )}
                                <h1 className={`text-4xl md:text-5xl font-light mb-8 text-center ${isRTL ? 'rtl' : 'ltr'}`} style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    color: '#545759',
                                    letterSpacing: '0.1em'
                                }}>
                                    {story.title || defaultStory.title}
                            </h1>
                                {story.image_url && (
                                    <div className="mb-8 rounded-lg overflow-hidden">
                                        <img 
                                            src={story.image_url} 
                                            alt={story.title} 
                                            className="w-full h-auto object-cover"
                                            style={{ maxHeight: '500px' }}
                                        />
                                    </div>
                                )}
                                <div className="prose prose-lg max-w-none">
                                    {storyParagraphs.map((paragraph, index) => (
                                        <p 
                                            key={index}
                                            className="text-lg leading-relaxed mb-6 fade-in-up" 
                                            style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 300,
                                                color: '#545759',
                                                animationDelay: `${0.5 + index * 0.2}s`
                                            }}
                                        >
                                            {paragraph}
                                        </p>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* Vision & Mission Grid */}
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                            {/* Vision */}
                            <div className={`fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '0.7s' }}>
                                <div className="section-card h-full" style={{ padding: '2.5rem 2rem' }}>
                                    {vision.icon_url && (
                                        <div className="flex justify-center mb-4 icon-wrapper">
                                            <img 
                                                src={vision.icon_url} 
                                                alt="Vision Icon" 
                                                className="w-16 h-16 object-contain"
                                            />
                                        </div>
                                    )}
                                    <h2 className="text-3xl font-normal mb-4 text-center" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        color: '#862b90',
                                        letterSpacing: '0.05em'
                                    }}>
                                        {vision.title}
                                    </h2>
                                    <div className="divider" />
                                    {vision.image_url && (
                                        <div className="mb-4 rounded-lg overflow-hidden">
                                            <img 
                                                src={vision.image_url} 
                                                alt={vision.title} 
                                                className="w-full h-auto object-cover"
                                                style={{ maxHeight: '300px' }}
                                            />
                                        </div>
                                    )}
                                    <p className="text-base leading-relaxed" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        fontWeight: 300,
                                        color: '#545759'
                                    }}>
                                        {vision.content}
                                    </p>
                                </div>
                            </div>

                            {/* Mission */}
                            <div className={`fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '0.9s' }}>
                                <div className="section-card h-full" style={{ padding: '2.5rem 2rem' }}>
                                    {mission.icon_url && (
                                        <div className="flex justify-center mb-4 icon-wrapper">
                                            <img 
                                                src={mission.icon_url} 
                                                alt="Mission Icon" 
                                                className="w-16 h-16 object-contain"
                                            />
                                        </div>
                                    )}
                                    <h2 className="text-3xl font-normal mb-4 text-center" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        color: '#862b90',
                                        letterSpacing: '0.05em'
                                    }}>
                                        {mission.title}
                                    </h2>
                                    <div className="divider" />
                                    {mission.image_url && (
                                        <div className="mb-4 rounded-lg overflow-hidden">
                                            <img 
                                                src={mission.image_url} 
                                                alt={mission.title} 
                                                className="w-full h-auto object-cover"
                                                style={{ maxHeight: '300px' }}
                                            />
                                        </div>
                                    )}
                                    <p className="text-base leading-relaxed" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        fontWeight: 300,
                                        color: '#545759'
                                    }}>
                                        {mission.content}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Benefits Section */}
                        <div className={`mb-16 fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '1.1s' }}>
                            <div className="section-card" style={{ padding: '3rem 2rem' }}>
                                <h2 className="text-3xl md:text-4xl font-normal mb-8 text-center" style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    color: '#545759',
                                    letterSpacing: '0.05em'
                                }}>
                                    {benefits.title}
                                </h2>
                                {benefits.image_url && (
                                    <div className="mb-8 rounded-lg overflow-hidden">
                                        <img 
                                            src={benefits.image_url} 
                                            alt={benefits.title} 
                                            className="w-full h-auto object-cover"
                                            style={{ maxHeight: '400px' }}
                                        />
                                    </div>
                                )}
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    {benefits.items?.map((item, index) => (
                                        <div
                                            key={index}
                                            className="text-center p-6 rounded-lg transition-all hover:bg-[#f5f5f5]"
                                            style={{
                                                background: 'rgba(231, 33, 119, 0.05)',
                                                animation: `fadeInUp 0.6s ease-out ${1.3 + index * 0.1}s both`
                                            }}
                                        >
                                            {item.icon_url ? (
                                                <div className="flex justify-center mb-4 icon-wrapper">
                                                    <img 
                                                        src={item.icon_url} 
                                                        alt={item.title} 
                                                        className="w-12 h-12 object-contain"
                                                    />
                                                </div>
                                            ) : (
                                                <div className="flex justify-center mb-4 text-[#e72177]">
                                                    <svg className="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </div>
                                            )}
                                            <h3 className="text-lg font-medium mb-2" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                color: '#545759'
                                            }}>
                                                {item.title}
                                            </h3>
                                            <p className="text-sm" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 300,
                                                color: '#545759',
                                                opacity: 0.8
                                            }}>
                                                {item.description}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* Heritage Section */}
                        <div className={`mb-16 fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '1.5s' }}>
                            <div className="section-card" style={{ padding: '3rem 2rem' }}>
                                <h2 className="text-3xl md:text-4xl font-normal mb-6 text-center" style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    color: '#545759',
                                    letterSpacing: '0.05em'
                                }}>
                                    {heritage.title}
                                </h2>
                                {heritage.image_url && (
                                    <div className="mb-6 rounded-lg overflow-hidden">
                                        <img 
                                            src={heritage.image_url} 
                                            alt={heritage.title} 
                                            className="w-full h-auto object-cover"
                                            style={{ maxHeight: '400px' }}
                                        />
                                    </div>
                                )}
                                <div className="prose prose-lg max-w-none mb-8">
                                    <p className="text-base leading-relaxed mb-4" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        fontWeight: 300,
                                        color: '#545759'
                                    }}>
                                        {heritage.content}
                                    </p>
                                    {heritage.subcontent && (
                                        <p className="text-base leading-relaxed" style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            fontWeight: 300,
                                            color: '#545759',
                                            opacity: 0.9
                                        }}>
                                            {heritage.subcontent}
                                        </p>
                                    )}
                                </div>
                                {heritage.features && heritage.features.length > 0 && (
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                                        {heritage.features.map((feature, index) => (
                                            <div 
                                                key={index}
                                                className="p-6 rounded-lg border-2 transition-all hover:border-[#e72177]"
                                                style={{
                                                    borderColor: '#bdc4c8',
                                                    background: '#ffffff'
                                                }}
                                            >
                                                {feature.icon_url && (
                                                    <div className="flex justify-center mb-3 icon-wrapper">
                                                        <img 
                                                            src={feature.icon_url} 
                                                            alt={feature.title} 
                                                            className="w-10 h-10 object-contain"
                                                        />
                                                    </div>
                                                )}
                                                <h3 className="text-xl font-medium mb-2 text-center" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    color: '#545759'
                                                }}>
                                                    {feature.title}
                                                </h3>
                                                <p className="text-sm text-center" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    color: '#545759',
                                                    opacity: 0.8
                                                }}>
                                                    {feature.description}
                                                </p>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Why RosaCare Section */}
                        <div className={`mb-16 fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`} style={{ animationDelay: '1.7s' }}>
                            <div className="section-card" style={{ padding: '3rem 2rem' }}>
                                <h2 className="text-3xl md:text-4xl font-normal mb-8 text-center" style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    color: '#545759',
                                    letterSpacing: '0.05em'
                                }}>
                                    {whyRosaCare.title}
                                </h2>
                                {whyRosaCare.image_url && (
                                    <div className="mb-8 rounded-lg overflow-hidden">
                                        <img 
                                            src={whyRosaCare.image_url} 
                                            alt={whyRosaCare.title} 
                                            className="w-full h-auto object-cover"
                                            style={{ maxHeight: '400px' }}
                                        />
                                    </div>
                                )}
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                                    {whyRosaCare.reasons?.map((reason, index) => (
                                        <div 
                                            key={index}
                                            className="flex gap-4 p-6 rounded-lg transition-all hover:bg-[#f5f5f5]"
                                            style={{
                                                background: 'rgba(231, 33, 119, 0.05)',
                                                animation: `fadeInUp 0.6s ease-out ${1.9 + index * 0.1}s both`
                                            }}
                                        >
                                            <div className="flex-shrink-0">
                                                {reason.icon_url ? (
                                                    <img 
                                                        src={reason.icon_url} 
                                                        alt={reason.title} 
                                                        className="w-8 h-8 object-contain"
                                                    />
                                                ) : (
                                                    <div className="w-8 h-8 rounded-full flex items-center justify-center" style={{
                                                        background: 'rgba(231, 33, 119, 0.1)'
                                                    }}>
                                                        <svg className="w-5 h-5 text-[#e72177]" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                        </svg>
                                                    </div>
                                                )}
                                            </div>
                                            <div className={isRTL ? 'rtl' : 'ltr'}>
                                                <h3 className="text-lg font-medium mb-2" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    color: '#545759'
                                                }}>
                                                    {reason.title}
                                                </h3>
                                                <p className="text-sm" style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    color: '#545759',
                                                    opacity: 0.8
                                                }}>
                                                    {reason.description}
                                                </p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <Footer locale={locale} />
            </div>
        </>
    );
}
