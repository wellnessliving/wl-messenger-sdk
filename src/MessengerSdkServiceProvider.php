<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class MessengerSdkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        AboutCommand::add('WellnessLiving Messenger SDK', fn() => ['Version' => '0.0.1']);

        $this->registerConfig();

    }

    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('messengerSdk', function (Application $application) {

            return new MessengerConnector(
                config('wl-messenger.api_url'),
                config('wl-messenger.signature_key'),
                config('wl-messenger.api_version'),
            );
        });
    }

    private function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/wl-messenger.php' => $this->app->configPath('wl-messenger.php'),
        ], 'wl-messenger');

        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/wl-messenger.php', 'wl-messenger');
    }
}
