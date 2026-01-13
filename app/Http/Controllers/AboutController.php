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
        $aboutData = [
            'id' => $about->id,
            'story' => [
                'title' => $about->translate($locale)->story_title ?? null,
                'content' => $about->translate($locale)->story_content ?? null,
                'image_url' => $about->story_image_url,
            ],
            'vision' => [
                'title' => $about->translate($locale)->vision_title ?? null,
                'content' => $about->translate($locale)->vision_content ?? null,
                'image_url' => $about->vision_image_url,
            ],
            'mission' => [
                'title' => $about->translate($locale)->mission_title ?? null,
                'content' => $about->translate($locale)->mission_content ?? null,
                'image_url' => $about->mission_image_url,
            ],
            'heritage' => [
                'title' => $about->translate($locale)->heritage_title ?? null,
                'content' => $about->translate($locale)->heritage_content ?? null,
                'subcontent' => $about->translate($locale)->heritage_subcontent ?? null,
                'image_url' => $about->heritage_image_url,
                'features' => $about->heritage_features_with_urls ?? [],
            ],
            'whyRosaCare' => [
                'title' => $about->translate($locale)->why_rosacare_title ?? null,
                'reasons' => $about->reasons_with_urls ?? [],
            ],
            'benefits' => [
                'title' => $about->translate($locale)->benefits_title ?? null,
                'items' => $about->benefits_with_urls ?? [],
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
