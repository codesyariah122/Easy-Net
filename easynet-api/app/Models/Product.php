<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    
    public function categories(){
    	return $this->belongsToMany('App\Models\Category');
    }

    public function packages(){
    	return $this->belongsToMany('App\Models\Package');
    }

    public function product_users(){
        return $this->belongsToMany('App\Models\ProductUser');
    }

}
