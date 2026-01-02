import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination, Navigation, EffectFade } from 'swiper/modules';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';

interface HeroItem {
    id?: number;
    title: string;
    description: string;
    image?: string;
    buttonText?: string;
    buttonLink?: string;
    buttonColor?: string;
    buttonTextColor?: string;
}

interface HeroSectionProps {
    locale?: string;
    items?: HeroItem[];
}

export function HeroSection({ locale = 'ar', items = [] }: HeroSectionProps) {
    const isRTL = locale === 'ar';

    // Default fallback content if no items provided
    const defaultItems: HeroItem[] = items.length > 0 ? items : [
        {
            id: 0,
            title: locale === 'ar' ? 'روزاكير' : 'RosaCare',
            description: locale === 'ar'
                ? 'من قلب الشام، أرقى منتجات الوردة الشامية الأصيلة'
                : 'From the heart of Syria, the finest authentic Damask Rose products',
            buttonText: locale === 'ar' ? 'استكشف المنتجات' : 'Explore Products',
            buttonLink: '/products',
        }
    ];

    return (
        <section className="relative w-full h-[80vh] min-h-[600px]">
            <Swiper
                modules={[Autoplay, Pagination, Navigation, EffectFade]}
                spaceBetween={0}
                slidesPerView={1}
                loop={defaultItems.length > 1}
                autoplay={{
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                }}
                speed={1000}
                pagination={{
                    clickable: true,
                    dynamicBullets: true,
                    bulletClass: 'swiper-pagination-bullet !bg-white/50',
                    bulletActiveClass: 'swiper-pagination-bullet-active !bg-white',
                }}
                navigation={defaultItems.length > 1}
                effect="fade"
                fadeEffect={{
                    crossFade: true,
                }}
                className="h-full w-full [&_.swiper-button-next]:text-white [&_.swiper-button-prev]:text-white [&_.swiper-button-next]:hover:text-primary [&_.swiper-button-prev]:hover:text-primary [&_.swiper-button-next]:transition-colors [&_.swiper-button-prev]:transition-colors [&_.swiper-button-next]:w-12 [&_.swiper-button-next]:h-12 [&_.swiper-button-prev]:w-12 [&_.swiper-button-prev]:h-12"
                dir={isRTL ? 'rtl' : 'ltr'}
            >
                {defaultItems.map((item, index) => (
                    <SwiperSlide key={item.id || index} className="relative">
                        <div
                            className="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-1000"
                            style={{
                                backgroundImage: item.image
                                    ? `url(/storage/${item.image})`
                                    : 'linear-gradient(135deg, rgba(233, 30, 99, 0.1) 0%, rgba(156, 39, 176, 0.3) 50%, rgba(233, 30, 99, 0.1) 100%)',
                            }}
                        >
                            {/* Decorative background elements (only if no image) */}
                            {!item.image && (
                                <div className="absolute inset-0 opacity-10">
                                    <div className="absolute top-20 left-10 w-72 h-72 bg-primary rounded-full blur-3xl"></div>
                                    <div className="absolute bottom-20 right-10 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
                                </div>
                            )}

                            {/* Overlay - darker if image exists */}
                            <div className={`absolute inset-0 ${item.image ? 'bg-black/50' : 'bg-black/20'}`}></div>

                            {/* Content */}
                            <div className="relative z-10 h-full flex items-center justify-center">
                                <div className={`container mx-auto px-4 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                                    <h1 className="text-4xl md:text-5xl lg:text-7xl font-bold mb-6 text-white drop-shadow-lg">
                                        {item.title}
                                    </h1>
                                    <p className="text-xl md:text-2xl text-white/95 mb-8 max-w-3xl mx-auto leading-relaxed drop-shadow-md">
                                        {item.description}
                                    </p>
                                    {item.buttonText && item.buttonLink && (
                                        <div>
                                            <Button
                                                asChild
                                                size="lg"
                                                className="text-lg px-8 py-6 shadow-lg hover:shadow-xl transition-all duration-300"
                                                style={{
                                                    backgroundColor: item.buttonColor || undefined,
                                                    color: item.buttonTextColor || undefined,
                                                }}
                                            >
                                                <Link href={item.buttonLink}>
                                                    {item.buttonText}
                                                </Link>
                                            </Button>
                                        </div>
                                    )}
                                    {!item.buttonText && !item.buttonLink && (
                                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                            <Button asChild size="lg" className="text-lg px-8 py-6 shadow-lg hover:shadow-xl transition-all duration-300">
                                                <Link href="/products">
                                                    {locale === 'ar' ? 'استكشف المنتجات' : 'Explore Products'}
                                                </Link>
                                            </Button>
                                            <Button asChild variant="outline" size="lg" className="text-lg px-8 py-6 bg-white/10 backdrop-blur-sm border-white/30 text-white hover:bg-white/20">
                                                <Link href="/about">
                                                    {locale === 'ar' ? 'قصتنا' : 'Our Story'}
                                                </Link>
                                            </Button>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                ))}
            </Swiper>
        </section>
    );
}
