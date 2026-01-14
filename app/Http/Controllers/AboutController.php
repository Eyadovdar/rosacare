<?php

namespace App\Http\Controllers;

use App\Models\About;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        $locale = app()->getLocale() ?: \Illuminate\Support\Facades\Session::get('locale', 'ar');

        // Get the active about record
        $about = About::where('is_active', true)->first();

        if (!$about) {
            // Return empty structure if no about data exists
            return Inertia::render('About', [
                'locale' => $locale,
                'about' => null,
            ]);
        }

        // Prepare about data with translations and image URLs
        $translation = $about->translate($locale);
        $aboutData = [
            'id' => $about->id,
            'story' => [
                'title' => $translation->story_title ?? null,
                'paragraphs' => $translation->story_paragraphs ?? [],
                'content' => $translation->story_content ?? null,
                'image_url' => $about->story_image_url,
                'icon_url' => $about->story_icon_url,
            ],
            'vision' => [
                'title' => $translation->vision_title ?? null,
                'content' => $translation->vision_content ?? null,
                'image_url' => $about->vision_image_url,
                'icon_url' => $about->vision_icon_url,
            ],
            'mission' => [
                'title' => $translation->mission_title ?? null,
                'content' => $translation->mission_content ?? null,
                'image_url' => $about->mission_image_url,
                'icon_url' => $about->mission_icon_url,
            ],
            'heritage' => [
                'title' => $translation->heritage_title ?? null,
                'content' => $translation->heritage_content ?? null,
                'subcontent' => $translation->heritage_subcontent ?? null,
                'image_url' => $about->heritage_image_url,
                'features' => $about->heritage_features_with_urls ?? [],
            ],
            'whyRosaCare' => [
                'title' => $translation->why_rosacare_title ?? null,
                'reasons' => $about->reasons_with_urls ?? [],
                'image_url' => $about->why_rosacare_image_url,
            ],
            'benefits' => [
                'title' => $translation->benefits_title ?? null,
                'items' => $about->benefits_with_urls ?? [],
                'image_url' => $about->benefits_image_url,
            ],
            'meta' => [
                'title' => $about->translate($locale)->meta_title ?? null,
                'description' => $about->translate($locale)->meta_description ?? null,
                'keywords' => $about->translate($locale)->meta_keywords ?? null,
            ],
        ];

        return Inertia::render('About', [
            'locale' => $locale,
            'about' => $aboutData,
        ]);
    }
}
