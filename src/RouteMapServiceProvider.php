<?php

namespace ctf0\RouteMap;

use Illuminate\Support\ServiceProvider;
use ctf0\RouteMap\Commands\PackageSetup;

class RouteMapServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->packagePublish();
        $this->command();
    }

    /**
     * [packagePublish description].
     *
     * @return [type] [description]
     */
    protected function packagePublish()
    {
        // config
        $this->publishes([
            __DIR__ . '/config' => config_path(),
        ], 'config');

        // resources
        $this->publishes([
            __DIR__ . '/resources/assets' => resource_path('assets/vendor/RouteMap'),
        ], 'assets');

        // views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'RouteMap');
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/RouteMap'),
        ], 'views');
    }

    /**
     * package commands.
     *
     * @return [type] [description]
     */
    protected function command()
    {
        $this->commands([
            PackageSetup::class,
        ]);
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        $this->app->singleton('route-map', function () {
            return new RouteMap();
        });
    }
}
