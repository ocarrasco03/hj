<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Session::exists('search')) {
            Session::put('search', [
                'year' => null,
                'make' => null,
                'model' => null,
                'engine' => null,
                'category' => null,
                'subcategory' => null
            ]);
        }
    }
}
