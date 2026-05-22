<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'image',
        'location',
        'role',
        'status',
        'type',
        'google_id',
        'otp',
        'otp_expires_at',
    ];

    public function cartItems() {
        return $this->hasMany(cart::class);
    }

    public function addresses() {
        return $this->hasMany(address::class);
    }

}
