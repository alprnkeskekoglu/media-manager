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
        //
    }
}

