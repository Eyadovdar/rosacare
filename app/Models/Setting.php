<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use Translatable;

    public $translationModel = SettingTranslation::class;

    public $translatedAttributes = [
        'site_name',
        'slogan',
        'footer_description',
        'default_meta_title',
        'default_meta_description',
        'default_meta_keywords',
        'contact_page_info_title',
        'contact_page_form_title',
        'google_map_title',
        'footer_copyright',
    ];

    protected $fillable = [
        'logo_header_path',
        'logo_footer_path',
        'favicon_path',
        'default_meta_image',
        'google_verification_code',
        'phone_number',
        'email',
        'address',
        'google_map_iframe',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'youtube',
        'tiktok',
        'whatsapp',
        'show_price_in_products',
        'show_whatsapp_button',
        'default_currency_ar',
        'default_currency_en',
    ];

    /**
     * Get the full URL for the header logo
     *
     * @return string|null
     */
    public function getHeaderLogoUrlAttribute(): ?string
    {
        if (!$this->logo_header_path) {
            return null;
        }

        // If the path already starts with http:// or https://, return as is
        if (str_starts_with($this->logo_header_path, 'http://') || str_starts_with($this->logo_header_path, 'https://')) {
            return $this->logo_header_path;
        }

        // Check if file exists
        if (Storage::disk('public')->exists($this->logo_header_path)) {
            return Storage::disk('public')->url($this->logo_header_path);
        }

        // Fallback: return the URL anyway
        return Storage::disk('public')->url($this->logo_header_path);
    }

    /**
     * Get the full URL for the footer logo
     *
     * @return string|null
     */
    public function getFooterLogoUrlAttribute(): ?string
    {
        if (!$this->logo_footer_path) {
            return null;
        }

        // If the path already starts with http:// or https://, return as is
        if (str_starts_with($this->logo_footer_path, 'http://') || str_starts_with($this->logo_footer_path, 'https://')) {
            return $this->logo_footer_path;
        }

        // Check if file exists
        if (Storage::disk('public')->exists($this->logo_footer_path)) {
            return Storage::disk('public')->url($this->logo_footer_path);
        }

        // Fallback: return the URL anyway
        return Storage::disk('public')->url($this->logo_footer_path);
    }

    /**
     * Get the full URL for the favicon
     *
     * @return string|null
     */
    public function getFaviconUrlAttribute(): ?string
    {
        if (!$this->favicon_path) {
            return null;
        }

        // If the path already starts with http:// or https://, return as is
        if (str_starts_with($this->favicon_path, 'http://') || str_starts_with($this->favicon_path, 'https://')) {
            return $this->favicon_path;
        }

        // Check if file exists
        if (Storage::disk('public')->exists($this->favicon_path)) {
            return Storage::disk('public')->url($this->favicon_path);
        }

        // Fallback: return the URL anyway
        return Storage::disk('public')->url($this->favicon_path);
    }
}
