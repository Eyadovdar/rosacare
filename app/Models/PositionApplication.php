<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PositionApplication extends Model
{
    protected $fillable = [
        'position_id',
        'name',
        'email',
        'phone',
        'experience',
        'qualifications',
        'cv_path',
        'cv_filename',
        'is_verified',
        'verified_at',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Get the download URL for the CV (from private storage)
     *
     * @return string|null
     */
    public function getCvUrlAttribute(): ?string
    {
        if (!$this->cv_path) {
            return null;
        }

        // Return route URL for downloading from private storage
        return route('position-applications.download-cv', $this->id);
    }
}
