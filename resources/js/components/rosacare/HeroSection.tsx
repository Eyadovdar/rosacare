import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';
import { Autoplay, EffectFade, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

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
    // Use two static hero images from /assets/images so Laravel serves them directly.
    const defaultItems: HeroItem[] =
        items.length > 0
            ? items
            : [
                  {
                      id: 0,
                      title: locale === 'ar' ? 'روزاكير' : 'RosaCare',
                      description:
                          locale === 'ar'
                              ? 'من قلب الشام، أرقى منتجات الوردة الشامية الأصيلة'
                              : 'From the heart of Syria, the finest authentic Damask Rose products',
                      buttonText:
                          locale === 'ar'
                              ? 'استكشف المنتجات'
                              : 'Explore Products',
                      buttonLink: '/products',
                      image: '/assets/images/hero1.jpg',
                  },
                  {
                      id: 1,
                      title: locale === 'ar' ? 'روزاكير' : 'RosaCare',
                      description:
                          locale === 'ar'
                              ? 'من قلب الشام، أرقى منتجات الوردة الشامية الأصيلة'
                              : 'From the heart of Syria, the finest authentic Damask Rose products',
                      buttonText: undefined,
                      buttonLink: undefined,
                      image: '/assets/images/hero2.png',
                  },
              ];

    return (
        <section className="relative h-[80vh] min-h-[600px] w-full">
            <Swiper
                modules={[Autoplay, Pagination, EffectFade]}
                spaceBetween={0}
                slidesPerView={1}
                loop={defaultItems.length > 1}
                // Autoplay: automatically advance slides.
                // - `delay`: time between transitions (ms). Set to 4000 for 4 seconds.
                // - `disableOnInteraction`: when false, user interactions (touch/drag/click) won't disable autoplay.
                // - `pauseOnMouseEnter`: when false, hovering the mouse won't pause autoplay.
                autoplay={{
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false,
                }}
                speed={1000}
                pagination={{
                    clickable: true,
                    dynamicBullets: true,
                    // Don't include spaces in class tokens (Swiper will add suffixes),
                    // apply visual styles via Tailwind selectors in `className` instead.
                    bulletClass: 'swiper-pagination-bullet',
                    bulletActiveClass: 'swiper-pagination-bullet-active',
                }}
                navigation={false}
                effect="fade"
                fadeEffect={{
                    crossFade: true,
                }}
                className="h-full w-full [&_.swiper-pagination-bullet]:h-3 [&_.swiper-pagination-bullet]:w-3 [&_.swiper-pagination-bullet]:rounded-full [&_.swiper-pagination-bullet]:bg-white/50 [&_.swiper-pagination-bullet-active]:bg-white"
                dir={isRTL ? 'rtl' : 'ltr'}
            >
                {defaultItems.map((item, index) => (
                    <SwiperSlide key={item.id || index} className="relative">
                        <div
                            className="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-1000"
                            style={{
                                backgroundImage: item.image
                                    ? `url(${typeof item.image === 'string' && item.image.startsWith('/') ? item.image : `/storage/${item.image}`})`
                                    : 'linear-gradient(135deg, rgba(233, 30, 99, 0.1) 0%, rgba(156, 39, 176, 0.3) 50%, rgba(233, 30, 99, 0.1) 100%)',
                            }}
                        >
                            {/* Decorative background elements (only if no image) */}
                            {!item.image && (
                                <div className="absolute inset-0 opacity-10">
                                    <div className="absolute top-20 left-10 h-72 w-72 rounded-full bg-primary blur-3xl"></div>
                                    <div className="absolute right-10 bottom-20 h-96 w-96 rounded-full bg-secondary blur-3xl"></div>
                                </div>
                            )}

                            {/* Overlay - darker if image exists */}
                            <div
                                className={`absolute inset-0 ${item.image ? 'bg-black/50' : 'bg-black/20'}`}
                            ></div>

                            {/* Content */}
                            <div className="relative z-10 flex h-full items-center justify-center">
                                {/* Decorative images removed per request */}

                                <div
                                    className={`container mx-auto px-4 text-center ${isRTL ? 'rtl' : 'ltr'}`}
                                >
                                    <h1 className="mb-6 text-4xl font-bold text-white drop-shadow-lg md:text-5xl lg:text-7xl">
                                        {item.title}
                                    </h1>
                                    <p className="mx-auto mb-8 max-w-3xl text-xl leading-relaxed text-white/95 drop-shadow-md md:text-2xl">
                                        {item.description}
                                    </p>
                                    {item.buttonText && item.buttonLink && (
                                        <div>
                                            <Button
                                                asChild
                                                size="lg"
                                                className="px-8 py-6 text-lg shadow-lg transition-all duration-300 hover:shadow-xl"
                                                style={{
                                                    backgroundColor:
                                                        item.buttonColor ||
                                                        undefined,
                                                    color:
                                                        item.buttonTextColor ||
                                                        undefined,
                                                }}
                                            >
                                                <Link href={item.buttonLink}>
                                                    {item.buttonText}
                                                </Link>
                                            </Button>
                                        </div>
                                    )}
                                    {!item.buttonText && !item.buttonLink && (
                                        <div className="flex flex-col justify-center gap-4 sm:flex-row">
                                            <Button
                                                asChild
                                                size="lg"
                                                className="px-8 py-6 text-lg shadow-lg transition-all duration-300 hover:shadow-xl"
                                            >
                                                <Link href="/products">
                                                    {locale === 'ar'
                                                        ? 'استكشف المنتجات'
                                                        : 'Explore Products'}
                                                </Link>
                                            </Button>
                                            {/* <Button
                                                asChild
                                                variant="outline"
                                                size="lg"
                                                className="border-white/30 bg-white/10 px-8 py-6 text-lg text-white backdrop-blur-sm hover:bg-white/20"
                                            >
                                                <Link href="/about">
                                                    {locale === 'ar'
                                                        ? 'قصتنا'
                                                        : 'Our Story'}
                                                </Link>
                                            </Button> */}
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
