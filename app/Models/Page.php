<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    use Translatable;

    public $translationModel = PageTranslation::class;

    public $translatedAttributes = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $fillable = [
        'slug',
        'header_image_path',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * Get content blocks for a specific locale
     *
     * @param string|null $locale
     * @return array|null
     */
    public function getContentForLocale(?string $locale = null): ?array
    {
        $locale = $locale ?? app()->getLocale();

        $translation = $this->translate($locale);

        if (!$translation || !$translation->content) {
            return null;
        }

        // Content is automatically cast to array by PageTranslation model
        return $translation->content;
    }

    /**
     * Get content blocks for Arabic locale
     *
     * @return array|null
     */
    public function getArabicContent(): ?array
    {
        return $this->getContentForLocale('ar');
    }

    /**
     * Get content blocks for English locale
     *
     * @return array|null
     */
    public function getEnglishContent(): ?array
    {
        return $this->getContentForLocale('en');
    }

    /**
     * Get all blocks of a specific type
     *
     * @param string $type The block type (e.g., 'paragraph', 'hero_section', 'cta_section')
     * @param string|null $locale
     * @return array
     */
    public function getBlocksByType(string $type, ?string $locale = null): array
    {
        $contentBlocks = $this->getContentForLocale($locale);

        if (!$contentBlocks || !is_array($contentBlocks)) {
            return [];
        }

        return array_filter($contentBlocks, function ($block) use ($type) {
            return isset($block['type']) && $block['type'] === $type;
        });
    }

    /**
     * Get the first block of a specific type
     *
     * @param string $type The block type
     * @param string|null $locale
     * @return array|null
     */
    public function getFirstBlockByType(string $type, ?string $locale = null): ?array
    {
        $blocks = $this->getBlocksByType($type, $locale);
        return !empty($blocks) ? reset($blocks) : null;
    }

    /**
     * Check if a page has a block of a specific type
     *
     * @param string $type The block type
     * @param string|null $locale
     * @return bool
     */
    public function hasBlockType(string $type, ?string $locale = null): bool
    {
        return !empty($this->getBlocksByType($type, $locale));
    }

    /**
     * Get all available block types in the content
     *
     * @param string|null $locale
     * @return array
     */
    public function getAvailableBlockTypes(?string $locale = null): array
    {
        $contentBlocks = $this->getContentForLocale($locale);

        if (!$contentBlocks || !is_array($contentBlocks)) {
            return [];
        }

        $types = [];
        foreach ($contentBlocks as $block) {
            if (isset($block['type'])) {
                $types[] = $block['type'];
            }
        }

        return array_unique($types);
    }

    /**
     * Get the full URL for the header image
     *
     * @return string|null
     */
    public function getHeaderImageUrlAttribute(): ?string
    {
        if (!$this->header_image_path) {
            return null;
        }

        // If the path already starts with http:// or https://, return as is
        if (str_starts_with($this->header_image_path, 'http://') || str_starts_with($this->header_image_path, 'https://')) {
            return $this->header_image_path;
        }

        // Check if the file exists in storage
        // Filament stores files in storage/app/public, and the path might be:
        // - Just the filename (e.g., "01KD2V1ZK6Q1G47FETYX2E7DA9.png")
        // - With directory (e.g., "pages/headers/01KD2V1ZK6Q1G47FETYX2E7DA9.png")
        
        $path = $this->header_image_path;
        
        // If path doesn't include directory, prepend it
        if (!str_contains($path, 'pages/headers/')) {
            $path = 'pages/headers/' . $path;
        }

        // Check if file exists with directory
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        // Fallback: check if file exists as stored (without directory)
        if (Storage::disk('public')->exists($this->header_image_path)) {
            return Storage::disk('public')->url($this->header_image_path);
        }

        // Last fallback: assume it's in pages/headers directory
        return Storage::disk('public')->url($path);
    }
}
