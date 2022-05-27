<?php

use Inertia\Inertia;
use App\Mail\ContactForm;
use App\Models\Sales\Order;
use App\Mail\Cart\OrderCreated;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Profile\AddressesController;
use App\Http\Controllers\Profile\ChangePasswordController;
use App\Http\Controllers\Profile\ProfileController;
use App\Jobs\Orders\NotifyUserOrderPlaced;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------
|
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contacto', [HomeController::class, 'sendContact'])->name('contact.form');
Route::get('/corporativo', [HomeController::class, 'corporate'])->name('corporate');

/*
|--------------------------------------------------------------------------
| Products Routes
|--------------------------------------------------------------------------
|
 */
Route::get('/producto/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/buscar', [SearchController::class, 'index'])->name('product.search');

/*
|--------------------------------------------------------------------------
| Quick Links
|--------------------------------------------------------------------------
|
 */
Route::get('/aviso-de-privacidad', [HomeController::class, 'policy'])->name('policy');
Route::get('/politicas-de-garantia-y-devolucion', [HomeController::class, 'warranty'])->name('warranty');
Route::get('/terminos-y-condiciones', [HomeController::class, 'terms'])->name('terms');

/*
|--------------------------------------------------------------------------
| Routes must be authenticated
|--------------------------------------------------------------------------
|
 */

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::prefix('mi-perfil')->group(function () {
        Route::get('/', [ProfileController::class, '__invoke'])->name('profile');
        Route::name('profile.')->group(function () {
            Route::get('cambiar-contrasena', [ChangePasswordController::class, '__invoke'])->name('change.password');
            Route::post('cambiar-contrasena', [ChangePasswordController::class, 'store'])->name('change.password');

            Route::put('actualizar', [ProfileController::class, 'store'])->name('update');
            Route::prefix('mis-direcciones')->controller(AddressesController::class)->group(function () {
                Route::get('/', '__invoke')->name('address');
                Route::name('address.')->group(function () {
                    Route::post('/agregar', 'store')->name('store');
                    Route::get('/asignar/{id}/{type?}','setAddress')->name('set');
                });
            });

            Route::get('mis-pedidos')->name('orders');
            Route::get('mis-pedidos/{id}')->name('order.show');
            Route::delete('mis-pedidos/{id}')->name('order.cancel');
        });
    });

    Route::controller(CartController::class)->prefix('mi-carrito')->group(function () {
        Route::get('/', 'index')->name('cart');
        Route::name('cart.')->group(function () {
            Route::post('/', 'store')->name('store');
            Route::put('/', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
            Route::get('/envio','shipping')->name('shipping');
            Route::post('/pedido','processOrder')->name('process.order');
            Route::get('/pedido/{order}/pagar','checkout')->name('checkout');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
 */
require __DIR__ . '/auth.php';
