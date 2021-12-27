<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        //
        Gate::define('user-manage', function($user){
            return count(array_intersect(["ADMIN", "SALES", "SUPPORT", "CUSTOMER"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('category-product', function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('product', function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('package-product', function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('map-category', function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('map', function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('category-message', function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('contact-message', function($user){
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('notification', function($user){
            return count(array_intersect(["ADMIN", "SALES", "SUPPORT", "CUSTOMER"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('logs', function($user){
            return count(array_intersect(["ADMIN"], json_decode($user->roles))) ? true :  false;
        });
        Gate::define('router-os', function($user){
            return count(array_intersect(["ADMIN"], json_decode($user->roles))) ? true :  false;
        });
    }
}
