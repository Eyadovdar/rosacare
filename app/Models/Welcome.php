<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Welcome extends Model
{
    use Translatable;

    public $translationModel = WelcomeTranslation::class;

    public $translatedAttributes = [
        'title',
        'description',
        'button_text',
    ];

    protected $fillable = [
        'image',
        'button_url',
        'is_active',
    ];

    public function welcomeDetails(): HasMany
    {
        return $this->hasMany(WelcomeDetail::class);
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
        // The path might be: "welcomes/images/filename.webp"

        // Check if file exists
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        // Fallback: return the URL anyway (file might not be uploaded yet)
        return Storage::disk('public')->url($this->image);
    }
}
