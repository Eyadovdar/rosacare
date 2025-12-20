<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavigationMenuItem extends Model
{
    use Translatable, SoftDeletes;

    public $translationModel = NavigationMenuItemTranslation::class;

    public $translatedAttributes = [
        'label',
    ];

    protected $fillable = [
        'type',
        'url',
        'icon',
        'category_id',
        'page',
        'sort_order',
        'is_active',
        'open_in_new_tab',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getResolvedUrlAttribute(): string
    {
        if ($this->type === 'category' && $this->category) {
            return route('categories.show', $this->category->slug);
        }

        if ($this->type === 'page') {
            return match($this->page) {
                'home' => route('home'),
                'about' => route('about'),
                'contact' => route('contact'),
                'products' => route('products.index'),
                default => '/',
            };
        }

        return $this->url ?? '/';
    }
}
