<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PositionApplicationController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Public routes
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
Route::post('/position-applications/send-verification', [PositionApplicationController::class, 'sendVerificationCode'])->name('position-applications.send-verification');
Route::post('/position-applications/resend-verification', [PositionApplicationController::class, 'resendVerificationCode'])->name('position-applications.resend-verification');
Route::post('/position-applications/verify-code', [PositionApplicationController::class, 'verifyCode'])->name('position-applications.verify-code');
Route::post('/position-applications', [PositionApplicationController::class, 'store'])->name('position-applications.store');
Route::get('/position-applications/{id}/download-cv', [PositionApplicationController::class, 'downloadCv'])->name('position-applications.download-cv')->middleware('auth');
Route::get('/position-applications/download-cvs-zip', [PositionApplicationController::class, 'downloadCvsZip'])->name('position-applications.download-cvs-zip')->middleware('auth');
Route::get('/privacy-policy', function () {
    return Inertia::render('PrivacyPolicy', [
        'locale' => app()->getLocale() ?: session('locale', 'ar'),
    ]);
})->name('privacy-policy');
Route::get('/terms-of-use', function () {
    return Inertia::render('TermsOfUse', [
        'locale' => app()->getLocale() ?: session('locale', 'ar'),
    ]);
})->name('terms-of-use');
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');

// Check mail configuration route (remove after testing)
Route::get('/check-mail-config', function () {
    $config = [
        'MAIL_MAILER' => config('mail.default'),
        'MAIL_HOST' => config('mail.mailers.smtp.host'),
        'MAIL_PORT' => config('mail.mailers.smtp.port'),
        'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
        'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
        'MAIL_FROM_ADDRESS' => config('mail.from.address'),
        'MAIL_FROM_NAME' => config('mail.from.name'),
    ];

    return response()->json([
        'mail_config' => $config,
        'note' => 'Make sure MAIL_FROM_ADDRESS matches MAIL_USERNAME',
        'recommendations' => [
            'Port 465 should use SSL encryption',
            'Port 587 should use TLS encryption',
            'MAIL_FROM_ADDRESS must match MAIL_USERNAME for most SMTP servers',
        ],
    ]);
})->name('check.mail.config');

// Test email route (remove after testing)
Route::get('/test-email', function () {
    try {
        // Get current mail configuration
        $mailConfig = [
            'MAIL_MAILER' => config('mail.default'),
            'MAIL_HOST' => config('mail.mailers.smtp.host'),
            'MAIL_PORT' => config('mail.mailers.smtp.port'),
            'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
            'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
            'MAIL_FROM_ADDRESS' => config('mail.from.address'),
            'MAIL_FROM_NAME' => config('mail.from.name'),
        ];

        // Use the same email as username for From address to avoid SMTP rejection
        $fromAddress = config('mail.mailers.smtp.username') ?: config('mail.from.address');
        $fromName = config('mail.from.name');

        // Send test email using raw method
        \Illuminate\Support\Facades\Mail::raw('This is a test email from RosaCare. If you receive this, your mail configuration is working correctly!', function ($message) use ($fromAddress, $fromName) {
            $message->to('eiaddar@gmail.com')
                    ->subject('RosaCare - Email Configuration Test')
                    ->from($fromAddress, $fromName);
        });

        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully to eiaddar@gmail.com',
            'mail_config' => $mailConfig,
            'from_address_used' => $fromAddress,
            'note' => 'Please check eiaddar@gmail.com inbox (and spam folder)',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send test email',
            'error' => $e->getMessage(),
            'mail_config' => [
                'MAIL_MAILER' => config('mail.default'),
                'MAIL_HOST' => config('mail.mailers.smtp.host'),
                'MAIL_PORT' => config('mail.mailers.smtp.port'),
                'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
                'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
                'MAIL_FROM_ADDRESS' => config('mail.from.address'),
                'MAIL_FROM_NAME' => config('mail.from.name'),
            ],
            'fix_suggestion' => 'MAIL_FROM_ADDRESS must match MAIL_USERNAME. Also, port 465 usually requires SSL encryption, not TLS.',
        ], 500);
    }
})->name('test.email');

// Auth routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
