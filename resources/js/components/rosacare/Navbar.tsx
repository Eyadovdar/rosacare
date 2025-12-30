import { Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline';
import { useState } from 'react';

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

interface NavbarProps {
    menuItems: MenuItem[];
    locale?: string;
}

export function Navbar({ menuItems = [], locale = 'ar' }: NavbarProps) {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const isRTL = locale === 'ar';

    const toggleMobileMenu = () => {
        setMobileMenuOpen(!mobileMenuOpen);
    };

    const getMenuItemUrl = (item: MenuItem): string => {
        if (item.type === 'category' && item.category) {
            return `/categories/${item.category.slug}`;
        }
        if (item.type === 'page' || item.page) {
            const pageMap: Record<string, string> = {
                'home': '/',
                'Home': '/',
                'about': '/about',
                'contact': '/contact',
                'products': '/products',
                'product': '/products',
            };
            const pageKey = item.page || '';
            return pageMap[pageKey] || item.url || '/';
        }
        return item.url || '/';
    };

    const getMenuItemLabel = (item: MenuItem): string => {
        // First try to get label from translations
        if (item.translations && Array.isArray(item.translations) && item.translations.length > 0) {
            const translation = item.translations.find(t => t && t.locale === locale) || item.translations[0];
            if (translation?.label && translation.label.trim() !== '') {
                return translation.label;
            }
        }

        // Fallback: generate label from page type or URL
        if (item.page) {
            const pageLabelMap: Record<string, Record<string, string>> = {
                'home': { ar: 'الرئيسية', en: 'Home' },
                'Home': { ar: 'الرئيسية', en: 'Home' },
                'products': { ar: 'المنتجات', en: 'Products' },
                'product': { ar: 'المنتجات', en: 'Products' },
                'about': { ar: 'من نحن', en: 'About' },
                'contact': { ar: 'اتصل بنا', en: 'Contact' },
            };
            const pageKey = item.page;
            if (pageLabelMap[pageKey]) {
                return pageLabelMap[pageKey][locale] || pageLabelMap[pageKey]['en'] || pageKey;
            }
            return pageKey;
        }

        // Last fallback: use URL or type
        if (item.url) {
            return item.url;
        }

        return item.type || '';
    };

    // Filter and sort menuItems
    const activeMenuItems = (Array.isArray(menuItems) ? menuItems : [])
        .filter(item => {
            // Filter out null/undefined items
            if (!item) return false;
            // Filter out inactive items
            if (item.is_active !== true) return false;
            // All active items are included - label fallback handles missing translations
            // Filter out items that don't have a valid label (after fallback logic)
            const label = getMenuItemLabel(item);
            return label && label.trim() !== '';
        })
        .sort((a, b) => (a.sort_order ?? 0) - (b.sort_order ?? 0));

    const handleNavigation = (item: MenuItem) => {
        if (item.open_in_new_tab) {
            window.open(getMenuItemUrl(item), '_blank');
        } else {
            router.visit(getMenuItemUrl(item));
        }
        setMobileMenuOpen(false);
    };

    return (
        <nav className="sticky top-0 z-50 w-full bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 border-b border-border">
            <div className="container mx-auto px-4">
                <div className={`flex items-center justify-between h-16 ${isRTL ? 'flex-row-reverse' : ''}`}>
                    {/* Logo */}
                    <Link href="/" className="flex items-center space-x-2">
                        <span className="text-2xl font-bold text-primary">RosaCare</span>
                    </Link>

                    {/* Desktop Menu */}
                    <div className="hidden md:flex items-center space-x-1">
                        {activeMenuItems.map((item) => (
                                <Button
                                    key={item.id}
                                    variant="ghost"
                                    asChild
                                    className="mx-1"
                                >
                                    {item.open_in_new_tab ? (
                                        <a
                                            href={getMenuItemUrl(item)}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            {getMenuItemLabel(item)}
                                        </a>
                                    ) : (
                                        <Link href={getMenuItemUrl(item)}>
                                            {getMenuItemLabel(item)}
                                        </Link>
                                    )}
                                </Button>
                            ))}
                    </div>

                    {/* Mobile Menu Button */}
                    <button
                        onClick={toggleMobileMenu}
                        className="md:hidden p-2 rounded-md text-foreground hover:bg-secondary"
                        aria-label="Toggle menu"
                    >
                        {mobileMenuOpen ? (
                            <XMarkIcon className="h-6 w-6" />
                        ) : (
                            <Bars3Icon className="h-6 w-6" />
                        )}
                    </button>
                </div>

                {/* Mobile Menu */}
                {mobileMenuOpen && (
                    <div className={`md:hidden py-4 border-t border-border ${isRTL ? 'rtl' : 'ltr'}`}>
                        <div className="flex flex-col space-y-1">
                            {activeMenuItems.map((item) => (
                                    <button
                                        key={item.id}
                                        onClick={() => handleNavigation(item)}
                                        className="px-4 py-2 text-left hover:bg-secondary rounded-md transition-colors"
                                    >
                                        {getMenuItemLabel(item)}
                                    </button>
                                ))}
                        </div>
                    </div>
                )}
            </div>
        </nav>
    );
}
