<?php

namespace App\Http\Controllers;

use App\Mail\PositionApplicationNotification;
use App\Mail\PositionApplicationVerificationCode;
use App\Models\Position;
use App\Models\PositionApplication;
use App\Models\PositionApplicationVerification;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PositionApplicationController extends Controller
{
    /**
     * Send verification code to email and store form data
     */
    public function sendVerificationCode(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('Position application verification request received', [
            'has_position_id' => $request->has('position_id'),
            'position_id' => $request->input('position_id'),
            'has_name' => $request->has('name'),
            'has_email' => $request->has('email'),
            'has_cv' => $request->hasFile('cv'),
            'cv_size' => $request->hasFile('cv') ? $request->file('cv')->getSize() : null,
            'all_input_keys' => array_keys($request->all()),
        ]);

        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'experience' => 'required|string|max:5000',
            'qualifications' => 'required|string|max:5000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        $email = $validated['email'];
        $locale = app()->getLocale() ?: 'en';

        // Check if position exists and is active
        $position = Position::where('id', $validated['position_id'])
            ->where('is_active', true)
            ->first();

        if (!$position) {
            throw ValidationException::withMessages([
                'position_id' => ['The selected position is not available.'],
            ]);
        }

        // Check if user has already applied for this position
        $existingApplication = PositionApplication::where('position_id', $validated['position_id'])
            ->where('email', $email)
            ->first();

        if ($existingApplication) {
            // If verified, reject the new application
            if ($existingApplication->is_verified) {
                throw ValidationException::withMessages([
                    'email' => $locale === 'ar'
                        ? 'لقد قمت بالتقديم على هذه الوظيفة مسبقاً.'
                        : 'You have already applied for this position.',
                ]);
            }

            // If there's an unverified application, delete it and allow new submission
            // Delete old CV file
            if ($existingApplication->cv_path) {
                Storage::disk('local')->delete($existingApplication->cv_path);
            }
            // Delete associated verification codes
            PositionApplicationVerification::where('application_id', $existingApplication->id)->delete();
            // Delete the unverified application
            $existingApplication->delete();
        }

        // Store the CV file in private storage
        $cvFile = $request->file('cv');
        $cvPath = $cvFile->store('position-applications/cvs', 'local');
        $cvFilename = $cvFile->getClientOriginalName();

        // Create the application with is_verified = false
        // Use try-catch to handle unique constraint violations (race conditions)
        try {
            $application = PositionApplication::create([
                'position_id' => $validated['position_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'experience' => $validated['experience'],
                'qualifications' => $validated['qualifications'],
                'cv_path' => $cvPath,
                'cv_filename' => $cvFilename,
                'is_verified' => false,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle unique constraint violation (race condition)
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'Duplicate entry')) {
                // Delete the uploaded file
                Storage::disk('local')->delete($cvPath);

                // Check if there's a verified application
                $verifiedApp = PositionApplication::where('position_id', $validated['position_id'])
                    ->where('email', $email)
                    ->where('is_verified', true)
                    ->first();

                if ($verifiedApp) {
                    throw ValidationException::withMessages([
                        'email' => $locale === 'ar'
                            ? 'لقد قمت بالتقديم على هذه الوظيفة مسبقاً.'
                            : 'You have already applied for this position.',
                    ]);
                }

                // If unverified, try to delete and retry once
                $existingApp = PositionApplication::where('position_id', $validated['position_id'])
                    ->where('email', $email)
                    ->where('is_verified', false)
                    ->first();

                if ($existingApp) {
                    // Delete old CV and verification codes
                    if ($existingApp->cv_path) {
                        Storage::disk('local')->delete($existingApp->cv_path);
                    }
                    PositionApplicationVerification::where('application_id', $existingApp->id)->delete();
                    $existingApp->delete();

                    // Retry creating the application
                    $application = PositionApplication::create([
                        'position_id' => $validated['position_id'],
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'] ?? null,
                        'experience' => $validated['experience'],
                        'qualifications' => $validated['qualifications'],
                        'cv_path' => $cvPath,
                        'cv_filename' => $cvFilename,
                        'is_verified' => false,
                    ]);
                } else {
                    // If we can't find it, show error
                    throw ValidationException::withMessages([
                        'email' => $locale === 'ar'
                            ? 'يرجى المحاولة مرة أخرى. إذا استمرت المشكلة، قد يكون لديك طلب قيد المعالجة.'
                            : 'Please try again. If the problem persists, you may have a pending application.',
                    ]);
                }
            } else {
                // Re-throw if it's a different error
                throw $e;
            }
        }

        // Clean up expired codes
        PositionApplicationVerification::cleanupExpired();

        // Generate 6-digit code
        $code = str_pad((string) rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete any existing unverified codes for this application
        PositionApplicationVerification::where('application_id', $application->id)
            ->where('verified', false)
            ->delete();

        // Create new verification code linked to the application
        $verification = PositionApplicationVerification::create([
            'application_id' => $application->id,
            'email' => $email,
            'code' => $code,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send verification code email
        try {
            $mailable = new PositionApplicationVerificationCode($code, $locale);
            Mail::to($email)->send($mailable);
            Log::info('Position application verification code sent', [
                'email' => $email,
                'verification_id' => $verification->id,
                'application_id' => $application->id,
                'code' => $code,
                'from_address' => config('mail.mailers.smtp.username') ?: config('mail.from.address'),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send verification code email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $email,
                'application_id' => $application->id,
                'mail_config' => [
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'encryption' => config('mail.mailers.smtp.encryption'),
                    'username' => config('mail.mailers.smtp.username'),
                    'from_address' => config('mail.from.address'),
                ],
            ]);
            // Clean up application and file on error
            Storage::disk('local')->delete($cvPath);
            $application->delete();

            // Provide more detailed error message
            $errorMessage = $locale === 'ar'
                ? 'فشل إرسال رمز التحقق. يرجى التحقق من إعدادات البريد الإلكتروني أو المحاولة مرة أخرى لاحقاً.'
                : 'Failed to send verification code. Please check your email configuration or try again later.';

            // In development, include the actual error
            if (config('app.debug')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            return Redirect::back()->withErrors([
                'email' => $errorMessage
            ]);
        }

        $message = $locale === 'ar'
            ? 'تم إرسال رمز التحقق إلى بريدك الإلكتروني. يرجى التحقق من صندوق الوارد.'
            : 'Verification code has been sent to your email. Please check your inbox.';

        return Redirect::back()->with('verification_sent', $message);
    }

    /**
     * Resend verification code
     */
    public function resendVerificationCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'position_id' => 'required|exists:positions,id',
        ]);

        $email = $validated['email'];
        $positionId = $validated['position_id'];
        $locale = app()->getLocale() ?: 'en';

        // Find unverified application
        $application = PositionApplication::where('position_id', $positionId)
            ->where('email', $email)
            ->where('is_verified', false)
            ->first();

        if (!$application) {
            return Redirect::back()->withErrors([
                'email' => $locale === 'ar'
                    ? 'لم يتم العثور على طلب غير محقق.'
                    : 'No unverified application found.'
            ]);
        }

        // Find existing verification
        $verification = PositionApplicationVerification::where('application_id', $application->id)
            ->where('email', $email)
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return Redirect::back()->withErrors([
                'email' => $locale === 'ar'
                    ? 'رمز التحقق غير موجود أو منتهي الصلاحية.'
                    : 'Verification code not found or expired.'
            ]);
        }

        // Check resend count (max 3 times)
        if ($verification->resend_count >= 3) {
            return Redirect::back()->withErrors([
                'email' => $locale === 'ar'
                    ? 'تم تجاوز الحد الأقصى لمحاولات إعادة الإرسال (3 مرات).'
                    : 'Maximum resend attempts (3) exceeded.'
            ]);
        }

        // Check cooldown (30 seconds)
        if ($verification->last_resend_at && now()->diffInSeconds($verification->last_resend_at) < 30) {
            $remainingSeconds = 30 - now()->diffInSeconds($verification->last_resend_at);
            return Redirect::back()->withErrors([
                'email' => $locale === 'ar'
                    ? "يرجى الانتظار {$remainingSeconds} ثانية قبل إعادة الإرسال."
                    : "Please wait {$remainingSeconds} seconds before resending."
            ]);
        }

        // Generate new code
        $code = str_pad((string) rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Update verification
        $verification->update([
            'code' => $code,
            'resend_count' => $verification->resend_count + 1,
            'last_resend_at' => now(),
            'expires_at' => now()->addMinutes(15), // Reset expiration
        ]);

        // Send verification code email
        try {
            $mailable = new PositionApplicationVerificationCode($code, $locale);
            Mail::to($email)->send($mailable);
            Log::info('Position application verification code resent', [
                'email' => $email,
                'verification_id' => $verification->id,
                'application_id' => $application->id,
                'resend_count' => $verification->resend_count,
            ]);

            $message = $locale === 'ar'
                ? 'تم إعادة إرسال رمز التحقق إلى بريدك الإلكتروني.'
                : 'Verification code has been resent to your email.';

            return Redirect::back()->with('verification_resent', $message);
        } catch (\Exception $e) {
            Log::error('Failed to resend verification code email', [
                'error' => $e->getMessage(),
                'email' => $email,
                'application_id' => $application->id,
            ]);

            return Redirect::back()->withErrors([
                'email' => $locale === 'ar'
                    ? 'فشل إعادة إرسال رمز التحقق. يرجى المحاولة مرة أخرى.'
                    : 'Failed to resend verification code. Please try again.'
            ]);
        }
    }

    /**
     * Verify the code and mark application as verified
     */
    public function verifyCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'code' => 'required|string|size:6',
        ]);

        $email = $validated['email'];
        $code = $validated['code'];
        $locale = app()->getLocale() ?: 'en';

        // Clean up expired codes
        PositionApplicationVerification::cleanupExpired();

        // Find verification code with application
        $verification = PositionApplicationVerification::where('email', $email)
            ->where('code', $code)
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->with('application')
            ->first();

        if (!$verification) {
            return Redirect::back()->withErrors([
                'code' => $locale === 'ar'
                    ? 'رمز التحقق غير صحيح أو منتهي الصلاحية.'
                    : 'Invalid or expired verification code.'
            ]);
        }

        // Get the application
        $application = $verification->application;

        if (!$application) {
            return Redirect::back()->withErrors([
                'code' => $locale === 'ar'
                    ? 'لم يتم العثور على الطلب المرتبط.'
                    : 'Associated application not found.'
            ]);
        }

        // Check if application is already verified
        if ($application->is_verified) {
            return Redirect::back()->withErrors([
                'code' => $locale === 'ar'
                    ? 'تم التحقق من هذا الطلب مسبقاً.'
                    : 'This application has already been verified.'
            ]);
        }

        // Check if position still exists and is active
        $position = Position::where('id', $application->position_id)
            ->where('is_active', true)
            ->first();

        if (!$position) {
            return Redirect::back()->withErrors([
                'position_id' => $locale === 'ar'
                    ? 'الوظيفة المحددة لم تعد متاحة.'
                    : 'The selected position is no longer available.',
            ]);
        }

        // Mark verification as verified
        $verification->markAsVerified();

        // Update application as verified
        $application->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // Reload application with position relationship for email
        $application->load('position.translations');

        // Send email notification to HR
        $settings = Setting::first();
        $hrEmail = $settings->hr_email ?? 'hr@rosacare.sy';

        if ($hrEmail) {
            try {
                Mail::to($hrEmail)->send(new PositionApplicationNotification($application));
                Log::info('Position application notification email sent successfully', [
                    'application_id' => $application->id,
                    'hr_email' => $hrEmail,
                ]);
            } catch (\Exception $e) {
                // Log the error but don't fail the request
                Log::error('Failed to send position application notification email', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'application_id' => $application->id,
                    'hr_email' => $hrEmail,
                ]);
            }
        } else {
            Log::warning('HR email not configured, skipping email notification', [
                'application_id' => $application->id,
            ]);
        }

        $successMessage = $locale === 'ar'
            ? 'تم إرسال طلبك بنجاح! سنتواصل معك قريباً.'
            : 'Your application has been submitted successfully! We will contact you soon.';

        return Redirect::back()->with('success', $successMessage);
    }

    /**
     * Download CV file from private storage
     */
    public function downloadCv($id)
    {
        $application = PositionApplication::findOrFail($id);

        if (!$application->cv_path) {
            abort(404, 'CV file not found');
        }

        // Check if file exists in private storage
        if (!Storage::disk('local')->exists($application->cv_path)) {
            abort(404, 'CV file not found');
        }

        return Storage::disk('local')->download(
            $application->cv_path,
            $application->cv_filename
        );
    }

    /**
     * Store method is no longer used - application is submitted in verifyCode
     * Keeping for backward compatibility but redirecting to positions page
     */
    public function store(Request $request)
    {
        $locale = app()->getLocale() ?: 'en';
        $message = $locale === 'ar'
            ? 'يرجى التحقق من بريدك الإلكتروني أولاً.'
            : 'Please verify your email address first.';

        return Redirect::back()->withErrors(['email' => $message]);
    }
}
