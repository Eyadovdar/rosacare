<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParallaxTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'parallax_id',
        'locale',
        'title',
        'description',
    ];
}
