<?php
namespace App\MyMethod;

class MyHelper {
	private  $title;

	public function  __construct($title)
	{
		$this->title = $title;
	}

	public function GetMyContext(){
		return $this->title;
	}
}