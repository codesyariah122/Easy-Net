<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function products(){
    	return $this->belongsToMany('App\Models\Product');
    }

    public function packages(){
    	return $this->belongsToMany('App\Models\Package');
    }

    public function order_users(){
        return $this->belongsToMany('App\Models\OrderUser');
    }
}
