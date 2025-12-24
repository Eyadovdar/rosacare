import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Pagination, Navigation, EffectFade } from 'swiper/modules';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';

interface CarouselItem {
    id?: number;
    title: string;
    description: string;
    image?: string;
    buttonText?: string;
    buttonLink?: string;
}

interface HeroCarouselProps {
    items: CarouselItem[];
    locale?: string;
}

export function HeroCarousel({ items, locale = 'ar' }: HeroCarouselProps) {
    const isRTL = locale === 'ar';

    if (!items || items.length === 0) {
        return null;
    }

    return (
        <section className="relative w-full h-[80vh] min-h-[600px]">
            <Swiper
                modules={[Autoplay, Pagination, Navigation, EffectFade]}
                spaceBetween={0}
                slidesPerView={1}
                loop={items.length > 1}
                autoplay={{
                    delay: 5000,
                    disableOnInteraction: false,
                }}
                pagination={{
                    clickable: true,
                    dynamicBullets: true,
                }}
                navigation={items.length > 1}
                effect="fade"
                fadeEffect={{
                    crossFade: true,
                }}
                className="h-full w-full [&_.swiper-button-next]:text-white [&_.swiper-button-prev]:text-white [&_.swiper-pagination-bullet-active]:bg-white"
                dir={isRTL ? 'rtl' : 'ltr'}
            >
                {items.map((item, index) => (
                    <SwiperSlide key={item.id || index} className="relative">
                        <div
                            className="absolute inset-0 bg-cover bg-center bg-no-repeat"
                            style={{
                                backgroundImage: item.image 
                                    ? `url(/storage/${item.image})` 
                                    : 'linear-gradient(to bottom right, var(--primary), var(--secondary))',
                            }}
                        >
                            {/* Overlay */}
                            <div className="absolute inset-0 bg-black/40"></div>
                            
                            {/* Content */}
                            <div className="relative z-10 h-full flex items-center justify-center">
                                <div className={`container mx-auto px-4 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                                    <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                                        {item.title}
                                    </h1>
                                    <p className="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                                        {item.description}
                                    </p>
                                    {item.buttonText && item.buttonLink && (
                                        <Button asChild size="lg" className="text-lg px-8 py-6">
                                            <Link href={item.buttonLink}>
                                                {item.buttonText}
                                            </Link>
                                        </Button>
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

