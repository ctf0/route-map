<?php

namespace ctf0\RouteMap;

class RouteMap
{
    protected $editors = [
        'sublime'  => 'subl://open?url=file://',
        'textmate' => 'txmt://open?url=file://',
        'emacs'    => 'emacs://open?url=file://',
        'macvim'   => 'mvim://open/?url=file://',
        'phpstorm' => 'phpstorm://open?file=',
        'idea'     => 'idea://open?file=',
        'vscode'   => 'vscode://file/',
        'atom'     => 'atom://core/open/file?filename=',
    ];

    /**
     * check if url should be clickable.
     *
     * @param [type] $method [description]
     * @param [type] $url    [description]
     *
     * @return bool [description]
     */
    public function isUrl($method, $url)
    {
        return in_array('GET', $method) && !str_contains($url, config('route-map.dont_link'));
    }

    /**
     * prepare controller url.
     *
     * @param [type] $file [description]
     *
     * @return [type] [description]
     */
    public function getUrl($file)
    {
        $class = preg_replace('/@.*/', '', $file);              // remove the @method
        $path  = (new \ReflectionClass($class))->getFileName(); // get the full path

        return $this->editors[config('route-map.editor')] . rawurlencode($path) . '&line=0'; // generate the url
    }

    /**
     * package routes.
     *
     * @return [type] [description]
     */
    public static function routes()
    {
        app('router')->get('route-map', '\ctf0\RouteMap\Controllers\RouteMapController@index')->name('route-map');
    }
}
