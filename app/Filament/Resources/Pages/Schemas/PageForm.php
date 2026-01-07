<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms as Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PageForm
{
    /**
     * Get all available content blocks for the Builder.
     * This ensures both Arabic and English tabs have the same blocks.
     */
    protected static function getContentBlocks(): array
    {
        return [
            // Standard Reusable Blocks
            Builder\Block::make('paragraph')
                ->label('Paragraph')
                ->icon('heroicon-o-bars-3-bottom-left')
                ->schema([
                    Forms\Components\RichEditor::make('text')
                        ->label('Text Content')
                        ->helperText('This content will be saved for the current locale.')
                        ->required()
                        ->columnSpanFull(),
                ]),
            Builder\Block::make('subheading')
                ->label('Subheading')
                ->icon('heroicon-o-chevron-double-down')
                ->schema([
                    Forms\Components\TextInput::make('text')
                        ->label('Subheading Text')
                        ->helperText('Text content is locale-specific.')
                        ->required(),
                    Forms\Components\Select::make('level')
                        ->label('Heading Level')
                        ->options(['h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'])
                        ->default('h2')
                        ->required(),
                ]),
            Builder\Block::make('page_header_content')
                ->label('Page Header (for this page)')
                ->icon('heroicon-o-photo')
                ->schema([
                    Forms\Components\TextInput::make('header_title')
                        ->label('Header Title')
                        ->helperText('Optional. Overrides main page title if set. Text is locale-specific.'),
                    Forms\Components\Textarea::make('header_description')
                        ->label('Header Description')
                        ->helperText('Locale-specific description text.')
                        ->rows(3),
                    Forms\Components\FileUpload::make('header_background_image_path')
                        ->label('Header Background Image')
                        ->helperText('Image is shared across all locales.')
                        ->image()
                        ->directory('pages/page_headers')
                        ->visibility('public'),
                ]),
            Builder\Block::make('company_benefits_section')
                ->label('Company Benefits Section')
                ->icon('heroicon-o-gift')
                ->schema([
                    Forms\Components\TextInput::make('section_title')
                        ->label('Section Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('section_description')
                        ->label('Section Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(3),
                    Forms\Components\Repeater::make('benefits_list')
                        ->label('Benefits')
                        ->schema([
                            Forms\Components\TextInput::make('icon_name')
                                ->label('Icon Name')
                                ->helperText("Icon name (e.g., 'Briefcase', 'Heart'). Shared across locales.")
                                ->required(),
                            Forms\Components\TextInput::make('title')
                                ->label('Benefit Title')
                                ->helperText('Locale-specific title.')
                                ->required(),
                            Forms\Components\Textarea::make('description')
                                ->label('Benefit Description')
                                ->helperText('Locale-specific description.')
                                ->required()
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->grid(2)
                        ->defaultItems(1),
                ]),
            Builder\Block::make('job_listings_configuration')
                ->label('Job Listings Section Configuration')
                ->icon('heroicon-o-list-bullet')
                ->schema([
                    Forms\Components\TextInput::make('section_title')
                        ->label('Section Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('section_description')
                        ->label('Section Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(3),
                    Forms\Components\TextInput::make('general_application_prompt')
                        ->label('General Application Prompt')
                        ->helperText('Locale-specific prompt text.'),
                    Forms\Components\TextInput::make('general_application_button_text')
                        ->label('General Application Button Text')
                        ->helperText('Locale-specific button text.'),
                    Forms\Components\TextInput::make('general_application_button_url')
                        ->label('General Application Button URL')
                        ->helperText('URL or mailto: link (shared across locales).')
                        ->url(),
                ]),
            Builder\Block::make('intro_section')
                ->label('Intro Section with Title')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->schema([
                    Forms\Components\TextInput::make('section_title')
                        ->label('Section Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('section_description')
                        ->label('Section Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            // Homepage Specific Blocks (can be reused on other pages too)
            Builder\Block::make('home_hero')
                ->label('Homepage Hero')
                ->icon('heroicon-o-photo')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Hero Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label('Hero Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(3),
                    Forms\Components\FileUpload::make('background_image_path')
                        ->label('Background Image')
                        ->helperText('Image shared across all locales.')
                        ->image()
                        ->directory('pages/home/hero')
                        ->visibility('public')
                        ->required(),
                    Forms\Components\TextInput::make('cta1_text')
                        ->label('Button 1 Text')
                        ->helperText('Locale-specific button text.'),
                    Forms\Components\TextInput::make('cta1_url')
                        ->label('Button 1 URL')
                        ->helperText('URL shared across locales.')
                        ->url(),
                    Forms\Components\TextInput::make('cta2_text')
                        ->label('Button 2 Text')
                        ->helperText('Locale-specific button text.'),
                    Forms\Components\TextInput::make('cta2_url')
                        ->label('Button 2 URL')
                        ->helperText('URL shared across locales.')
                        ->url(),
                ]),
            Builder\Block::make('home_metrics_bar')
                ->label('Metrics Bar')
                ->icon('heroicon-o-chart-bar-square')
                ->schema([
                    Forms\Components\Repeater::make('metrics_items')
                        ->label('Metrics')
                        ->schema([
                            Forms\Components\TextInput::make('value')
                                ->label('Value')
                                ->helperText('Numeric value (shared across locales).')
                                ->numeric()
                                ->required(),
                            Forms\Components\TextInput::make('unit')
                                ->label('Unit')
                                ->helperText('Unit symbol (e.g., GW, kg) - shared across locales.')
                                ->nullable(),
                            Forms\Components\TextInput::make('label')
                                ->label('Label')
                                ->helperText('Locale-specific label text.')
                                ->required(),
                        ])
                        ->columns(3)
                        ->defaultItems(3)
                        ->grid(1),
                ]),
            Builder\Block::make('home_company_intro')
                ->label('Company Introduction Section')
                ->icon('heroicon-o-building-office')
                ->schema([
                    Forms\Components\TextInput::make('section_title')
                        ->label('Section Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('section_description')
                        ->label('Section Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(4),
                    Forms\Components\TagsInput::make('key_features_list')
                        ->label('Key Features')
                        ->helperText('Locale-specific feature tags.'),
                    Forms\Components\TextInput::make('learn_more_link_text')
                        ->label('Learn More Link Text')
                        ->helperText('Locale-specific link text.'),
                    Forms\Components\TextInput::make('learn_more_link_url')
                        ->label('Learn More Link URL')
                        ->helperText('URL shared across locales.')
                        ->url(),
                    Forms\Components\Repeater::make('intro_metrics_items')
                        ->label('Intro Metrics')
                        ->schema([
                            Forms\Components\TextInput::make('value')
                                ->label('Value')
                                ->helperText('Numeric value (shared across locales).')
                                ->numeric()
                                ->required(),
                            Forms\Components\TextInput::make('label')
                                ->label('Label')
                                ->helperText('Locale-specific label text.')
                                ->required(),
                        ])
                        ->columns(2)
                        ->defaultItems(4)
                        ->grid(2),
                ]),
            Builder\Block::make('home_sector_grid')
                ->label('Sector Grid Section')
                ->icon('heroicon-o-squares-2x2')
                ->schema([
                    Forms\Components\TextInput::make('section_title')
                        ->label('Section Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('section_description')
                        ->label('Section Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(3),
                ]),
            Builder\Block::make('home_featured_projects')
                ->label('Featured Projects Section')
                ->icon('heroicon-o-clipboard-document-list')
                ->schema([
                    Forms\Components\TextInput::make('section_title')
                        ->label('Section Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('section_description')
                        ->label('Section Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(3),
                    Forms\Components\TextInput::make('view_all_text')
                        ->label('View All Link Text')
                        ->helperText('Locale-specific link text.'),
                    Forms\Components\TextInput::make('view_all_url')
                        ->label('View All Link URL')
                        ->helperText('URL shared across locales.')
                        ->url(),
                    Forms\Components\TextInput::make('limit')
                        ->label('Number of Projects')
                        ->helperText('Number of featured projects to show (shared across locales).')
                        ->numeric()
                        ->default(3),
                ]),
            Builder\Block::make('home_call_to_action')
                ->label('Call To Action Section')
                ->icon('heroicon-o-megaphone')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('CTA Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label('CTA Description')
                        ->helperText('Locale-specific description.')
                        ->required()
                        ->rows(3),
                    Forms\Components\FileUpload::make('background_image_path')
                        ->label('Background Image')
                        ->helperText('Image shared across all locales.')
                        ->image()
                        ->directory('pages/home/cta')
                        ->visibility('public'),
                    Forms\Components\TextInput::make('cta1_text')
                        ->label('Button 1 Text')
                        ->helperText('Locale-specific button text.'),
                    Forms\Components\TextInput::make('cta1_url')
                        ->label('Button 1 URL')
                        ->helperText('URL shared across locales.')
                        ->url(),
                    Forms\Components\TextInput::make('cta2_text')
                        ->label('Button 2 Text')
                        ->helperText('Locale-specific button text.'),
                    Forms\Components\TextInput::make('cta2_url')
                        ->label('Button 2 URL')
                        ->helperText('URL shared across locales.')
                        ->url(),
                ]),

            // ABOUT PAGE VARIANT BLOCKS
            Builder\Block::make('hero_section')
                ->label('Hero Section')
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Hero Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('subtitle')
                        ->label('Hero Subtitle')
                        ->helperText('Locale-specific subtitle.')
                        ->rows(2),
                    Forms\Components\FileUpload::make('background_image_path')
                        ->label('Background Image')
                        ->helperText('Image shared across all locales.')
                        ->image()
                        ->directory('pages/about/hero')
                        ->visibility('public'),
                ]),
            Builder\Block::make('company_overview')
                ->label('Company Overview')
                ->icon('heroicon-o-building-library')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Section Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\TextInput::make('subtitle')
                        ->label('Section Subtitle')
                        ->helperText('Locale-specific subtitle.'),
                    Forms\Components\RichEditor::make('paragraph1_html')
                        ->label('Paragraph 1')
                        ->helperText('Locale-specific content.')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('paragraph2_html')
                        ->label('Paragraph 2 (Optional)')
                        ->helperText('Locale-specific content.')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('paragraph3_html')
                        ->label('Paragraph 3 (Optional)')
                        ->helperText('Locale-specific content.')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Overview Image')
                        ->helperText('Image shared across all locales.')
                        ->image()
                        ->directory('pages/about/overview')
                        ->visibility('public'),
                ]),
            Builder\Block::make('vision_mission')
                ->label('Vision & Mission')
                ->icon('heroicon-o-light-bulb')
                ->schema([
                    Forms\Components\TextInput::make('vision_title')
                        ->label('Vision Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\RichEditor::make('vision_html_p1')
                        ->label('Vision Content Paragraph 1')
                        ->helperText('Locale-specific content.')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('vision_html_p2')
                        ->label('Vision Content Paragraph 2 (Optional)')
                        ->helperText('Locale-specific content.')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('mission_title')
                        ->label('Mission Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\RichEditor::make('mission_html_p1')
                        ->label('Mission Content Paragraph 1')
                        ->helperText('Locale-specific content.')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('mission_html_p2')
                        ->label('Mission Content Paragraph 2 (Optional)')
                        ->helperText('Locale-specific content.')
                        ->columnSpanFull(),
                ]),
            Builder\Block::make('cta_section')
                ->label('Call to Action')
                ->icon('heroicon-o-megaphone')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('CTA Title')
                        ->helperText('Locale-specific title.')
                        ->required(),
                    Forms\Components\Textarea::make('paragraph')
                        ->label('CTA Paragraph')
                        ->helperText('Locale-specific description.')
                        ->rows(3),
                    Forms\Components\TextInput::make('button_text')
                        ->label('Button Text')
                        ->helperText('Locale-specific button text.')
                        ->required(),
                    Forms\Components\TextInput::make('button_link')
                        ->label('Button Link URL')
                        ->helperText('URL shared across locales.')
                        ->url()
                        ->required(),
                    Forms\Components\FileUpload::make('background_image_path')
                        ->label('Background Image')
                        ->helperText('Image shared across all locales.')
                        ->image()
                        ->directory('pages/about/cta')
                        ->visibility('public'),
                ]),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        FileUpload::make('header_image_path')
                            ->label('Header Image')
                            ->helperText('Header image shared across all locales.')
                            ->image()
                            ->directory('pages/headers')
                            ->visibility('public'),
                        Toggle::make('published')
                            ->label('Published')
                            ->default(false)
                            ->required(),
                    ])
                    ->columns(2),

                // Translation Tabs - Title, Content Builder, and Meta fields
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic (ar)')
                            ->schema([
                                TextInput::make('title:ar')
                                    ->label('Page Title (Arabic)')
                                    ->required()
                                    ->maxLength(255),
                                Builder::make('content:ar')
                                    ->label('Page Content Blocks (Arabic)')
                                    ->helperText('Build your page content blocks. All text fields within blocks are locale-specific.')
                                    ->columnSpanFull()
                                    ->blockPickerColumns(3)
                                    ->blocks(self::getContentBlocks())
                                    ->helperText('Add and arrange content blocks for the Arabic version. Text fields are locale-specific. Images and URLs are shared across all locales.'),
                                TextInput::make('meta_title:ar')
                                    ->label('Meta Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('meta_description:ar')
                                    ->label('Meta Description (Arabic)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('meta_keywords:ar')
                                    ->label('Meta Keywords (Arabic)')
                                    ->maxLength(255),
                            ]),
                        Tab::make('English (en)')
                            ->schema([
                                TextInput::make('title:en')
                                    ->label('Page Title (English)')
                                    ->required()
                                    ->maxLength(255),
                                Builder::make('content:en')
                                    ->label('Page Content Blocks (English)')
                                    ->helperText('Build your page content blocks. All text fields within blocks are locale-specific.')
                                    ->columnSpanFull()
                                    ->blockPickerColumns(3)
                                    ->blocks(self::getContentBlocks())
                                    ->helperText('Add and arrange content blocks for the English version. Text fields are locale-specific. Images and URLs are shared across all locales.'),

                                TextInput::make('meta_title:en')
                                    ->label('Meta Title (English)')
                                    ->maxLength(255),
                                Textarea::make('meta_description:en')
                                    ->label('Meta Description (English)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('meta_keywords:en')
                                    ->label('Meta Keywords (English)')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
