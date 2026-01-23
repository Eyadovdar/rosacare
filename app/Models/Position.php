<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Position extends Model
{
    use Translatable;

    public $translationModel = PositionTranslation::class;

    public $translatedAttributes = [
        'name',
        'description',
        'qualifications',
        'responsibilities',
        'button_text',
    ];

    protected $fillable = [
        'image',
        'image_url',
        'button_url',
        'button_color',
        'button_text_color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(PositionApplication::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PositionTranslation::class);
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

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}
