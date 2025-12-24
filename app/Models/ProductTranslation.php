<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'locale',
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

    protected $casts = [
        'ingredients' => 'array',
        'benefits' => 'array',
        'usage_instructions' => 'array',
    ];
}
