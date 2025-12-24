import React from 'react';

interface ContentBlock {
    type: string;
    data: Record<string, any>;
}

interface PageBlockRendererProps {
    block: ContentBlock;
    locale: string;
}

// Paragraph Block
function ParagraphBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.text) return null;

    return (
        <section className="py-12 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <div
                        className="prose prose-lg max-w-none"
                        dangerouslySetInnerHTML={{ __html: data.text }}
                    />
                </div>
            </div>
        </section>
    );
}

// Subheading Block
function SubheadingBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.text) return null;

    const HeadingTag = (data.level || 'h2') as keyof JSX.IntrinsicElements;

    return (
        <section className="py-8 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <HeadingTag className="text-3xl md:text-4xl font-bold">
                        {data.text}
                    </HeadingTag>
                </div>
            </div>
        </section>
    );
}

// Page Header Content Block
function PageHeaderContentBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    
    return (
        <section
            className="relative py-20 bg-secondary/30"
            style={
                data.header_background_image_path
                    ? {
                          backgroundImage: `url(${data.header_background_image_path})`,
                          backgroundSize: 'cover',
                          backgroundPosition: 'center',
                      }
                    : undefined
            }
        >
            {data.header_background_image_path && (
                <div className="absolute inset-0 bg-black/40" />
            )}
            <div className="container mx-auto px-4 relative z-10">
                <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    {data.header_title && (
                        <h1 className="text-5xl md:text-6xl font-bold mb-4 text-white drop-shadow-lg">
                            {data.header_title}
                        </h1>
                    )}
                    {data.header_description && (
                        <p className="text-xl text-white/90 drop-shadow-md">
                            {data.header_description}
                        </p>
                    )}
                </div>
            </div>
        </section>
    );
}

// Company Benefits Section Block
function CompanyBenefitsSectionBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.section_title || !data.benefits_list) return null;

    return (
        <section className="py-20 bg-secondary/30">
            <div className="container mx-auto px-4">
                <div className={`max-w-6xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <div className="text-center mb-12">
                        <h2 className="text-4xl md:text-5xl font-bold mb-4">
                            {data.section_title}
                        </h2>
                        {data.section_description && (
                            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
                                {data.section_description}
                            </p>
                        )}
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {data.benefits_list.map((benefit: any, index: number) => (
                            <div
                                key={index}
                                className="bg-background p-6 rounded-lg shadow-sm border border-border"
                            >
                                {benefit.icon_name && (
                                    <div className="text-4xl mb-4">📦</div>
                                )}
                                {benefit.title && (
                                    <h3 className="text-xl font-bold mb-2">{benefit.title}</h3>
                                )}
                                {benefit.description && (
                                    <p className="text-muted-foreground">{benefit.description}</p>
                                )}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}

// Job Listings Configuration Block
function JobListingsConfigurationBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.section_title) return null;

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-4 text-center">
                        {data.section_title}
                    </h2>
                    {data.section_description && (
                        <p className="text-lg text-muted-foreground text-center mb-8">
                            {data.section_description}
                        </p>
                    )}
                    {data.general_application_button_text && data.general_application_button_url && (
                        <div className="text-center">
                            <a
                                href={data.general_application_button_url}
                                className="inline-block bg-primary text-primary-foreground px-8 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors"
                            >
                                {data.general_application_button_text}
                            </a>
                            {data.general_application_prompt && (
                                <p className="mt-4 text-muted-foreground">
                                    {data.general_application_prompt}
                                </p>
                            )}
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
}

// Intro Section Block
function IntroSectionBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.section_title) return null;

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-4xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-6 text-center">
                        {data.section_title}
                    </h2>
                    {data.section_description && (
                        <p className="text-lg text-muted-foreground text-center leading-relaxed">
                            {data.section_description}
                        </p>
                    )}
                </div>
            </div>
        </section>
    );
}

// Home Hero Block
function HomeHeroBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.title || !data.background_image_path) return null;

    return (
        <section
            className="relative py-32 bg-secondary/30"
            style={{
                backgroundImage: `url(${data.background_image_path})`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
            }}
        >
            <div className="absolute inset-0 bg-black/40" />
            <div className="container mx-auto px-4 relative z-10">
                <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h1 className="text-5xl md:text-6xl font-bold mb-6 text-white drop-shadow-lg">
                        {data.title}
                    </h1>
                    {data.description && (
                        <p className="text-xl text-white/90 mb-8 drop-shadow-md">
                            {data.description}
                        </p>
                    )}
                    <div className="flex gap-4 justify-center flex-wrap">
                        {data.cta1_text && data.cta1_url && (
                            <a
                                href={data.cta1_url}
                                className="bg-primary text-primary-foreground px-8 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors"
                            >
                                {data.cta1_text}
                            </a>
                        )}
                        {data.cta2_text && data.cta2_url && (
                            <a
                                href={data.cta2_url}
                                className="bg-background text-foreground px-8 py-3 rounded-lg font-semibold hover:bg-background/90 transition-colors border border-border"
                            >
                                {data.cta2_text}
                            </a>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

// Home Metrics Bar Block
function HomeMetricsBarBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.metrics_items || data.metrics_items.length === 0) return null;

    return (
        <section className="py-12 bg-primary text-primary-foreground">
            <div className="container mx-auto px-4">
                <div className={`grid grid-cols-2 md:grid-cols-4 gap-8 ${isRTL ? 'rtl' : 'ltr'}`}>
                    {data.metrics_items.map((metric: any, index: number) => (
                        <div key={index} className="text-center">
                            <div className="text-4xl md:text-5xl font-bold mb-2">
                                {metric.value}
                                {metric.unit && <span className="text-2xl">{metric.unit}</span>}
                            </div>
                            {metric.label && (
                                <div className="text-lg opacity-90">{metric.label}</div>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

// Home Company Intro Block
function HomeCompanyIntroBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.section_title) return null;

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-6xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <div className="text-center mb-12">
                        <h2 className="text-4xl md:text-5xl font-bold mb-4">
                            {data.section_title}
                        </h2>
                        {data.section_description && (
                            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
                                {data.section_description}
                            </p>
                        )}
                    </div>
                    {data.key_features_list && data.key_features_list.length > 0 && (
                        <div className="flex flex-wrap gap-2 justify-center mb-12">
                            {data.key_features_list.map((feature: string, index: number) => (
                                <span
                                    key={index}
                                    className="bg-secondary px-4 py-2 rounded-full text-sm"
                                >
                                    {feature}
                                </span>
                            ))}
                        </div>
                    )}
                    {data.intro_metrics_items && data.intro_metrics_items.length > 0 && (
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mt-12">
                            {data.intro_metrics_items.map((metric: any, index: number) => (
                                <div key={index} className="text-center">
                                    <div className="text-3xl md:text-4xl font-bold mb-2">
                                        {metric.value}
                                    </div>
                                    {metric.label && (
                                        <div className="text-muted-foreground">{metric.label}</div>
                                    )}
                                </div>
                            ))}
                        </div>
                    )}
                    {data.learn_more_link_text && data.learn_more_link_url && (
                        <div className="text-center mt-8">
                            <a
                                href={data.learn_more_link_url}
                                className="inline-block bg-primary text-primary-foreground px-8 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors"
                            >
                                {data.learn_more_link_text}
                            </a>
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
}

// Home Sector Grid Block
function HomeSectorGridBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.section_title) return null;

    return (
        <section className="py-20 bg-secondary/30">
            <div className="container mx-auto px-4">
                <div className={`max-w-6xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <div className="text-center mb-12">
                        <h2 className="text-4xl md:text-5xl font-bold mb-4">
                            {data.section_title}
                        </h2>
                        {data.section_description && (
                            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
                                {data.section_description}
                            </p>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

// Home Featured Projects Block
function HomeFeaturedProjectsBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.section_title) return null;

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-6xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <div className="text-center mb-12">
                        <h2 className="text-4xl md:text-5xl font-bold mb-4">
                            {data.section_title}
                        </h2>
                        {data.section_description && (
                            <p className="text-lg text-muted-foreground max-w-3xl mx-auto">
                                {data.section_description}
                            </p>
                        )}
                    </div>
                    {data.view_all_text && data.view_all_url && (
                        <div className="text-center mt-8">
                            <a
                                href={data.view_all_url}
                                className="inline-block text-primary hover:underline font-semibold"
                            >
                                {data.view_all_text} →
                            </a>
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
}

// Home Call to Action Block
function HomeCallToActionBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.title) return null;

    return (
        <section
            className="relative py-20 bg-secondary/30"
            style={
                data.background_image_path
                    ? {
                          backgroundImage: `url(${data.background_image_path})`,
                          backgroundSize: 'cover',
                          backgroundPosition: 'center',
                      }
                    : undefined
            }
        >
            {data.background_image_path && (
                <div className="absolute inset-0 bg-black/40" />
            )}
            <div className="container mx-auto px-4 relative z-10">
                <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-4 text-white drop-shadow-lg">
                        {data.title}
                    </h2>
                    {data.description && (
                        <p className="text-xl text-white/90 mb-8 drop-shadow-md">
                            {data.description}
                        </p>
                    )}
                    <div className="flex gap-4 justify-center flex-wrap">
                        {data.cta1_text && data.cta1_url && (
                            <a
                                href={data.cta1_url}
                                className="bg-primary text-primary-foreground px-8 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors"
                            >
                                {data.cta1_text}
                            </a>
                        )}
                        {data.cta2_text && data.cta2_url && (
                            <a
                                href={data.cta2_url}
                                className="bg-background text-foreground px-8 py-3 rounded-lg font-semibold hover:bg-background/90 transition-colors border border-border"
                            >
                                {data.cta2_text}
                            </a>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

// Hero Section Block
function HeroSectionBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.title) return null;

    return (
        <section
            className="relative py-32 bg-secondary/30"
            style={
                data.background_image_path
                    ? {
                          backgroundImage: `url(${data.background_image_path})`,
                          backgroundSize: 'cover',
                          backgroundPosition: 'center',
                      }
                    : undefined
            }
        >
            {data.background_image_path && (
                <div className="absolute inset-0 bg-black/40" />
            )}
            <div className="container mx-auto px-4 relative z-10">
                <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h1 className="text-5xl md:text-6xl font-bold mb-6 text-white drop-shadow-lg">
                        {data.title}
                    </h1>
                    {data.subtitle && (
                        <p className="text-xl text-white/90 drop-shadow-md">
                            {data.subtitle}
                        </p>
                    )}
                </div>
            </div>
        </section>
    );
}

// Company Overview Block
function CompanyOverviewBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.title) return null;

    return (
        <section className="py-20 bg-background">
            <div className="container mx-auto px-4">
                <div className={`max-w-6xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h2 className="text-4xl md:text-5xl font-bold mb-4">
                                {data.title}
                            </h2>
                            {data.subtitle && (
                                <p className="text-xl text-muted-foreground mb-6">
                                    {data.subtitle}
                                </p>
                            )}
                            <div className="space-y-4">
                                {data.paragraph1_html && (
                                    <div
                                        className="prose max-w-none"
                                        dangerouslySetInnerHTML={{ __html: data.paragraph1_html }}
                                    />
                                )}
                                {data.paragraph2_html && (
                                    <div
                                        className="prose max-w-none"
                                        dangerouslySetInnerHTML={{ __html: data.paragraph2_html }}
                                    />
                                )}
                                {data.paragraph3_html && (
                                    <div
                                        className="prose max-w-none"
                                        dangerouslySetInnerHTML={{ __html: data.paragraph3_html }}
                                    />
                                )}
                            </div>
                        </div>
                        {data.image_path && (
                            <div>
                                <img
                                    src={data.image_path}
                                    alt={data.title}
                                    className="w-full h-auto rounded-lg shadow-lg"
                                />
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

// Vision Mission Block
function VisionMissionBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.vision_title || !data.mission_title) return null;

    return (
        <section className="py-20 bg-secondary/30">
            <div className="container mx-auto px-4">
                <div className={`max-w-6xl mx-auto ${isRTL ? 'rtl' : 'ltr'}`}>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
                        {/* Vision */}
                        <div className="bg-background p-8 rounded-lg shadow-sm border border-border">
                            <h3 className="text-3xl font-bold mb-4">{data.vision_title}</h3>
                            {data.vision_html_p1 && (
                                <div
                                    className="prose max-w-none mb-4"
                                    dangerouslySetInnerHTML={{ __html: data.vision_html_p1 }}
                                />
                            )}
                            {data.vision_html_p2 && (
                                <div
                                    className="prose max-w-none"
                                    dangerouslySetInnerHTML={{ __html: data.vision_html_p2 }}
                                />
                            )}
                        </div>
                        {/* Mission */}
                        <div className="bg-background p-8 rounded-lg shadow-sm border border-border">
                            <h3 className="text-3xl font-bold mb-4">{data.mission_title}</h3>
                            {data.mission_html_p1 && (
                                <div
                                    className="prose max-w-none mb-4"
                                    dangerouslySetInnerHTML={{ __html: data.mission_html_p1 }}
                                />
                            )}
                            {data.mission_html_p2 && (
                                <div
                                    className="prose max-w-none"
                                    dangerouslySetInnerHTML={{ __html: data.mission_html_p2 }}
                                />
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

// CTA Section Block
function CTASectionBlock({ data, locale }: { data: any; locale: string }) {
    const isRTL = locale === 'ar';
    if (!data.title || !data.button_text || !data.button_link) return null;

    return (
        <section
            className="relative py-20 bg-secondary/30"
            style={
                data.background_image_path
                    ? {
                          backgroundImage: `url(${data.background_image_path})`,
                          backgroundSize: 'cover',
                          backgroundPosition: 'center',
                      }
                    : undefined
            }
        >
            {data.background_image_path && (
                <div className="absolute inset-0 bg-black/40" />
            )}
            <div className="container mx-auto px-4 relative z-10">
                <div className={`max-w-4xl mx-auto text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                    <h2 className="text-4xl md:text-5xl font-bold mb-4 text-white drop-shadow-lg">
                        {data.title}
                    </h2>
                    {data.paragraph && (
                        <p className="text-xl text-white/90 mb-8 drop-shadow-md">
                            {data.paragraph}
                        </p>
                    )}
                    <a
                        href={data.button_link}
                        className="inline-block bg-primary text-primary-foreground px-8 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors"
                    >
                        {data.button_text}
                    </a>
                </div>
            </div>
        </section>
    );
}

// Main Block Renderer Component
export function PageBlockRenderer({ block, locale }: PageBlockRendererProps) {
    // Handle both Filament Builder structure (type + data) and direct data structure
    const type = block.type;
    const data = block.data || block;

    if (!type) {
        console.warn('Block missing type:', block);
        return null;
    }

    switch (type) {
        case 'paragraph':
            return <ParagraphBlock data={data} locale={locale} />;
        case 'subheading':
            return <SubheadingBlock data={data} locale={locale} />;
        case 'page_header_content':
            return <PageHeaderContentBlock data={data} locale={locale} />;
        case 'company_benefits_section':
            return <CompanyBenefitsSectionBlock data={data} locale={locale} />;
        case 'job_listings_configuration':
            return <JobListingsConfigurationBlock data={data} locale={locale} />;
        case 'intro_section':
            return <IntroSectionBlock data={data} locale={locale} />;
        case 'home_hero':
            return <HomeHeroBlock data={data} locale={locale} />;
        case 'home_metrics_bar':
            return <HomeMetricsBarBlock data={data} locale={locale} />;
        case 'home_company_intro':
            return <HomeCompanyIntroBlock data={data} locale={locale} />;
        case 'home_sector_grid':
            return <HomeSectorGridBlock data={data} locale={locale} />;
        case 'home_featured_projects':
            return <HomeFeaturedProjectsBlock data={data} locale={locale} />;
        case 'home_call_to_action':
            return <HomeCallToActionBlock data={data} locale={locale} />;
        case 'hero_section':
            return <HeroSectionBlock data={data} locale={locale} />;
        case 'company_overview':
            return <CompanyOverviewBlock data={data} locale={locale} />;
        case 'vision_mission':
            return <VisionMissionBlock data={data} locale={locale} />;
        case 'cta_section':
            return <CTASectionBlock data={data} locale={locale} />;
        default:
            // Unknown block type - render nothing or a placeholder
            console.warn(`Unknown block type: ${type}`);
            return null;
    }
}

