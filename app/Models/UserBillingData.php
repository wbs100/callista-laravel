<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBillingData extends Model
{
    use HasFactory;

    protected $table = 'billing_data';

    protected $fillable = ['user_id', 'contact_info', 'first_name', 'last_name', 'company_name', 'address_1', 'address_2', 'town',  'postal_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
