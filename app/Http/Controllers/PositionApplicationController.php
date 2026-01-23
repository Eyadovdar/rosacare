<?php

namespace App\Http\Controllers;

use App\Mail\PositionApplicationNotification;
use App\Models\Position;
use App\Models\PositionApplication;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PositionApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'experience' => 'required|string|max:5000',
            'qualifications' => 'required|string|max:5000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        // Check if position exists and is active
        $position = Position::where('id', $validated['position_id'])
            ->where('is_active', true)
            ->first();

        if (!$position) {
            throw ValidationException::withMessages([
                'position_id' => ['The selected position is not available.'],
            ]);
        }

        // Store the CV file
        $cvFile = $request->file('cv');
        $cvPath = $cvFile->store('position-applications/cvs', 'public');
        $cvFilename = $cvFile->getClientOriginalName();

        // Create the application
        $application = PositionApplication::create([
            'position_id' => $validated['position_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'experience' => $validated['experience'],
            'qualifications' => $validated['qualifications'],
            'cv_path' => $cvPath,
            'cv_filename' => $cvFilename,
        ]);

        // Send email notification to HR
        $settings = Setting::first();
        $hrEmail = $settings->hr_email ?? 'hr@rosacare.sy';
        
        if ($hrEmail) {
            try {
                Mail::to($hrEmail)->send(new PositionApplicationNotification($application));
            } catch (\Exception $e) {
                // Log the error but don't fail the request
                \Log::error('Failed to send position application notification email', [
                    'error' => $e->getMessage(),
                    'application_id' => $application->id,
                ]);
            }
        }

        return Redirect::back()->with('success', __('messages.application_sent', [], app()->getLocale()));
    }
}
