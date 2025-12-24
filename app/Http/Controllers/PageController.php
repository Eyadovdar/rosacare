<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Display a page by slug
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug, Request $request): Response
    {
        $page = Page::where('slug', $slug)
            ->where('published', true)
            ->with('translations')
            ->firstOrFail();

        // Get the locale from the request or default to 'ar'
        $locale = $request->get('locale') ?? app()->getLocale();

        // Get content blocks for the specific locale
        $contentBlocks = $page->getContentForLocale($locale);

        // Or specifically get Arabic content:
        // $contentBlocks = $page->getArabicContent();

        // Get the translation for the current locale
        $translation = $page->translate($locale);

        return Inertia::render('Pages/Show', [
            'page' => [
                'id' => $page->id,
                'slug' => $page->slug,
                'header_image_path' => $page->header_image_path,
                'published' => $page->published,
                'title' => $translation?->title,
                'content_blocks' => $contentBlocks,
                'meta_title' => $translation?->meta_title,
                'meta_description' => $translation?->meta_description,
                'meta_keywords' => $translation?->meta_keywords,
            ],
            'locale' => $locale,
        ]);
    }

    /**
     * Example: Get Arabic content only
     *
     * @param string $slug
     * @return Response
     */
    public function showArabic(string $slug): Response
    {
        $page = Page::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        // Get Arabic content blocks specifically
        $arabicContent = $page->getArabicContent();

        $translation = $page->translate('ar');

        return Inertia::render('Pages/Show', [
            'page' => [
                'id' => $page->id,
                'slug' => $page->slug,
                'header_image_path' => $page->header_image_path,
                'title' => $translation?->title,
                'content_blocks' => $arabicContent,
                'meta_title' => $translation?->meta_title,
                'meta_description' => $translation?->meta_description,
            ],
            'locale' => 'ar',
        ]);
    }
}
