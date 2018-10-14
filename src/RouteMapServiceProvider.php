<?php

namespace ctf0\RouteMap;

use Illuminate\Support\ServiceProvider;

class RouteMapServiceProvider extends ServiceProvider
{
    protected $file;

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->file = $this->app['files'];

        $this->packagePublish();

        // append extra data
        if (!$this->app['cache']->store('file')->has('ct-route-map')) {
            $this->autoReg();
        }
    }

    /**
     * [packagePublish description].
     *
     * @return [type] [description]
     */
    protected function packagePublish()
    {
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
     * [autoReg description].
     *
     * @return [type] [description]
     */
    protected function autoReg()
    {
        // routes
        $route_file = base_path('routes/web.php');
        $search     = 'RouteMap';

        if ($this->checkExist($route_file, $search)) {
            $data = "\n// RouteMap\nctf0\RouteMap\RouteMap::routes();";

            $this->file->append($route_file, $data);
        }

        // mix
        $mix_file = base_path('webpack.mix.js');
        $search   = 'RouteMap';

        if ($this->checkExist($mix_file, $search)) {
            $data = "\n// RouteMap\nmix.sass('resources/assets/vendor/RouteMap/sass/style.scss', 'public/assets/vendor/RouteMap/style.css')";

            $this->file->append($mix_file, $data);
        }

        // run check once
        $this->app['cache']->store('file')->rememberForever('ct-route-map', function () {
            return 'added';
        });
    }

    /**
     * [checkExist description].
     *
     * @param [type] $file   [description]
     * @param [type] $search [description]
     *
     * @return [type] [description]
     */
    protected function checkExist($file, $search)
    {
        return $this->file->exists($file) && !str_contains($this->file->get($file), $search);
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
