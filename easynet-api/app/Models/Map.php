<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
	use HasFactory;
	
	public $table = 'maps';

	protected $fillable = [
		'title',
		'lat',
		'lng',
		'region',
		'external_link'
	];

	public function map_categories(){
		return $this->belongsToMany('App\Models\MapCategory');
	}
}
