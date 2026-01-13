<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Announcement;
use App\Models\Welcome;
use App\Models\WelcomeDetail;
use App\Models\Hero;
use App\Models\Parallax;

class HomeController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::first();
        // dd($settings);

        $categories = Category::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->with('translations')
            ->take(3)
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
            });

        // Fix announcements query - properly group conditions
        $announcements = Announcement::where('is_active', true)
            ->where(function ($query) {
                $query->where('start_date', '<=', now())
                    ->orWhereNull('start_date');
            })
            ->where(function ($query) {
                $query->where('end_date', '>=', now())
                    ->orWhereNull('end_date');
            })
            ->with('translations')
            ->orderBy('created_at', 'desc')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['translations', 'category.translations', 'media'])
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        // Get welcome with translations
        $welcome = Welcome::where('is_active', true)
            ->with('translations')
            ->first();

        // Get welcome details with translations if welcome exists
        $welcomeDetails = collect([]);
        if ($welcome) {
            $welcomeDetails = WelcomeDetail::where('welcome_id', $welcome->id)
                ->with('translations')
                ->orderBy('id')
                ->get();
        }

        // Get active heroes with translations
        $heros = Hero::where('is_active', true)
            ->with('translations')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active parallax with translations
        $parallax = Parallax::where('is_active', true)
            ->with('translations')
            ->orderBy('created_at', 'desc')
            ->first();

        // Map parallax data with image_url
        $parallaxData = null;
        if ($parallax) {
            $parallaxData = [
                'id' => $parallax->id,
                'image' => $parallax->image,
                'image_url' => $parallax->image_url,
                'link' => $parallax->link,
                'translations' => $parallax->translations->map(function ($translation) {
                    return [
                        'locale' => $translation->locale,
                        'title' => $translation->title,
                        'description' => $translation->description,
                    ];
                })->toArray(),
            ];
        }

        // Prepare settings data with translations and image URLs
        // Note: Settings are already shared globally via HandleInertiaRequests middleware
        // We just need to add the meta-specific fields for the Home page
        $settingsData = null;
        if ($settings) {
            $locale = app()->getLocale() ?: Session::get('locale', 'ar');
            
            // Get default meta image URL
            $defaultMetaImageUrl = null;
            if ($settings->default_meta_image) {
                if (Storage::disk('public')->exists($settings->default_meta_image)) {
                    $defaultMetaImageUrl = Storage::disk('public')->url($settings->default_meta_image);
                }
            }
            
            // Use the same structure as HandleInertiaRequests but add meta fields
            $settingsData = [
                'id' => $settings->id,
                'logo_header_path' => $settings->logo_header_path,
                'header_logo_url' => $settings->header_logo_url,
                'logo_footer_path' => $settings->logo_footer_path,
                'footer_logo_url' => $settings->footer_logo_url,
                'favicon_path' => $settings->favicon_path,
                'favicon_url' => $settings->favicon_url,
                'default_meta_image' => $settings->default_meta_image,
                'default_meta_image_url' => $defaultMetaImageUrl,
                // Keep translations as array to match HandleInertiaRequests structure
                'translations' => $settings->translations->map(function ($translation) {
                    return [
                        'locale' => $translation->locale,
                        'site_name' => $translation->site_name,
                        'slogan' => $translation->slogan,
                        'footer_description' => $translation->footer_description,
                        'footer_copyright' => $translation->footer_copyright,
                        'default_meta_title' => $translation->default_meta_title,
                        'default_meta_description' => $translation->default_meta_description,
                        'default_meta_keywords' => $translation->default_meta_keywords,
                    ];
                })->toArray(),
            ];
        }

        return Inertia::render('Home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'settings' => $settingsData,
            'announcements' => $announcements,
            'welcome' => $welcome,
            'welcomeDetails' => $welcomeDetails,
            'heros' => $heros,
            'parallax' => $parallaxData,
        ]);
    }
}
