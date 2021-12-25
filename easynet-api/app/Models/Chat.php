<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    public $table = 'chats';

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
