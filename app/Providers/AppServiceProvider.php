<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('manage-users', function ($user) {
             return $user->authorized
                   ? Response::allow()
                   : Response::deny('You must be authorized to manage users.');
         });
 
         Gate::define('manage-data', function ($user) {
             return $user->authorized
                   ? Response::allow()
                   : Response::deny('You must be authorized to manage data.');
         });
    }
}
