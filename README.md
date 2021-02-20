<h1 align="center">
    RouteMap
    <br>
    <a href="https://packagist.org/packages/ctf0/route-map"><img src="https://img.shields.io/packagist/v/ctf0/route-map.svg" alt="Latest Stable Version" /></a> <a href="https://packagist.org/packages/ctf0/route-map"><img src="https://img.shields.io/packagist/dt/ctf0/route-map.svg" alt="Total Downloads" /></a>
</h1>

<p align="center">
    <img alt="main" src="https://user-images.githubusercontent.com/7388088/46914425-12b25d00-cfa6-11e8-8a80-6a4b8a5548ad.jpg"/>
</p>

- package requires Laravel v5.4+

<br>

## Installation

- `composer require ctf0/route-map`

- (Laravel < 5.5) add the service provider & facade

    ```php
    'providers' => [
        ctf0\RouteMap\RouteMapServiceProvider::class,
    ];
    ```

- publish the package assets with

    `php artisan vendor:publish --provider="ctf0\RouteMap\RouteMapServiceProvider"`

- after installation, run `php artisan rm:setup` to add
    + package routes to `routes/web.php`
    + package assets compiling to `webpack.mix.js`

- install dependencies

    ```bash
    yarn add vue vue-awesome@v2
    ```

- add this one liner to your main js file and run `npm run watch` to compile your `js/css` files.
    + if you are having issues [Check](https://ctf0.wordpress.com/2017/09/12/laravel-mix-es6/).

    ```js
    // app.js

    window.Vue = require('vue')

    require('../vendor/RouteMap/js/manager')

    new Vue({
        el: '#app'
    })
    ```

<br>

## Features

- list all app routes.
- filter routes by
    + Group
    + Methods
    + Domain
    + Url
    + Name
    + Action
    + Middleware
- collapse/expand all groups at once
- show/hide specific grouped routes
- quickly scroll to start/end of the routes list
- quickly open controller files in your favorite editor

<br>

## Usage

- visit `localhost:8000/route-map`

### Security

If you discover any security-related issues, please email [ctf0-dev@protonmail.com](mailto:ctf0-dev@protonmail.com).
