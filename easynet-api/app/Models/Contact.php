<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function contact_categories(){
		return $this->belongsToMany('App\Models\ContactCategory');
	}
}
