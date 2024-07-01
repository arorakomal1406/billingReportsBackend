<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TokenService;

class TokenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TokenService::class, function ($app) {
            return new TokenService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
