<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountdownTimer extends Model
{
    protected $fillable = [
        'title',
        'message',
        'end_date',
        'is_active',
        'background_color',
        'text_color'
    ];

    protected $casts = [
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];
}
