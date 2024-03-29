<?php

namespace Dawnstar\MediaManager\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapPanelRoutes();
        $this->mapWebRoutes();
    }

    protected function mapPanelRoutes()
    {
        Route::group(['middleware' => 'web', 'prefix' => 'dawnstar/media-manager', 'as' => 'media_manager.'], function ($router) {
            require __DIR__ . '/../Routes/panel.php';
        });
    }

    protected function mapWebRoutes()
    {
        Route::group(['middleware' => 'web'], function ($router) {
            require __DIR__ . '/../Routes/web.php';
        });
    }
}
