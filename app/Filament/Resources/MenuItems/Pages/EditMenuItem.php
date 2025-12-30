<?php

namespace App\Filament\Resources\MenuItems\Pages;

use App\Filament\Resources\MenuItems\MenuItemResource;
use App\Models\Page;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditMenuItem extends EditRecord
{
    protected static string $resource = MenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-generate URL when type is "page" and a page is selected
        // Only update if URL is not manually set or if page changed
        if (isset($data['type']) && $data['type'] === 'page' && isset($data['page'])) {
            // Strip "page:" prefix if present for database storage
            $originalPageValue = $data['page'];
            if (str_starts_with($data['page'], 'page:')) {
                $data['page'] = str_replace('page:', '', $data['page']);
            }
            
            // Get current record's page value to check if it changed
            $currentPage = $this->record->page;
            
            // If page changed or URL is empty/null, auto-generate URL
            if ($currentPage !== $data['page'] || empty($data['url']) || !isset($data['url'])) {
                $data['url'] = $this->generateUrlForPage($data['page']);
            }
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
