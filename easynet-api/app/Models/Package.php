<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    
    public function products(){
    	return $this->belongsToMany('App\Models\Product');
    }

   	public function package_users(){
        return $this->belongsToMany('App\Models\PackageUser');
    }
}
