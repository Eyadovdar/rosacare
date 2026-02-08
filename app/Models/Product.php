<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable, SoftDeletes;

    public $translationModel = ProductTranslation::class;

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

    /**
     * Main/featured image relationship (single image)
     */
    public function featuredImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'featured')
            ->orderBy('sort_order');
    }

    /**
     * Gallery images relationship (multiple images)
     */
    public function galleryImages(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')
            ->where('collection_name', 'gallery')
            ->orderBy('sort_order');
    }

    /**
     * Accessor for featured image (backward compatibility)
     * Use $product->featured_image or $product->featuredImage
     */
    public function getFeaturedImageAttribute()
    {
        return $this->featuredImage()->first();
    }

    /**
     * Accessor for gallery images (backward compatibility)
     * Use $product->gallery_images or $product->galleryImages
     */
    public function getGalleryImagesAttribute()
    {
        return $this->galleryImages()->get();
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Create a duplicate of this product with copies of translations and media references.
     */
    public function duplicate(): self
    {
        $copy = $this->replicate();
        $copy->view_count = 0;
        $copy->deleted_at = null;
        $copy->sku = $this->makeUniqueSku($this->sku ?? 'product');
        $copy->slug = $this->makeUniqueSlug($this->slug ?? 'product-' . $this->id);
        $copy->save();

        foreach ($this->translations as $translation) {
            $copy->translations()->create($translation->only([
                'locale', 'name', 'description', 'short_description', 'ingredients',
                'benefits', 'usage_instructions', 'meta_title', 'meta_description', 'meta_keywords',
            ]));
        }

        foreach ($this->media()->get() as $media) {
            $copy->media()->create($media->only([
                'collection_name', 'file_name', 'mime_type', 'size', 'disk', 'path', 'sort_order', 'custom_properties',
            ]));
        }

        return $copy;
    }

    private function makeUniqueSku(string $base): string
    {
        $sku = $base . '-copy';
        $n = 1;
        while (static::where('sku', $sku)->exists()) {
            $sku = $base . '-copy-' . $n++;
        }
        return $sku;
    }

    private function makeUniqueSlug(string $base): string
    {
        $slug = $base . '-copy';
        $n = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-copy-' . $n++;
        }
        return $slug;
    }
}
