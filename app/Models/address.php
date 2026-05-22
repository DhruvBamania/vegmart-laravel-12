<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    //
    protected $fillable = 
    [
        'user_id', 
        'address_type', 
        'first_name', 
        'last_name', 
        'address', 
        'city', 
        'country', 
        'zip', 
        'mobile', 
        'is_default'
    ];

    public function user() {
        return $this->belongsTo(user::class);
    }
}
