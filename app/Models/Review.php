<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'category_id',
        'customer_name',
        'review_title',
        'rating',
        'review_text',
        'media',
        'email',
        'display_name',
        'display_name_format',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedDisplayNameAttribute(): string
    {
        if ($this->display_name_format === 'anonymous') {
            return 'Anonymous';
        }

        $name = $this->display_name ?: $this->customer_name;
        $parts = explode(' ', $name);

        switch ($this->display_name_format) {
            case 'last_initial':
                return $parts[0] . ' ' . (isset($parts[1]) ? strtoupper(substr($parts[1], 0, 1)) . '.' : '');
            case 'all_initials':
                return implode('.', array_map(fn($part) => strtoupper(substr($part, 0, 1)), $parts)) . '.';
            case 'first_name_only':
                return $parts[0];
            case 'full':
            default:
                return $name;
        }
    }
}
