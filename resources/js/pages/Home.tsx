import { Head, usePage } from '@inertiajs/react';
import { HeroSection } from '@/components/rosacare/HeroSection';
import { AboutSection } from '@/components/rosacare/AboutSection';
import { CategoryShowcase } from '@/components/rosacare/CategoryShowcase';
import { ProductCard } from '@/components/rosacare/ProductCard';
import { BenefitsSection } from '@/components/rosacare/BenefitsSection';
import { HeritageSection } from '@/components/rosacare/HeritageSection';
import { WhyRosaCareSection } from '@/components/rosacare/WhyRosaCareSection';
import { Parallax } from '@/components/rosacare/Parallax';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';

interface Category {
    id: number;
    slug: string;
    icon?: string;
    image?: string;
    image_url?: string;
    translations: Array<{
        locale: string;
        name: string;
        description?: string;
    }>;
}

interface Product {
    id: number;
    slug: string;
    translations: Array<{
        locale: string;
        name: string;
        short_description?: string;
    }>;
    media?: Array<{
        id: number;
        file_name: string;
        path: string;
        collection_name: string;
    }>;
}

interface MenuItem {
    id: number;
    type: string;
    url?: string;
    icon?: string;
    page?: string;
    category_id?: number;
    open_in_new_tab: boolean;
    sort_order: number;
    is_active: boolean;
    translations: Array<{
        locale: string;
        label: string;
    }>;
    category?: {
        slug: string;
        translations: Array<{
            locale: string;
            name: string;
        }>;
    };
}

interface Setting {
    id: number;
    logo_header_path?: string;
    header_logo_url?: string;
    logo_footer_path?: string;
    footer_logo_url?: string;
    favicon_path?: string;
    favicon_url?: string;
    default_meta_image?: string;
    default_meta_image_url?: string;
    translations?: Array<{
        locale: string;
        site_name?: string;
        slogan?: string;
        footer_description?: string;
        footer_copyright?: string;
        default_meta_title?: string;
        default_meta_description?: string;
        default_meta_keywords?: string;
    }>;
}

interface Hero {
    id: number;
    image: string;
    button_url: string;
    button_color?: string;
    button_text_color?: string;
    translations: Array<{
        locale: string;
        title?: string;
        description?: string;
        button_text?: string;
    }>;
}

interface Announcement {
    id: number;
    image?: string;
    button_url?: string;
    button_color?: string;
    button_text_color?: string;
    translations: Array<{
        locale: string;
        title?: string;
        description?: string;
        button_text?: string;
    }>;
}

interface Welcome {
    id: number;
    image: string;
    button_url: string;
    translations: Array<{
        locale: string;
        title?: string;
        description?: string;
        button_text?: string;
    }>;
}

interface WelcomeDetail {
    id: number;
    image: string;
    button_url?: string;
    button_color?: string;
    button_text_color?: string;
    translations: Array<{
        locale: string;
        title?: string;
        description?: string;
        button_text?: string;
    }>;
}

interface ParallaxData {
    id: number;
    image?: string;
    image_url?: string;
    link?: string;
    translations: Array<{
        locale: string;
        title?: string;
        description?: string;
    }>;
}

interface HomeProps {
    categories: Category[];
    featuredProducts: Product[];
    locale?: string;
    settings?: Setting;
    heros?: Hero[];
    announcements?: Announcement[];
    welcome?: Welcome;
    welcomeDetails?: WelcomeDetail[];
    parallax?: ParallaxData;
}

export default function Home({
    categories,
    featuredProducts,
    locale = 'ar',
    settings,
    heros = [],
    announcements = [],
    welcome,
    welcomeDetails = [],
    parallax,
}: HomeProps) {
    const isRTL = locale === 'ar';
    const page = usePage<{ props: { menuItems?: MenuItem[] } }>();
    // Get menuItems from shared props (HandleInertiaRequests middleware)
    const menuItems = (page.props.menuItems || []) as MenuItem[];

    // Get meta data from settings
    // Settings translations is an array, not an object
    const settingsTranslation = settings?.translations?.find((t: any) => t.locale === locale) || settings?.translations?.[0];
    const metaTitle = settingsTranslation?.default_meta_title || settingsTranslation?.site_name || 'RosaCare - Authentic Damask Rose Products';
    const metaDescription = settingsTranslation?.default_meta_description || settingsTranslation?.slogan || '';
    const metaKeywords = settingsTranslation?.default_meta_keywords || '';
    const metaImage = settings?.default_meta_image_url || '';
    const siteName = settingsTranslation?.site_name || 'RosaCare';

    // Convert heroes to hero items for HeroSection
    const heroItems = heros.map((hero) => {
        const translation = hero.translations.find(t => t.locale === locale) || hero.translations[0];
        return {
            id: hero.id,
            title: translation?.title || '',
            description: translation?.description || '',
            image: hero.image,
            buttonText: translation?.button_text,
            buttonLink: hero.button_url,
            buttonColor: hero.button_color,
            buttonTextColor: hero.button_text_color,
        };
    }).filter(item => item.title); // Only include items with titles

    return (
        <>
            <Head>
                <title>{metaTitle}</title>
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
                    .fade-in-up {
                        animation: fadeInUp 1s ease-out both;
                    }
                `}</style>
                {metaDescription && <meta name="description" content={metaDescription} />}
                {metaKeywords && <meta name="keywords" content={metaKeywords} />}

                {/* Open Graph / Facebook */}
                <meta property="og:type" content="website" />
                <meta property="og:title" content={metaTitle} />
                {metaDescription && <meta property="og:description" content={metaDescription} />}
                {metaImage && <meta property="og:image" content={metaImage} />}
                <meta property="og:site_name" content={siteName} />

                {/* Twitter */}
                <meta name="twitter:card" content="summary_large_image" />
                <meta name="twitter:title" content={metaTitle} />
                {metaDescription && <meta name="twitter:description" content={metaDescription} />}
                {metaImage && <meta name="twitter:image" content={metaImage} />}

                {/* Favicon */}
                {settings?.favicon_url && <link rel="icon" href={settings.favicon_url} />}
            </Head>
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />

                {/* Announcements Banner */}
                {announcements.length > 0 && (
                    <div className="bg-primary text-white">
                        <div className="container mx-auto px-4 py-3">
                            <div className="flex items-center justify-center gap-4 flex-wrap">
                                {announcements.map((announcement) => {
                                    const translation = announcement.translations.find(t => t.locale === locale) || announcement.translations[0];
                                    return (
                                        <div key={announcement.id} className="flex items-center gap-3">
                                            {translation?.title && (
                                                <span className="font-semibold">{translation.title}</span>
                                            )}
                                            {translation?.description && (
                                                <span>{translation.description}</span>
                                            )}
                                            {translation?.button_text && announcement.button_url && (
                                                <a
                                                    href={announcement.button_url}
                                                    className="underline hover:opacity-80"
                                                    style={{
                                                        color: announcement.button_text_color || '#FFFFFF',
                                                    }}
                                                >
                                                    {translation.button_text}
                                                </a>
                                            )}
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                )}

                {/* Hero Section with Swiper - works with or without hero items */}
                <HeroSection locale={locale} items={heroItems} />

                {/* Welcome Section */}
                {welcome && (
                    <section className="py-20 relative" style={{
                        background: 'linear-gradient(135deg, #f5f5f5 0%, #ffffff 50%, #fafafa 100%)'
                    }}>
                        {/* Rose Petals Background for Welcome Section */}
                        <div style={{
                            position: 'absolute',
                            top: 0,
                            left: 0,
                            width: '100%',
                            height: '100%',
                            pointerEvents: 'none',
                            zIndex: 1,
                            overflow: 'hidden'
                        }}>
                            <div style={{
                                position: 'absolute',
                                width: '250px',
                                height: '250px',
                                borderRadius: '50% 0 50% 0',
                                background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.08), rgba(134, 44, 145, 0.08))',
                                top: '20%',
                                left: '5%',
                                animation: 'float 20s infinite ease-in-out'
                            }} />
                            <div style={{
                                position: 'absolute',
                                width: '250px',
                                height: '250px',
                                borderRadius: '50% 0 50% 0',
                                background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.08), rgba(134, 44, 145, 0.08))',
                                top: '50%',
                                right: '5%',
                                animation: 'float 20s infinite ease-in-out',
                                animationDelay: '10s'
                            }} />
                        </div>
                        <div className="container mx-auto px-4 relative" style={{ zIndex: 2 }}>
                            <div className="grid md:grid-cols-2 gap-12 items-center">
                                <div className={`fade-in-up ${isRTL ? 'rtl' : 'ltr'}`} style={{ animationDelay: '0.3s' }}>
                                    {welcome.translations && welcome.translations.length > 0 && (
                                        <>
                                            {(() => {
                                                const translation = welcome.translations.find(t => t.locale === locale) || welcome.translations[0];
                                                return (
                                                    <div style={{
                                                        padding: '2.5rem 2rem',
                                                        background: 'rgba(255, 255, 255, 0.8)',
                                                        borderRadius: '20px',
                                                        boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                                    }}>
                                                        {translation.title && (
                                                            <h2 className="text-4xl md:text-5xl font-light mb-6" style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                color: '#545759',
                                                                letterSpacing: '0.05em'
                                                            }}>
                                                                {translation.title}
                                                            </h2>
                                                        )}
                                                        {translation.description && (
                                                            <p className="text-lg mb-8" style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                fontWeight: 300,
                                                                color: '#545759',
                                                                lineHeight: '1.8'
                                                            }}>
                                                                {translation.description}
                                                            </p>
                                                        )}
                                                        {translation.button_text && welcome.button_url && (
                                                            <a
                                                                href={welcome.button_url}
                                                                className="inline-block px-8 py-3 rounded-lg text-white font-medium transition-all hover:-translate-y-0.5"
                                                                style={{
                                                                    fontFamily: "'Alexandria', sans-serif",
                                                                    fontWeight: 500,
                                                                    letterSpacing: '0.05em',
                                                                    background: 'linear-gradient(135deg, #e72177, #862b90)',
                                                                    boxShadow: '0 5px 20px rgba(231, 33, 119, 0.3)'
                                                                }}
                                                                onMouseEnter={(e) => {
                                                                    e.currentTarget.style.boxShadow = '0 8px 30px rgba(231, 33, 119, 0.4)';
                                                                }}
                                                                onMouseLeave={(e) => {
                                                                    e.currentTarget.style.boxShadow = '0 5px 20px rgba(231, 33, 119, 0.3)';
                                                                }}
                                                            >
                                                                {translation.button_text}
                                                            </a>
                                                        )}
                                                    </div>
                                                );
                                            })()}
                                        </>
                                    )}
                                </div>
                                {welcome.image && (
                                    <div className="fade-in-up" style={{ animationDelay: '0.5s' }}>
                                        <div style={{
                                            padding: '1rem',
                                            background: 'rgba(255, 255, 255, 0.8)',
                                            borderRadius: '20px',
                                            boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                        }}>
                                            <img
                                                src={`/storage/${welcome.image}`}
                                                alt={welcome.translations.find(t => t.locale === locale)?.title || 'Welcome'}
                                                className="w-full h-auto rounded-lg"
                                            />
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </section>
                )}

                {/* Welcome Details */}
                {welcomeDetails.length > 0 && (
                    <section className="py-20 relative" style={{
                        background: 'linear-gradient(135deg, #f5f5f5 0%, #ffffff 50%, #fafafa 100%)'
                    }}>
                        {/* Rose Petals Background for Welcome Details Section */}
                        <div style={{
                            position: 'absolute',
                            top: 0,
                            left: 0,
                            width: '100%',
                            height: '100%',
                            pointerEvents: 'none',
                            zIndex: 1,
                            overflow: 'hidden'
                        }}>
                            <div style={{
                                position: 'absolute',
                                width: '200px',
                                height: '200px',
                                borderRadius: '50% 0 50% 0',
                                background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.06), rgba(134, 44, 145, 0.06))',
                                top: '15%',
                                left: '8%',
                                animation: 'float 20s infinite ease-in-out'
                            }} />
                            <div style={{
                                position: 'absolute',
                                width: '200px',
                                height: '200px',
                                borderRadius: '50% 0 50% 0',
                                background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.06), rgba(134, 44, 145, 0.06))',
                                bottom: '20%',
                                right: '8%',
                                animation: 'float 20s infinite ease-in-out',
                                animationDelay: '10s'
                            }} />
                        </div>
                        <div className="container mx-auto px-4 relative" style={{ zIndex: 2 }}>
                            <div className="grid md:grid-cols-3 gap-6">
                                {welcomeDetails.map((detail, index) => {
                                    const translation = detail.translations.find(t => t.locale === locale) || detail.translations[0];
                                    return (
                                        <div
                                            key={detail.id}
                                            className={`fade-in-up ${isRTL ? 'rtl' : 'ltr'}`}
                                            style={{
                                                animationDelay: `${0.3 + index * 0.1}s`,
                                                background: 'rgba(255, 255, 255, 0.8)',
                                                borderRadius: '20px',
                                                boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)',
                                                overflow: 'hidden',
                                                transition: 'transform 0.3s ease, box-shadow 0.3s ease'
                                            }}
                                            onMouseEnter={(e) => {
                                                e.currentTarget.style.transform = 'translateY(-5px)';
                                                e.currentTarget.style.boxShadow = '0 15px 50px rgba(231, 33, 119, 0.15)';
                                            }}
                                            onMouseLeave={(e) => {
                                                e.currentTarget.style.transform = 'translateY(0)';
                                                e.currentTarget.style.boxShadow = '0 10px 40px rgba(231, 33, 119, 0.1)';
                                            }}
                                        >
                                            {detail.image && (
                                                <div className="overflow-hidden">
                                                    <img
                                                        src={`/storage/${detail.image}`}
                                                        alt={translation?.title || 'Feature'}
                                                        className="w-full h-48 object-cover transition-transform duration-300 hover:scale-105"
                                                    />
                                                </div>
                                            )}
                                            <div className="p-6">
                                                {translation?.title && (
                                                    <h3 className="text-2xl font-light mb-3" style={{
                                                        fontFamily: "'Alexandria', sans-serif",
                                                        color: '#545759',
                                                        letterSpacing: '0.05em'
                                                    }}>
                                                        {translation.title}
                                                    </h3>
                                                )}
                                                {translation?.description && (
                                                    <p className="mb-4" style={{
                                                        fontFamily: "'Alexandria', sans-serif",
                                                        fontWeight: 300,
                                                        color: '#545759',
                                                        lineHeight: '1.8'
                                                    }}>
                                                        {translation.description}
                                                    </p>
                                                )}
                                                {translation?.button_text && detail.button_url && (
                                                    <a
                                                        href={detail.button_url}
                                                        className="inline-block px-6 py-2 rounded-lg font-medium transition-all hover:-translate-y-0.5"
                                                        style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            fontWeight: 500,
                                                            letterSpacing: '0.05em',
                                                            backgroundColor: detail.button_color || '#e72177',
                                                            color: detail.button_text_color || '#FFFFFF',
                                                            boxShadow: '0 5px 15px rgba(231, 33, 119, 0.3)'
                                                        }}
                                                        onMouseEnter={(e) => {
                                                            e.currentTarget.style.boxShadow = '0 8px 25px rgba(231, 33, 119, 0.4)';
                                                        }}
                                                        onMouseLeave={(e) => {
                                                            e.currentTarget.style.boxShadow = '0 5px 15px rgba(231, 33, 119, 0.3)';
                                                        }}
                                                    >
                                                        {translation.button_text}
                                                    </a>
                                                )}
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </section>
                )}

                <AboutSection locale={locale} />
                {categories.length > 0 && <CategoryShowcase categories={categories} locale={locale} />}
                {featuredProducts.length > 0 && (
                    <section className="py-20 bg-background">
                        <div className="container mx-auto px-4">
                            <h2 className={`text-4xl md:text-5xl font-bold mb-12 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                                {locale === 'ar' ? 'منتجات مميزة' : 'Featured Products'}
                            </h2>
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                {featuredProducts.map((product) => (
                                    <ProductCard key={product.id} product={product} locale={locale} />
                                ))}
                            </div>
                        </div>
                    </section>
                )}
                <BenefitsSection locale={locale} />
                <HeritageSection locale={locale} />
                <WhyRosaCareSection locale={locale} />
                <Parallax locale={locale} parallax={parallax} />
                <Footer locale={locale} />
            </div>
        </>
    );
}
