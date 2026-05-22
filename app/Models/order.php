<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class order extends Model
{
    //
    protected $fillable = [
    'user_id', 'order_number', 'first_name', 'last_name', 'address', 
    'city', 'country', 'zip', 'mobile', 'notes', 
    'subtotal', 'discount', 'total', 'payment_method', 'status', 'payment_id'
    ];

    public function items() {
        return $this->hasMany(order_items::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
