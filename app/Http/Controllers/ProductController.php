<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::where('is_active', true)
            ->with(['translations', 'category.translations', 'media']);

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('is_active', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->category,
        ]);
    }

    public function show(string $slug): Response
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['translations', 'category.translations', 'media'])
            ->firstOrFail();

        $product->incrementViewCount();

        // Get related products from the same category
        // Order by: featured first, then sort_order, then created_at
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['translations', 'category.translations', 'media'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return Inertia::render('Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
