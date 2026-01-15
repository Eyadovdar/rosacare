<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Announcement extends Model
{
    use Translatable;

    public $translationModel = AnnouncementTranslation::class;

    public $translatedAttributes = [
        'title',
        'description',
        'button_text',
    ];

    protected $fillable = [
        'image',
        'button_url',
        'button_color',
        'button_text_color',
        'is_active',
        'start_date',
        'end_date',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(AnnouncementTranslation::class);
    }

    public function getUrlAttribute(): string
    {
        return url($this->button_url);
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

        // Filament stores files in storage/app/public, and the path is relative to that
        // The path might be: "announcements/images/filename.webp"

        // Use asset() helper to generate the URL
        return asset('storage/' . $this->image);
    }
}
