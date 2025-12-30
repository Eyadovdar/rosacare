<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use App\Models\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Route;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Type')
                    ->required()
                    ->options([
                        'home' => 'Home',
                        'page' => 'Page',
                    ])
                    ->default('home')
                    ->native(false)
                    ->reactive(),
                Select::make('page')
                    ->label('Page')
                    ->options(function () {
                        // Static pages
                        $staticPages = [
                            'home' => '🏠 Home',
                            'about' => '📄 About',
                            'contact' => '📧 Contact',
                            'products' => '🛍️ Products',
                        ];
                        
                        // Dynamic pages from database
                        $dynamicPages = Page::where('published', true)
                            ->with('translations')
                            ->get()
                            ->mapWithKeys(function ($page) {
                                $title = $page->translate('en')?->title ?? $page->translate('ar')?->title ?? $page->slug;
                                return ["page:{$page->slug}" => "📑 {$title} ({$page->slug})"];
                            })
                            ->toArray();
                        
                        // Combine static and dynamic pages
                        return array_merge($staticPages, $dynamicPages);
                    })
                    ->required(fn ($get) => $get('type') === 'page')
                    ->visible(fn ($get) => $get('type') === 'page')
                    ->default('home')
                    ->native(false)
                    ->searchable()
                    ->reactive()
                    ->dehydrateStateUsing(function ($state) {
                        // Strip "page:" prefix when saving to database
                        if (str_starts_with($state, 'page:')) {
                            return str_replace('page:', '', $state);
                        }
                        return $state;
                    })
                    ->afterStateHydrated(function ($state, $set) {
                        // Add "page:" prefix for display if it's a dynamic page
                        if ($state && !in_array($state, ['home', 'about', 'contact', 'products'])) {
                            // Check if it's a published page in the database
                            $pageModel = Page::where('slug', $state)
                                ->where('published', true)
                                ->first();
                            if ($pageModel) {
                                $set('page', "page:{$state}");
                            }
                        }
                    })
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Auto-generate URL when page is selected
                        if ($get('type') === 'page' && $state) {
                            $pageValue = str_starts_with($state, 'page:') 
                                ? str_replace('page:', '', $state) 
                                : $state;
                            $url = self::generateUrlForPage($pageValue);
                            $set('url', $url);
                        }
                    }),
                TextInput::make('url')
                    ->label('URL')
                    ->helperText(fn ($get) => $get('type') === 'page' 
                        ? 'URL is automatically generated based on the selected page. You can override it manually if needed.'
                        : 'Custom URL (optional, used as fallback)')
                    ->dehydrated()
                    ->default(null),
                Select::make('icon')
                    ->label('Icon')
                    ->options(self::getHeroiconOptions())
                    ->searchable()
                    ->preload()
                    ->getOptionLabelUsing(fn (string $value): string => self::getHeroiconOptionLabel($value))
                    ->nullable(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'title')
                    ->default(null)
                    ->helperText('Only used for category-type menu items')
                    ->visible(false), // Hidden since we only support home and page types now
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('open_in_new_tab')
                    ->required(),
            ]);
    }

    /**
     * Get all available Heroicon options with their names.
     *
     * @return array<string, string>
     */
    protected static function getHeroiconOptions(): array
    {
        $options = [];

        foreach (Heroicon::cases() as $icon) {
            $value = $icon->value;
            $options[$value] = $value;
        }

        // Sort alphabetically by value
        asort($options);

        return $options;
    }

    /**
     * Get the label for a Heroicon option with icon display.
     *
     * @return string HTML string with icon and name
     */
    protected static function getHeroiconOptionLabel(string $value): string
    {
        return view('filament.forms.components.icon-option', ['value' => $value])->render();
    }

    /**
     * Generate the URL for a given page selection.
     * 
     * @param string $page The page identifier (home, about, contact, products, or a page slug)
     * @return string The generated URL
     */
    protected static function generateUrlForPage(string $page): string
    {
        // Handle dynamic pages prefixed with "page:"
        if (str_starts_with($page, 'page:')) {
            $slug = str_replace('page:', '', $page);
            return route('pages.show', ['slug' => $slug]);
        }

        // Map static pages to their routes
        $staticPages = [
            'home' => '/',
            'about' => '/about',
            'contact' => '/contact',
            'products' => '/products',
        ];

        // Check if it's a static page
        if (isset($staticPages[$page])) {
            return $staticPages[$page];
        }

        // Fallback: treat as page slug and generate /pages/{slug} route
        return route('pages.show', ['slug' => $page]);
    }
}
