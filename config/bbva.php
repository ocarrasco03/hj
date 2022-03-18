<?php

return [

    /*
    |--------------------------------------------------------------------------
    | BBVA API module is enabled
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | BBVA API environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'production' => (bool) env('BBVA_PRODUCTION_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | Destroy the cart on user logout
    |--------------------------------------------------------------------------
    |
    | When this option is set to 'true' the cart will automatically
    | destroy all cart instances when the user logs out.
    |
    */

    'merchant_id' => env('BBVA_MERCHANT_ID', ''),

    'affiliate' => env('BBVA_AFFILIATE', ''),

    /*
    |--------------------------------------------------------------------------
    | Default number format
    |--------------------------------------------------------------------------
    |
    | This defaults will be used for the formated numbers if you don't
    | set them in the method call.
    |
    */

    'private_key' => env('BBVA_PRIVATE_KEY', ''),
    'public_key' => env('BBVA_PUBLIC_KEY', ''),

];
