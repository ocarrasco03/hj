<?php

namespace App\Providers;

use Illuminate\Auth\Events\Logout;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

class ShoppingcartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cart', 'App\Packages\Shoppingcart\Cart');

        $config = __DIR__ . '/../../config/cart.php';
        $this->mergeConfigFrom($config, 'cart');

        $this->publishes([__DIR__ . '/../../config/cart.php' => config_path('cart.php')], 'config');

        $this->app['events']->listen(Logout::class, function() {
            if ($this->app['config']->get('cart.destroy_on_logout')) {
                $this->app->make(SessionManager::class)->forget('cart');
            }
        });

        $this->publishes([
            realpath(__DIR__.'/../../database/migrations') => $this->app->databasePath().'/migrations',
        ], 'migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
