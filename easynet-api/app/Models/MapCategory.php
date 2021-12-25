<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapCategory extends Model
{
    use HasFactory;
    
    public $table = 'map_categories';

    public function maps(){
    	return $this->belongsToMany('App\Models\Map');
    }
}
