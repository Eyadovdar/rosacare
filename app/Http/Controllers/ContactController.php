<?php

namespace App\Http\Controllers;

use App\Mail\ContactNotification;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::first();
        $locale = app()->getLocale() ?: \Illuminate\Support\Facades\Session::get('locale', 'ar');
        
        // Get FAQs for the current locale
        $faqs = Faq::where('locale', $locale)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($faq) {
                return [
                    'id' => $faq->id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                ];
            });
        
        // Prepare settings data
        $contactInfo = [
            'email' => $settings->email ?? null,
            'phone' => $settings->phone_number ?? null,
            'address' => $settings->address ?? null,
            'googleMapIframe' => $settings->google_map_iframe ?? null,
            'facebook' => $settings->facebook ?? null,
            'twitter' => $settings->twitter ?? null,
            'instagram' => $settings->instagram ?? null,
            'linkedin' => $settings->linkedin ?? null,
            'youtube' => $settings->youtube ?? null,
            'tiktok' => $settings->tiktok ?? null,
        ];
        
        return Inertia::render('Contact', [
            'faqs' => $faqs,
            'contactInfo' => $contactInfo,
            'locale' => $locale,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = Contact::create($validated);

        // Send email notification to the admin email from settings
        $settings = Setting::first();
        if ($settings && $settings->email) {
            try {
                Mail::to($settings->email)->send(new ContactNotification($contact));
            } catch (\Exception $e) {
                // Log the error but don't fail the request
                \Log::error('Failed to send contact notification email', [
                    'error' => $e->getMessage(),
                    'contact_id' => $contact->id,
                ]);
            }
        }

        return Redirect::back()->with('success', __('messages.contact_sent'));
    }
}
