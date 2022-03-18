<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('mi-perfil')->name('profile');

    Route::name('profile.')->prefix('mi-perfil')->group(function() {
        Route::get('mis-pedidos')->name('orders');
        Route::get('mis-pedidos/{id}')->name('order.show');
        Route::delete('mis-pedidos/{id}')->name('order.cancel');
    });

    Route::get('/mi-carrito', [CartController::class, 'index'])->name('cart');
    Route::put('/mi-carrito', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/mi-carrito/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    // Route::resource('cart', CartController::class);
// });

/*
 |--------------------------------------------------------------------------
 | Authentication Routes
 |--------------------------------------------------------------------------
 |
 */
require __DIR__.'/auth.php';
