<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'locale',
        'question',
        'answer',
    ];

    public function getAnswerAttribute($value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars_decode($value);
    }
}
