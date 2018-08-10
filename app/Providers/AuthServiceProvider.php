<?php

namespace SON\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use SON\Models\Admin;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'SON\Model' => 'SON\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * verifica se user é admin para autorizar o acesso ao login
         */
        \Gate::define('admin', function($user){
            return $user->userable instanceof Admin;
        });
    }
}
