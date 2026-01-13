<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class About extends Model
{
    use Translatable;

    public $translationModel = AboutTranslation::class;

    public $translatedAttributes = [
        'story_title',
        'story_content',
        'story_paragraphs',
        'vision_title',
        'vision_content',
        'mission_title',
        'mission_content',
        'heritage_title',
        'heritage_content',
        'heritage_subcontent',
        'why_rosacare_title',
        'benefits_title',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $fillable = [
        'hero_image_path',
        'story_image_path',
        'story_icon_path',
        'vision_image_path',
        'vision_icon_path',
        'mission_image_path',
        'mission_icon_path',
        'heritage_image_path',
        'benefits_image_path',
        'why_rosacare_image_path',
        'benefits',
        'reasons',
        'heritage_features',
        'is_active',
    ];

    protected $casts = [
        'benefits' => 'array',
        'reasons' => 'array',
        'heritage_features' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the full URL for the hero image
     */
    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->hero_image_path);
    }

    /**
     * Get the full URL for the story image
     */
    public function getStoryImageUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->story_image_path);
    }

    /**
     * Get the full URL for the story icon
     */
    public function getStoryIconUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->story_icon_path);
    }

    /**
     * Get the full URL for the vision image
     */
    public function getVisionImageUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->vision_image_path);
    }

    /**
     * Get the full URL for the vision icon
     */
    public function getVisionIconUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->vision_icon_path);
    }

    /**
     * Get the full URL for the mission image
     */
    public function getMissionImageUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->mission_image_path);
    }

    /**
     * Get the full URL for the mission icon
     */
    public function getMissionIconUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->mission_icon_path);
    }

    /**
     * Get the full URL for the heritage image
     */
    public function getHeritageImageUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->heritage_image_path);
    }

    /**
     * Get the full URL for the benefits image
     */
    public function getBenefitsImageUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->benefits_image_path);
    }

    /**
     * Get the full URL for the why rosacare image
     */
    public function getWhyRosacareImageUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->why_rosacare_image_path);
    }

    /**
     * Helper method to get image URL
     */
    protected function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If the path already starts with http:// or https://, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Check if file exists
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        // Fallback: return the URL anyway
        return Storage::disk('public')->url($path);
    }

    /**
     * Get benefits with icon URLs
     */
    public function getBenefitsWithUrlsAttribute(): array
    {
        if (!$this->benefits) {
            return [];
        }

        return array_map(function ($benefit) {
            if (isset($benefit['icon_path']) && $benefit['icon_path']) {
                $benefit['icon_url'] = $this->getImageUrl($benefit['icon_path']);
            }
            return $benefit;
        }, $this->benefits);
    }

    /**
     * Get reasons with icon URLs
     */
    public function getReasonsWithUrlsAttribute(): array
    {
        if (!$this->reasons) {
            return [];
        }

        return array_map(function ($reason) {
            if (isset($reason['icon_path']) && $reason['icon_path']) {
                $reason['icon_url'] = $this->getImageUrl($reason['icon_path']);
            }
            return $reason;
        }, $this->reasons);
    }

    /**
     * Get heritage features with icon URLs
     */
    public function getHeritageFeaturesWithUrlsAttribute(): array
    {
        if (!$this->heritage_features) {
            return [];
        }

        return array_map(function ($feature) {
            if (isset($feature['icon_path']) && $feature['icon_path']) {
                $feature['icon_url'] = $this->getImageUrl($feature['icon_path']);
            }
            return $feature;
        }, $this->heritage_features);
    }
}
