<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'admin_response',
        'responded_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'responded_at' => 'datetime'
    ];
}
