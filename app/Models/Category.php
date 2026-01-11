<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use Translatable, SoftDeletes;

    public $translationModel = CategoryTranslation::class;

    public $translatedAttributes = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $fillable = [
        'slug',
        'icon',
        'image',
        'sort_order',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
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

        // Filament stores files in storage/app/public
        // The path might be: "categories/filename.webp" or just "filename.webp"
        
        // Check if file exists
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        // Fallback: return the URL anyway (file might not be uploaded yet)
        return Storage::disk('public')->url($this->image);
    }
}
