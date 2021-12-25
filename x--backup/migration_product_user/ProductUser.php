<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUser extends Model
{
    use HasFactory;
    public $table='product_user';

   	public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

}
