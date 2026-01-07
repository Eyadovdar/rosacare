<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'menu_item_id',
        'locale',
        'label',
    ];
}
