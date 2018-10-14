<?php

return [
    /*
     * hide methods of type.
     */
    'hide_methods' => [
        'HEAD',
        'PATCH',
    ],

    /*
     * method type background class
     */
    'method_colours' => [
        'GET'    => 'is-primary',
        'HEAD'   => 'is-light',
        'POST'   => 'is-info',
        'PUT'    => 'is-warning',
        'PATCH'  => 'is-warning',
        'DELETE' => 'is-danger',
    ],

    /*
     * ignore routes that has the following in its url
     */
    'ignore_uri' => '/^(opcache-api|_debugb.*)/',

    /*
     * dont convert urls with this chars to a link
     */
    'dont_link' => [
        '{',
        'api',
    ],

    /*
     * which editor to open the controller in
     * this follows the same pattern as "whoops"
     */
    'editor' => 'sublime',
];
