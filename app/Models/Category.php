<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name_en', 'slug', 'description_en',
        'image', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getNameAttribute()
    {
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return $this->description_en;
    }
}
