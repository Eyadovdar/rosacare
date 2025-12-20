<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationMenuItemTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'navigation_menu_item_id',
        'locale',
        'label',
    ];
}
