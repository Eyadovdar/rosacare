<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class PositionController extends Controller
{
    public function index(): Response
    {
        $locale = app()->getLocale() ?: Session::get('locale', 'ar');

        $positions = Position::where('is_active', true)
            ->with('translations')
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function ($position) use ($locale) {
                $translation = $position->translate($locale) ?? $position->translate('en') ?? $position->translations->first();
                
                return [
                    'id' => $position->id,
                    'image' => $position->image,
                    'image_url' => $position->image_url,
                    'button_url' => $position->button_url,
                    'button_color' => $position->button_color,
                    'button_text_color' => $position->button_text_color,
                    'name' => $translation?->name ?? '',
                    'description' => $translation?->description ?? '',
                    'qualifications' => $translation?->qualifications ?? '',
                    'responsibilities' => $translation?->responsibilities ?? '',
                    'button_text' => $translation?->button_text ?? '',
                ];
            });

        return Inertia::render('Positions/Index', [
            'positions' => $positions,
            'locale' => $locale,
        ]);
    }
}

