import { Head, Link, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { Button } from '@/components/ui/button';
import { Home, Search, ArrowLeft } from 'lucide-react';

interface Error404Props {
    locale?: string;
}

export default function Error404({ locale = 'ar' }: Error404Props) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];

    return (
        <>
            <Head title={locale === 'ar' ? '404 - الصفحة غير موجودة - روزاكير' : '404 - Page Not Found - RosaCare'} />
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
                .error-content {
                    position: relative;
                    z-index: 2;
                }
                .fade-in {
                    animation: fadeIn 1s ease-out;
                }
                .fade-in-up {
                    animation: fadeInUp 1s ease-out both;
                }
                .error-number {
                    font-size: 12rem;
                    font-weight: 700;
                    background: linear-gradient(135deg, #e72177, #862b90);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                    line-height: 1;
                    letter-spacing: -0.05em;
                }
                @media (max-width: 768px) {
                    .error-number {
                        font-size: 8rem;
                    }
                }
            `}</style>
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <div className="rose-petals" />
                <Navbar menuItems={menuItems} locale={locale} />

                <section className="py-20 min-h-[80vh] flex items-center justify-center bg-gradient-to-b from-secondary/30 via-background to-secondary/30">
                    <div className="error-content container mx-auto px-4 text-center">
                        <div className="fade-in-up">
                            <div className="error-number mb-4" style={{ fontFamily: "'Alexandria', sans-serif" }}>
                                404
                            </div>
                            <h1 className="text-4xl md:text-5xl font-bold mb-6" style={{
                                fontFamily: "'Alexandria', sans-serif",
                                color: '#545759',
                                letterSpacing: '0.05em'
                            }}>
                                {locale === 'ar' ? 'عذراً، الصفحة غير موجودة' : 'Oops! Page Not Found'}
                            </h1>
                            <p className="text-lg md:text-xl mb-8 max-w-2xl mx-auto" style={{
                                fontFamily: "'Alexandria', sans-serif",
                                fontWeight: 300,
                                color: '#6b7280',
                                lineHeight: '1.8'
                            }}>
                                {locale === 'ar'
                                    ? 'يبدو أن الصفحة التي تبحث عنها غير موجودة. ربما تم نقلها أو حذفها.'
                                    : 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.'}
                            </p>

                            <div className="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                                <Button
                                    asChild
                                    size="lg"
                                    className="px-8 py-6 text-lg"
                                    style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        fontWeight: 500,
                                        background: 'linear-gradient(135deg, #e72177, #862b90)',
                                        border: 'none',
                                        boxShadow: '0 5px 20px rgba(231, 33, 119, 0.3)',
                                        transition: 'all 0.3s ease'
                                    }}
                                    onMouseEnter={(e) => {
                                        e.currentTarget.style.boxShadow = '0 8px 30px rgba(231, 33, 119, 0.4)';
                                        e.currentTarget.style.transform = 'translateY(-2px)';
                                    }}
                                    onMouseLeave={(e) => {
                                        e.currentTarget.style.boxShadow = '0 5px 20px rgba(231, 33, 119, 0.3)';
                                        e.currentTarget.style.transform = 'translateY(0)';
                                    }}
                                >
                                    <Link href="/" className="flex items-center gap-2">
                                        <Home className="h-5 w-5" />
                                        {locale === 'ar' ? 'العودة للصفحة الرئيسية' : 'Back to Home'}
                                    </Link>
                                </Button>

                                <Button
                                    asChild
                                    variant="outline"
                                    size="lg"
                                    className="px-8 py-6 text-lg"
                                    style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        fontWeight: 500,
                                        borderColor: '#e72177',
                                        color: '#e72177',
                                        transition: 'all 0.3s ease'
                                    }}
                                    onMouseEnter={(e) => {
                                        e.currentTarget.style.backgroundColor = 'rgba(231, 33, 119, 0.1)';
                                        e.currentTarget.style.transform = 'translateY(-2px)';
                                    }}
                                    onMouseLeave={(e) => {
                                        e.currentTarget.style.backgroundColor = 'transparent';
                                        e.currentTarget.style.transform = 'translateY(0)';
                                    }}
                                >
                                    <Link href="/products" className="flex items-center gap-2">
                                        <Search className="h-5 w-5" />
                                        {locale === 'ar' ? 'تصفح المنتجات' : 'Browse Products'}
                                    </Link>
                                </Button>
                            </div>

                            <div className="mt-16 pt-8 border-t border-gray-200">
                                <p className="text-sm text-gray-500 mb-4" style={{ fontFamily: "'Alexandria', sans-serif" }}>
                                    {locale === 'ar' ? 'أو جرب هذه الروابط المفيدة:' : 'Or try these helpful links:'}
                                </p>
                                <div className="flex flex-wrap justify-center gap-4">
                                    <Link
                                        href="/products"
                                        className="text-[#e72177] hover:text-[#862b90] transition-colors text-sm"
                                        style={{ fontFamily: "'Alexandria', sans-serif" }}
                                    >
                                        {locale === 'ar' ? 'المنتجات' : 'Products'}
                                    </Link>
                                    <Link
                                        href="/categories"
                                        className="text-[#e72177] hover:text-[#862b90] transition-colors text-sm"
                                        style={{ fontFamily: "'Alexandria', sans-serif" }}
                                    >
                                        {locale === 'ar' ? 'الفئات' : 'Categories'}
                                    </Link>
                                    <Link
                                        href="/about"
                                        className="text-[#e72177] hover:text-[#862b90] transition-colors text-sm"
                                        style={{ fontFamily: "'Alexandria', sans-serif" }}
                                    >
                                        {locale === 'ar' ? 'من نحن' : 'About Us'}
                                    </Link>
                                    <Link
                                        href="/contact"
                                        className="text-[#e72177] hover:text-[#862b90] transition-colors text-sm"
                                        style={{ fontFamily: "'Alexandria', sans-serif" }}
                                    >
                                        {locale === 'ar' ? 'اتصل بنا' : 'Contact'}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <Footer locale={locale} menuItems={menuItems} />
            </div>
        </>
    );
}
