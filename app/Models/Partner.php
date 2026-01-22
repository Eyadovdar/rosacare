<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    protected $table = 'pratners';

    protected $fillable = [
        'title', 'image', 'url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the full URL for the image
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // If the path already starts with http:// or https://, return as is
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Check if file exists
        if (Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        // Fallback: return the URL anyway (file might not be uploaded yet)
        return asset('storage/' . $this->image);
    }
}
