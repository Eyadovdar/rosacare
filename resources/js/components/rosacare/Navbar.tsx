import { Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline';
import { useState } from 'react';

interface NavigationMenuItem {
    id: number;
    type: string;
    url?: string;
    icon?: string;
    page?: string;
    category_id?: number;
    open_in_new_tab: boolean;
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
    menuItems: NavigationMenuItem[];
    locale?: string;
}

export function Navbar({ menuItems, locale = 'ar' }: NavbarProps) {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const isRTL = locale === 'ar';

    const toggleMobileMenu = () => {
        setMobileMenuOpen(!mobileMenuOpen);
    };

    const getMenuItemUrl = (item: NavigationMenuItem): string => {
        if (item.type === 'category' && item.category) {
            return `/categories/${item.category.slug}`;
        }
        if (item.type === 'page') {
            const pageMap: Record<string, string> = {
                'home': '/',
                'about': '/about',
                'contact': '/contact',
                'products': '/products',
            };
            return pageMap[item.page || ''] || '/';
        }
        return item.url || '/';
    };

    const getMenuItemLabel = (item: NavigationMenuItem): string => {
        const translation = item.translations.find(t => t.locale === locale) || item.translations[0];
        return translation?.label || '';
    };

    const handleNavigation = (item: NavigationMenuItem) => {
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
                        {menuItems
                            .filter(item => item.is_active)
                            .sort((a, b) => a.sort_order - b.sort_order)
                            .map((item) => (
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
                            {menuItems
                                .filter(item => item.is_active)
                                .sort((a, b) => a.sort_order - b.sort_order)
                                .map((item) => (
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
