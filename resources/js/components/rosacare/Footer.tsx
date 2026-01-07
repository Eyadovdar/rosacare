import { Link } from '@inertiajs/react';

interface FooterProps {
    locale?: string;
}

export function Footer({ locale = 'ar' }: FooterProps) {
    const isRTL = locale === 'ar';
    const currentYear = new Date().getFullYear();

    return (
        <footer className="bg-muted border-t border-border">
            <div className="container mx-auto px-4 py-12">
                <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div className={isRTL ? 'rtl' : 'ltr'}>
                        <h3 className="text-2xl font-bold mb-4">RosaCare</h3>
                        <p className="text-muted-foreground">
                            {locale === 'ar'
                                ? 'منتجات الوردة الشامية الأصيلة من قلب سوريا'
                                : 'Authentic Damask Rose products from the heart of Syria'}
                        </p>
                    </div>
                    <div className={isRTL ? 'rtl' : 'ltr'}>
                        <h4 className="font-semibold mb-4">
                            {locale === 'ar' ? 'روابط سريعة' : 'Quick Links'}
                        </h4>
                        <ul className="space-y-2">
                            <li>
                                <Link href="/" className="text-muted-foreground hover:text-foreground">
                                    {locale === 'ar' ? 'الرئيسية' : 'Home'}
                                </Link>
                            </li>
                            <li>
                                <Link href="/products" className="text-muted-foreground hover:text-foreground">
                                    {locale === 'ar' ? 'المنتجات' : 'Products'}
                                </Link>
                            </li>
                            <li>
                                <Link href="/about" className="text-muted-foreground hover:text-foreground">
                                    {locale === 'ar' ? 'من نحن' : 'About Us'}
                                </Link>
                            </li>
                            <li>
                                <Link href="/contact" className="text-muted-foreground hover:text-foreground">
                                    {locale === 'ar' ? 'اتصل بنا' : 'Contact'}
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div className={isRTL ? 'rtl' : 'ltr'}>
                        <h4 className="font-semibold mb-4">
                            {locale === 'ar' ? 'المعلومات' : 'Information'}
                        </h4>
                        <ul className="space-y-2 text-muted-foreground">
                            <li>{locale === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy'}</li>
                            <li>{locale === 'ar' ? 'شروط الاستخدام' : 'Terms of Service'}</li>
                        </ul>
                    </div>
                    <div className={isRTL ? 'rtl' : 'ltr'}>
                        <h4 className="font-semibold mb-4">
                            {locale === 'ar' ? 'تابعنا' : 'Follow Us'}
                        </h4>
                        <div className="flex gap-4">
                            {/* Social media links can be added here */}
                            <span className="text-muted-foreground">
                                {locale === 'ar' ? 'وسائل التواصل الاجتماعي' : 'Social Media'}
                            </span>
                        </div>
                    </div>
                </div>
                <div className={`mt-8 pt-8 border-t border-border text-center text-muted-foreground ${isRTL ? 'rtl' : 'ltr'}`}>
                    <p>
                        &copy; {currentYear} RosaCare. {locale === 'ar' ? 'جميع الحقوق محفوظة' : 'All rights reserved'}.
                    </p>
                </div>
            </div>
        </footer>
    );
}
