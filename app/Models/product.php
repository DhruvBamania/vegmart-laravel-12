<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    //
    public function carts() {
        return $this->hasMany(cart::class);
    }
}
