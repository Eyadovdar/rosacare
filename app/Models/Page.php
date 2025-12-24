<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

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
}
