<?php

namespace Dawnstar\FileManager;

use Dawnstar\FileManager\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'FileManagerView');
        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/filemanager/assets')], 'FileManagerPublish');
    }
}

