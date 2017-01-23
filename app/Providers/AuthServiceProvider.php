<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Pizza'     => 'App\Policies\PizzaPolicy',
        'App\Order'     => 'App\Policies\OrderPolicy',
        'App\User'      => 'App\Policies\UserPolicy',
        'App\Topping'   => 'App\Policies\ToppingPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
