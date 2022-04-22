<?php

namespace App\Http\Middleware;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'permissions' => fn() => auth()->guard('admin')->check() ? auth()->guard('admin')->user()->getAllPermissions()->pluck('name') : [],
            'isSuperAdmin' => fn() => auth()->guard('admin')->check() ? auth()->guard('admin')->user()->hasRole('Super Administrador') : false,
            'toast' => fn() => Session::get('toast'),
            'cartTotalItems' => Cart::countItems(),
            'search' => fn() => Session::get('search')
            ? Session::get('search')
            : [
                'year' => date('Y'),
                'make' => null, 'model' => null,
                'engine' => null,
                'category' => null,
                'subcategory' => null,
            ],
        ]);
    }
}
