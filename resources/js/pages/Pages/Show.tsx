import { Head, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { PageBlockRenderer } from '@/components/rosacare/PageBlockRenderer';

interface ContentBlock {
    type: string;
    data: Record<string, any>;
}

interface Page {
    id: number;
    slug: string;
    header_image_path?: string | null;
    published: boolean;
    title?: string | null;
    content_blocks?: ContentBlock[];
    meta_title?: string | null;
    meta_description?: string | null;
    meta_keywords?: string[] | null;
}

interface NavigationMenuItem {
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

interface PagesShowProps {
    page: Page;
    locale?: string;
}

export default function PagesShow({ page, locale = 'ar' }: PagesShowProps) {
    const isRTL = locale === 'ar';
    const pageProps = usePage<any>();
    // Get menuItems from shared props (HandleInertiaRequests middleware)
    const menuItems = (pageProps.props.menuItems || []) as NavigationMenuItem[];

    // Generate page title with fallback
    const pageTitle = page.meta_title || page.title || 'RosaCare';
    const pageDescription = page.meta_description || '';

    return (
        <>
            <Head>
                <title>{pageTitle}</title>
                {pageDescription && <meta name="description" content={pageDescription} />}
                {page.meta_keywords && page.meta_keywords.length > 0 && (
                    <meta name="keywords" content={page.meta_keywords.join(', ')} />
                )}
            </Head>
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />

                {/* Page Header */}
                {(page.header_image_path || page.title) && (
                    <section 
                        className="relative py-20 bg-secondary/30"
                        style={
                            page.header_image_path
                                ? {
                                      backgroundImage: `url(${page.header_image_path})`,
                                      backgroundSize: 'cover',
                                      backgroundPosition: 'center',
                                  }
                                : undefined
                        }
                    >
                        {page.header_image_path && (
                            <div className="absolute inset-0 bg-black/40" />
                        )}
                        <div className="container mx-auto px-4 relative z-10">
                            <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                                <h1 className="text-5xl md:text-6xl font-bold mb-4 text-white drop-shadow-lg">
                                    {page.title}
                                </h1>
                            </div>
                        </div>
                    </section>
                )}

                {/* Content Blocks - Render in order */}
                {page.content_blocks && Array.isArray(page.content_blocks) && page.content_blocks.length > 0 ? (
                    <div className="bg-background">
                        {page.content_blocks.map((block, index) => (
                            <PageBlockRenderer
                                key={`block-${index}-${block.type || 'unknown'}`}
                                block={block}
                                locale={locale}
                            />
                        ))}
                    </div>
                ) : (
                    <section className="py-20 bg-background">
                        <div className="container mx-auto px-4">
                            <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                                <p className="text-lg text-muted-foreground">
                                    {locale === 'ar' ? 'لا يوجد محتوى متاح' : 'No content available'}
                                </p>
                            </div>
                        </div>
                    </section>
                )}

                <Footer locale={locale} />
            </div>
        </>
    );
}

