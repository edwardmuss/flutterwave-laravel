<?php

namespace EdwardMuss\Rave;

use Illuminate\Support\ServiceProvider;

class RaveServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $config = realpath(__DIR__.'/../resources/config/flutterwave.php');

        $this->publishes([
            $config => config_path('flutterwave.php')
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('flutterwave-laravel', function ($app) {
            return new Rave($app->make("request"));
        });

        $this->app->alias('flutterwave-laravel', "EdwardMuss\Rave\Rave");
    }

    /**
    * Get the services provided by the provider
    *
    * @return array
    */
    public function provides()
    {
        return ['flutterwave-laravel'];
    }
}
