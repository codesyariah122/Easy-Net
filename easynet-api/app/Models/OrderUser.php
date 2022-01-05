<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUser extends Model
{
    use HasFactory;

    public function orders(){
        return $this->belongsToMany('App\Models\Order');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
