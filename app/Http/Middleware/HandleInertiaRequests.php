<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Setting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        // Get settings with translations
        $settings = null;
        if (Schema::hasTable('settings')) {
            $settingsModel = Setting::with('translations')->first();
            if ($settingsModel) {
                $settings = [
                    'id' => $settingsModel->id,
                    'logo_header_path' => $settingsModel->logo_header_path,
                    'logo_footer_path' => $settingsModel->logo_footer_path,
                    'favicon_path' => $settingsModel->favicon_path,
                    'header_logo_url' => $settingsModel->header_logo_url,
                    'footer_logo_url' => $settingsModel->footer_logo_url,
                    'favicon_url' => $settingsModel->favicon_url,
                    'phone_number' => $settingsModel->phone_number,
                    'email' => $settingsModel->email,
                    'address' => $settingsModel->address,
                    'facebook' => $settingsModel->facebook,
                    'twitter' => $settingsModel->twitter,
                    'instagram' => $settingsModel->instagram,
                    'linkedin' => $settingsModel->linkedin,
                    'youtube' => $settingsModel->youtube,
                    'tiktok' => $settingsModel->tiktok,
                    'translations' => $settingsModel->translations->map(function ($translation) {
                        return [
                            'locale' => $translation->locale,
                            'site_name' => $translation->site_name,
                            'slogan' => $translation->slogan,
                            'footer_description' => $translation->footer_description,
                            'footer_copyright' => $translation->footer_copyright,
                        ];
                    })->toArray(),
                ];
            }
        }

        // Get all active categories for submenu
        $categories = [];
        if (Schema::hasTable('categories')) {
            $categories = Category::where('is_active', true)
                ->with('translations')
                ->orderBy('sort_order')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'slug' => $category->slug,
                        'icon' => $category->icon,
                        'image' => $category->image,
                        'image_url' => $category->image_url,
                        'translations' => $category->translations->map(function ($translation) {
                            return [
                                'locale' => $translation->locale,
                                'name' => $translation->name,
                                'description' => $translation->description,
                            ];
                        })->toArray(),
                    ];
                })
                ->toArray();
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'locale' => app()->getLocale(),
            'supportedLocales' => ['ar', 'en'],
            'settings' => $settings,
            'categories' => $categories,
            'menuItems' => Schema::hasTable('menu_items')
                ? MenuItem::where('is_active', true)
                    ->with(['translations', 'category.translations'])
                    ->orderBy('sort_order')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'type' => $item->type,
                            'url' => $item->url,
                            'icon' => $item->icon,
                            'category_id' => $item->category_id,
                            'page' => $item->page,
                            'open_in_new_tab' => $item->open_in_new_tab,
                            'sort_order' => $item->sort_order,
                            'is_active' => $item->is_active,
                            'translations' => $item->translations->map(function ($translation) {
                                return [
                                    'locale' => $translation->locale,
                                    'label' => $translation->label,
                                ];
                            })->toArray(),
                            'category' => $item->category ? [
                                'slug' => $item->category->slug,
                                'translations' => $item->category->translations->map(function ($translation) {
                                    return [
                                        'locale' => $translation->locale,
                                        'name' => $translation->name,
                                    ];
                                })->toArray(),
                            ] : null,
                        ];
                    })
                    ->values()
                    ->toArray()
                : [],
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
