<?php

namespace ctf0\RouteMap\Controllers;

use App\Http\Controllers\Controller;

class RouteMapController extends Controller
{
    protected $ignore_pattern;
    protected $hide_methods;

    public function index()
    {
        $config               = config('route-map');
        $this->ignore_pattern = array_get($config, 'ignore_uri');
        $this->hide_methods   = array_get($config, 'hide_methods');
        $method_colours       = array_get($config, 'method_colours');

        $routes      = app('router')->getRoutes();
        $total       = count($routes);
        $routes_list = $this->groupSimilar($routes, 'uri', '/');

        $middlewareClosure = function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        };

        return view('RouteMap::routes', compact(
                'method_colours',
                'total',
                'routes_list',
                'middlewareClosure'
            )
        );
    }

    protected function groupSimilar($array, $fieldName, $similarity)
    {
        $crntLocale = app()->getLocale();
        $list       = [];

        foreach ($array as $one) {
            $field        = $one->$fieldName();
            $one->methods = array_diff($one->methods, $this->hide_methods);

            // for multi locale
            $field = preg_replace('/^(\/)?' . $crntLocale . '\//', '', $field);

            // loop
            if (str_contains($field, $similarity)) {
                $found = strstr($field, $similarity, true);

                if (preg_match('/^' . $found . '/', $field)) {
                    $list[$found ?: '/'][] = $one;
                } else {
                    $list[$field ?: '/'][] = $one;
                }
            } else {
                $list[$field][] = $one;
            }
        }

        $ignore_pattern = $this->ignore_pattern;

        if ($ignore_pattern) {
            $keys = preg_grep($ignore_pattern, array_keys($list));

            foreach ($keys as $key) {
                unset($list[$key]);
            }
        }

        return $list;
    }
}
