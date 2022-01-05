<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profiles()
    {
        return $this->belongsToMany('App\Models\Profile');
    }

    public function api_keys()
    {
        return $this->belongsToMany('App\Models\ApiKeys');
    }

    public function chats()
    {
        return $this->belongsToMany('App\Models\Chat');
    }

    public function product_users(){
        return $this->belongsToMany('App\Models\ProductUser');
    }

    public function package_users(){
        return $this->belongsToMany('App\Models\PackageUser');
    }

    public function log_logins()
    {
        return $this->belongsToMany('App\Models\LogLogin');
    }

    public function orders(){
        return $this->belongsToMany('App\Models\Order');
    }

    public function order_users(){
        return $this->belongsToMany('App\Models\OrderUser');
    }

}
