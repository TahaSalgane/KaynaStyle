<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name_en', 'hex_code', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return $this->name_en;
    }
}
