<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class PositionApplicationVerification extends Model
{
    protected $fillable = [
        'application_id',
        'email',
        'code',
        'expires_at',
        'verified',
        'verified_at',
        'resend_count',
        'last_resend_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean',
        'verified_at' => 'datetime',
        'last_resend_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(PositionApplication::class);
    }

    /**
     * Check if the verification code is valid
     */
    public function isValid(): bool
    {
        return !$this->verified && $this->expires_at->isFuture();
    }

    /**
     * Mark as verified
     */
    public function markAsVerified(): void
    {
        $this->update([
            'verified' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Clean up expired verification codes
     */
    public static function cleanupExpired(): void
    {
        static::where('expires_at', '<', now())
            ->where('verified', false)
            ->delete();
    }
}
