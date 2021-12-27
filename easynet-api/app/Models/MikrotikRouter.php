<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MikrotikRouter extends Model
{
    use HasFactory;
    public $table = 'mikrotik_routers';

    protected $fillable = [
        'identity',
        'ip',
        'password',
    ];
}
