import { Head, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
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
import { WhatsAppButton } from '@/components/rosacare/WhatsAppButton';

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
    phone_number?: string;
    email?: string;
    address?: string;
    facebook?: string;
    twitter?: string;
    instagram?: string;
    linkedin?: string;
    youtube?: string;
    tiktok?: string;
    whatsapp?: string;
    show_whatsapp_button?: boolean;
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
    image_url?: string;
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

interface AboutData {
    id?: number;
    story?: {
        title?: string;
        content?: string;
        paragraphs?: string[];
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
    about?: AboutData | null;
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
    about = null,
}: HomeProps) {
    const isRTL = locale === 'ar';
    const page = usePage<{ props: { menuItems?: MenuItem[] } }>();
    // Get menuItems from shared props (HandleInertiaRequests middleware)
    const menuItems = (page.props.menuItems || []) as MenuItem[];

    // State for closed announcements
    const [closedAnnouncements, setClosedAnnouncements] = useState<Set<number>>(new Set());
    const [visibleAnnouncements, setVisibleAnnouncements] = useState<Announcement[]>([]);
    const [closingAnnouncements, setClosingAnnouncements] = useState<Set<number>>(new Set());

    // Load closed announcements from localStorage on mount
    useEffect(() => {
        const stored = localStorage.getItem('closedAnnouncements');
        if (stored) {
            try {
                const closedIds = JSON.parse(stored) as number[];
                setClosedAnnouncements(new Set(closedIds));
            } catch (e) {
                console.error('Error parsing closed announcements:', e);
            }
        }
    }, []);

    // Filter visible announcements based on closed state
    useEffect(() => {
        const visible = announcements.filter(ann => !closedAnnouncements.has(ann.id));
        setVisibleAnnouncements(visible);
    }, [announcements, closedAnnouncements]);

    // Function to close an announcement
    const closeAnnouncement = (announcementId: number) => {
        // Start closing animation
        setClosingAnnouncements(prev => new Set(prev).add(announcementId));

        // After animation, mark as closed
        setTimeout(() => {
            const newClosed = new Set(closedAnnouncements);
            newClosed.add(announcementId);
            setClosedAnnouncements(newClosed);
            setClosingAnnouncements(prev => {
                const next = new Set(prev);
                next.delete(announcementId);
                return next;
            });
            localStorage.setItem('closedAnnouncements', JSON.stringify(Array.from(newClosed)));
        }, 300);
    };

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
                    @keyframes slideDown {
                        from {
                            opacity: 0;
                            transform: translateY(-100%);
                        }
                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }
                    @keyframes fadeOut {
                        from {
                            opacity: 1;
                            transform: translateY(0);
                        }
                        to {
                            opacity: 0;
                            transform: translateY(-100%);
                        }
                    }
                    .fade-in-up {
                        animation: fadeInUp 1s ease-out both;
                    }
                    .floating-announcement {
                        animation: slideDown 0.5s ease-out;
                    }
                    .floating-announcement.closing {
                        animation: fadeOut 0.3s ease-out forwards;
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

                {/* Floating Announcements Banner */}
                {visibleAnnouncements.length > 0 && (
                    <div className="sticky top-16 left-0 right-0 z-40 floating-announcement">
                        {visibleAnnouncements.map((announcement) => {
                            const translation = announcement.translations.find(t => t.locale === locale) || announcement.translations[0];
                            const hasImage = announcement.image_url && announcement.image;
                            const isClosing = closingAnnouncements.has(announcement.id);

                            return (
                                <div
                                    key={announcement.id}
                                    className={`relative ${isClosing ? 'closing' : ''}`}
                                    style={{
                                        background: hasImage
                                            ? 'transparent'
                                            : 'linear-gradient(135deg, rgba(231, 33, 119, 0.95) 0%, rgba(134, 44, 145, 0.95) 100%)',
                                        boxShadow: '0 4px 20px rgba(0, 0, 0, 0.15)',
                                    }}
                                >
                                    {/* Close Button */}
                                    <button
                                        onClick={() => closeAnnouncement(announcement.id)}
                                        className="absolute top-2 right-2 md:top-4 md:right-4 z-10 p-2 rounded-full bg-white/20 hover:bg-white/30 text-white transition-all duration-200 flex items-center justify-center"
                                        style={{
                                            width: '32px',
                                            height: '32px',
                                            backdropFilter: 'blur(10px)',
                                        }}
                                        aria-label={locale === 'ar' ? 'إغلاق' : 'Close'}
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            className="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>

                                    {hasImage ? (
                                        // Announcement with Image Layout
                                        <div className="relative">
                                            <img
                                                src={announcement.image_url}
                                                alt={translation?.title || 'Announcement'}
                                                className="w-full h-auto object-cover"
                                                style={{ maxHeight: '300px' }}
                                            />
                                            <div
                                                className="absolute inset-0 flex items-center justify-center"
                                                style={{
                                                    background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.85) 0%, rgba(134, 44, 145, 0.85) 100%)',
                                                }}
                                            >
                                                <div className="container mx-auto px-4 text-center text-white">
                                                    {translation?.title && (
                                                        <h3
                                                            className="text-2xl md:text-3xl font-light mb-3"
                                                            style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                letterSpacing: '0.05em',
                                                            }}
                                                        >
                                                            {translation.title}
                                                        </h3>
                                                    )}
                                                    {translation?.description && (
                                                        <p
                                                            className="text-base md:text-lg mb-4 max-w-3xl mx-auto"
                                                            style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                fontWeight: 300,
                                                                lineHeight: '1.8',
                                                            }}
                                                        >
                                                            {translation.description}
                                                        </p>
                                                    )}
                                                    {translation?.button_text && announcement.button_url && (
                                                        <a
                                                            href={announcement.button_url}
                                                            className="inline-block px-6 py-2 md:px-8 md:py-3 rounded-lg font-medium transition-all hover:-translate-y-0.5"
                                                            style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                fontWeight: 500,
                                                                letterSpacing: '0.05em',
                                                                backgroundColor: announcement.button_color || '#FFFFFF',
                                                                color: announcement.button_text_color || '#e72177',
                                                                boxShadow: '0 5px 20px rgba(0, 0, 0, 0.2)',
                                                            }}
                                                            onMouseEnter={(e) => {
                                                                e.currentTarget.style.boxShadow = '0 8px 30px rgba(0, 0, 0, 0.3)';
                                                                e.currentTarget.style.transform = 'translateY(-2px)';
                                                            }}
                                                            onMouseLeave={(e) => {
                                                                e.currentTarget.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.2)';
                                                                e.currentTarget.style.transform = 'translateY(0)';
                                                            }}
                                                        >
                                                            {translation.button_text}
                                                        </a>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    ) : (
                                        // Announcement without Image Layout
                                        <div className="container mx-auto px-4">
                                            <div
                                                className="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-6 py-3 md:py-4"
                                                style={{
                                                    background: 'rgba(255, 255, 255, 0.95)',
                                                    borderRadius: '15px',
                                                    padding: '1rem 1.5rem',
                                                    margin: '0.5rem 0',
                                                }}
                                            >
                                                <div className="flex-1 text-center md:text-left pr-8 md:pr-0">
                                                    {translation?.title && (
                                                        <h3
                                                            className="text-lg md:text-xl font-semibold mb-1 md:mb-2"
                                                            style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                color: '#545759',
                                                                letterSpacing: '0.05em',
                                                            }}
                                                        >
                                                            {translation.title}
                                                        </h3>
                                                    )}
                                                    {translation?.description && (
                                                        <p
                                                            className="text-sm md:text-base"
                                                            style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                fontWeight: 300,
                                                                color: '#545759',
                                                                lineHeight: '1.6',
                                                            }}
                                                        >
                                                            {translation.description}
                                                        </p>
                                                    )}
                                                </div>
                                                {translation?.button_text && announcement.button_url && (
                                                    <a
                                                        href={announcement.button_url}
                                                        className="inline-block px-5 py-2 md:px-6 md:py-2 rounded-lg font-medium transition-all hover:-translate-y-0.5 whitespace-nowrap"
                                                        style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            fontWeight: 500,
                                                            letterSpacing: '0.05em',
                                                            backgroundColor: announcement.button_color || '#e72177',
                                                            color: announcement.button_text_color || '#FFFFFF',
                                                            boxShadow: '0 5px 15px rgba(231, 33, 119, 0.3)',
                                                        }}
                                                        onMouseEnter={(e) => {
                                                            e.currentTarget.style.boxShadow = '0 8px 25px rgba(231, 33, 119, 0.4)';
                                                            e.currentTarget.style.transform = 'translateY(-2px)';
                                                        }}
                                                        onMouseLeave={(e) => {
                                                            e.currentTarget.style.boxShadow = '0 5px 15px rgba(231, 33, 119, 0.3)';
                                                            e.currentTarget.style.transform = 'translateY(0)';
                                                        }}
                                                    >
                                                        {translation.button_text}
                                                    </a>
                                                )}
                                            </div>
                                        </div>
                                    )}
                                </div>
                            );
                        })}
                    </div>
                )}


                {/* Hero Section with Swiper - works with or without hero items */}
                <HeroSection locale={locale} items={heroItems} />
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

                <AboutSection locale={locale} about={about} />
                {categories.length > 0 && <CategoryShowcase categories={categories} locale={locale} />}
                <BenefitsSection locale={locale} about={about} />
                <HeritageSection locale={locale} about={about} />
                <WhyRosaCareSection locale={locale} about={about} />
                <Parallax locale={locale} parallax={parallax} />
                <Footer locale={locale} />

                {/* WhatsApp Floating Button */}
                <WhatsAppButton
                    whatsappUrl={settings?.whatsapp}
                    showButton={!!settings?.show_whatsapp_button}
                    locale={locale}
                />
            </div>
        </>
    );
}
