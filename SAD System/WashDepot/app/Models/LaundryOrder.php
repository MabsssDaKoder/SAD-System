<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaundryOrder extends Model
{
    protected $fillable = [
        'queue_number',
        'customer_name',
        'contact_number',
        'weight_kg',
        'service_type',
        'addons',
        'total_price',
        'qr_code',
        'status',
        'received_at',
        'estimated_finish',
    ];

    protected $casts = [
        'addons'           => 'array',
        'received_at'      => 'datetime',
        'estimated_finish' => 'datetime',
    ];

    /**
     * Generate the next queue number for today.
     */
    public static function nextQueueNumber(): int
    {
        $max = static::whereDate('created_at', today())->max('queue_number');
        return ($max ?? 0) + 1;
    }
}