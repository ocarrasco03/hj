<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Application CDN enables
    |--------------------------------------------------------------------------
    |
    | Specify if cdn is enabled
    |
    */

    "enabled" => env("CDN_ENABLED", true),

    /*
    |--------------------------------------------------------------------------
    | Application CDN domains
    |--------------------------------------------------------------------------
    |
    | Specify different domains for your assets.
    |
    */

    "domains" => [
        "cdn.hjautopartes.com.mx" => "css|js|eot|woff|ttf",
        "img.hjautopartes.com.mx" => "jpg|jpeg|png|gif|svg",
        "all.hjautopartes.com.mx" => ""
    ],

    /*
    |--------------------------------------------------------------------------
    | CDN protocols
    |--------------------------------------------------------------------------
    |
    | Specify CDN protocol
    |
    */

    "protocol" => env("CDN_PROTOCOL", "http"),
];
