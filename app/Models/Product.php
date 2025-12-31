<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name_en', 'slug', 'description_en',
        'price', 'sale_price', 'sale_end_date', 'is_countdown_sale', 'sku', 'default_color_id', 'images', 'sizes', 'colors', 'stock_quantity',
        'is_featured', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'images' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_countdown_sale' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'sale_end_date' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function defaultColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'default_color_id');
    }

    public function colorImages(): HasMany
    {
        return $this->hasMany(ProductColorImage::class);
    }

    public function colorQuantities(): HasMany
    {
        return $this->hasMany(ProductColorQuantity::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    /**
     * Get average rating for the product
     */
    public function getAverageRatingAttribute()
    {
        $approvedReviews = $this->approvedReviews;
        if ($approvedReviews->count() === 0) {
            return 0;
        }
        return round($approvedReviews->avg('rating'), 1);
    }

    /**
     * Get total reviews count
     */
    public function getTotalReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Get images for a specific color
     */
    public function getImagesForColor($colorId)
    {
        return $this->colorImages()
            ->where('color_id', $colorId)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get main image for a specific color
     */
    public function getMainImageForColor($colorId)
    {
        return $this->colorImages()
            ->where('color_id', $colorId)
            ->where('is_main', true)
            ->first();
    }

    /**
     * Get all available colors for this product
     */
    public function getAvailableColors()
    {
        return $this->colorImages()
            ->with('color')
            ->get()
            ->groupBy('color_id')
            ->map(function ($images) {
                return $images->first()->color;
            });
    }

    /**
     * Get quantity for a specific color
     */
    public function getQuantityForColor($colorId)
    {
        $colorQuantity = $this->colorQuantities()
            ->where('color_id', $colorId)
            ->first();

        return $colorQuantity ? $colorQuantity->quantity : 0;
    }

    /**
     * Check if a color is available (has quantity > 0)
     */
    public function isColorAvailable($colorId)
    {
        return $this->getQuantityForColor($colorId) > 0;
    }

    public function getNameAttribute()
    {
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return $this->description_en;
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Check if the sale is currently active
     */
    public function isSaleActive()
    {
        if (!$this->sale_price || !$this->is_countdown_sale || !$this->sale_end_date) {
            return false;
        }

        return now()->lt($this->sale_end_date);
    }

    /**
     * Get time remaining for sale in seconds
     */
    public function getSaleTimeRemaining()
    {
        if (!$this->isSaleActive()) {
            return 0;
        }

        return $this->sale_end_date->diffInSeconds(now());
    }

    /**
     * Get formatted time remaining for sale
     */
    public function getFormattedSaleTimeRemaining()
    {
        if (!$this->isSaleActive()) {
            return null;
        }

        $seconds = $this->getSaleTimeRemaining();
        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        return [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $remainingSeconds,
            'total_seconds' => $seconds
        ];
    }

    public function getMainImageAttribute()
    {
        // First priority: main image from default color
        if ($this->default_color_id) {
            $defaultColorMainImage = $this->colorImages()
                ->where('color_id', $this->default_color_id)
                ->where('is_main', true)
                ->first();
            if ($defaultColorMainImage) {
                return $defaultColorMainImage->image_path;
            }
        }

        // Second priority: any main image from color images
        $mainColorImage = $this->colorImages()->where('is_main', true)->first();
        if ($mainColorImage) {
            return $mainColorImage->image_path;
        }

        // Third priority: first color image
        $firstColorImage = $this->colorImages()->orderBy('sort_order')->first();
        if ($firstColorImage) {
            return $firstColorImage->image_path;
        }

        // Fallback to legacy images
        $images = $this->getImagesAttribute($this->attributes['images'] ?? null);
        return !empty($images) ? $images[0] : null;
    }

    public function getImagesAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_string($value)) {
            // Remove outer quotes and fix excessive escaping
            $cleanJson = trim($value, '"');
            // Remove excessive backslashes
            $cleanJson = preg_replace('/\\\\+/', '\\', $cleanJson);
            $cleanJson = str_replace(['\\/', '\\"'], ['/', '"'], $cleanJson);
            $decoded = json_decode($cleanJson, true);

            // Clean up each image path in the array
            if (is_array($decoded)) {
                $decoded = array_map(function($imagePath) {
                    // Normalize the path by removing excessive backslashes
                    return str_replace(['\\\\', '\\/'], ['\\', '/'], $imagePath);
                }, $decoded);
            }

            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    public function getColorsAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_string($value)) {
            // Remove outer quotes and fix escaping
            $cleanJson = trim($value, '"');
            $cleanJson = str_replace(['\\/', '\\"'], ['/', '"'], $cleanJson);
            $decoded = json_decode($cleanJson, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    public function getSizesAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_string($value)) {
            // Remove outer quotes and fix escaping
            $cleanJson = trim($value, '"');
            $cleanJson = str_replace(['\\/', '\\"'], ['/', '"'], $cleanJson);
            $decoded = json_decode($cleanJson, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }
}
