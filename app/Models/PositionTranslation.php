<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'position_id',
        'locale',
        'name',
        'description',
        'qualifications',
        'responsibilities',
        'button_text',
    ];
}
