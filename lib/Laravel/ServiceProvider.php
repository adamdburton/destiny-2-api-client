<?php

namespace AdamDBurton\Destiny2ApiClient\Laravel;

use AdamDBurton\Destiny2ApiClient\Api;
use AdamDBurton\Destiny2ApiClient\Laravel\Commands\CacheManifest;
use AdamDBurton\Destiny2ApiClient\Laravel\Commands\ClearManifest;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../resources/config.php' => config_path('destiny.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../resources/config.php', 'destiny'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                CacheManifest::class,
                ClearManifest::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton('destiny', function($app)
        {
            return (new Api)->withConfig(config('destiny'));
        });
    }
}