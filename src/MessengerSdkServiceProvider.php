<?php

namespace WellnessLiving\MessengerSdk;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class MessengerSdkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /*
        * Optional methods to load your package assets
        */

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'wl-messenger-api-sdk');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'wl-messenger-api-sdk');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('messenger-sdk.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/wl-messenger-api-sdk'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/wl-messenger-api-sdk'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/wl-messenger-api-sdk'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'messenger-sdk');

        // Register the main class to use with the facade
        $this->app->singleton('messengerSdk', function (Application $application) {

            return new MessengerConnector(
                config('messenger-sdk.messenger_api_url'),
                config('messenger-sdk.messenger_access_key'),
            );
        });
    }


}