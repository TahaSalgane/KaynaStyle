<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductColorImage extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'image_path',
        'is_main',
        'sort_order'
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the full image URL
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
