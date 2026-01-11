<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
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

        return Inertia::render('Home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'settings' => $settings,
            'announcements' => $announcements,
            'welcome' => $welcome,
            'welcomeDetails' => $welcomeDetails,
            'heros' => $heros,
            'parallax' => $parallaxData,
        ]);
    }
}
