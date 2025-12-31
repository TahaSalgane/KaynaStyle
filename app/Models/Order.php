<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'access_token',
        'customer_name',
        'customer_phone',
        'customer_city',
        'customer_address',
        'customer_notes',
        'billing_email',
        'billing_first_name',
        'billing_last_name',
        'billing_company',
        'billing_country',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_phone',
        'status',
        'total_amount',
        'payment_status',
        'delivery_status',
        'shipping_carrier',
        'tracking_number'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
