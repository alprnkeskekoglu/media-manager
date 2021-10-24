<?php

namespace Dawnstar\MediaManager;

use Dawnstar\MediaManager\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
       // include_once base_path('vendor/dawnstar/media-manager/src/Http/helpers.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'MediaManager');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'MediaManager');

        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/media-manager/assets')], 'media-manager-assets');
    }
}

