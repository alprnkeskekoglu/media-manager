<?php

namespace Dawnstar\FileManager;

use Dawnstar\FileManager\Providers\RouteServiceProvider;
use Dawnstar\FileManager\Providers\ConfigServiceProvider;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->register(ConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'FileManagerLang');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'FileManagerView');
        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/filemanager/assets')], 'FileManagerPublish');
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }
}

