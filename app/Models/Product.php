<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable, SoftDeletes;

    public $translatedAttributes = [
        'name',
        'description',
        'short_description',
        'ingredients',
        'benefits',
        'usage_instructions',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $fillable = [
        'category_id',
        'sku',
        'slug',
        'price',
        'sale_price',
        'stock_quantity',
        'in_stock',
        'is_active',
        'is_featured',
        'sort_order',
        'view_count',
        'specifications',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'specifications' => 'array',
        'view_count' => 'integer',
        'stock_quantity' => 'integer',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')->orderBy('sort_order');
    }

    public function getFeaturedImageAttribute()
    {
        return $this->media()->where('collection_name', 'featured')->first();
    }

    public function getGalleryImagesAttribute()
    {
        return $this->media()->where('collection_name', 'gallery')->get();
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }
}
