<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $categories = Category::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->with('translations')
            ->take(3)
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['translations', 'category.translations', 'media'])
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $menuItems = MenuItem::where('is_active', true)
            ->with(['translations', 'category.translations'])
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'menuItems' => $menuItems,
        ]);
    }
}
