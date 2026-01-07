<?php

namespace App\Filament\Resources\MenuItems\Pages;

use App\Filament\Resources\MenuItems\MenuItemResource;
use App\Models\Page;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuItem extends CreateRecord
{
    protected static string $resource = MenuItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate URL when type is "page" and a page is selected
        if (isset($data['type']) && $data['type'] === 'page' && isset($data['page'])) {
            // Strip "page:" prefix if present for database storage
            if (str_starts_with($data['page'], 'page:')) {
                $data['page'] = str_replace('page:', '', $data['page']);
            }
            $data['url'] = $this->generateUrlForPage($data['page']);
        }

        return $data;
    }

    /**
     * Generate the URL for a given page selection.
     * 
     * @param string $page The page identifier (home, about, contact, products, page:slug, or a page slug)
     * @return string The generated URL
     */
    protected function generateUrlForPage(string $page): string
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
