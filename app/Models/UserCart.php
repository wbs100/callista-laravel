<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    use HasFactory;

    protected $table = 'user_carts';

    protected $fillable = [
        'user_id',
        'item_id',
        'name',
        'price',
        'quantity',
        'attributes'
    ];

    protected $casts = [
        'attributes' => 'array'
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product details
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }
}
