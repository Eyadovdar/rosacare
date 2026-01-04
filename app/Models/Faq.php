<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
    ];

    public function getAnswerAttribute(): string
    {
        return htmlspecialchars_decode($this->answer);
    }
}
