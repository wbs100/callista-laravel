<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'contact_info',
        'billing_data',
        'order_notes',
        'cart_data',
        'payment_mode',
        'payment_data',
        'status',
        'order_status',
        'payment_status',
    ];

    protected $casts = [
        'billing_data' => 'array',
        'payment_data' => 'array',
        'cart_data' => 'array',
    ];

    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the billing data for this order from the billing_data JSON column
     * Since billing_data is stored as JSON in the orders table
     */
    public function getBillingDataAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }
}
