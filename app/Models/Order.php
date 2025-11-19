<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'public_user_id',
        'first_name',
        'last_name',
        'company',
        'address_line1',
        'address_line2',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'notes',
        'payment_method',
        'payment_slip',
        'total',
        'payment_status',
        'order_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPaymentSlipUrlAttribute()
    {
        return $this->payment_slip ? asset($this->payment_slip) : null;
    }
}
