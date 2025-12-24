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
}
