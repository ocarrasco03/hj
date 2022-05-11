<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Mail\ContactForm;
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

Route::get('email', function () {
    // return new UserRegisteredMail();
    return new ContactForm(['name' => 'Oscar Carrasco', 'email' => 'ocarrasco@hjautopartes.com.mx', 'subject' => 'Contacto', 'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas consequat luctus ultrices. Etiam eleifend augue et massa vestibulum, non aliquet mauris gravida. Fusce porta dapibus libero in fermentum. Suspendisse hendrerit auctor lorem, vel malesuada erat scelerisque ac. Mauris auctor posuere arcu, ut congue dui ultricies faucibus. Sed lobortis pretium tempor. Donec metus nisi, bibendum sit amet dictum ut, consequat nec justo. Phasellus ultricies lorem in sem porta commodo. Vestibulum non risus sed turpis egestas suscipit. Pellentesque laoreet metus sit amet fringilla semper. Proin in pulvinar nisl. Morbi at metus fel', 'phone' => '6621043512']);
});

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
    Route::get('mi-perfil')->name('profile');

    Route::name('profile.')->prefix('mi-perfil')->group(function () {
        Route::get('mis-pedidos')->name('orders');
        Route::get('mis-pedidos/{id}')->name('order.show');
        Route::delete('mis-pedidos/{id}')->name('order.cancel');
    });

    Route::controller(CartController::class)->prefix('mi-carrito')->group(function () {
        Route::get('/', 'index')->name('cart');
        Route::name('cart.')->group(function () {
            Route::post('/', 'store')->name('store');
            Route::put('/', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
            Route::get('/envio','shipping')->name('shipping');
            Route::post('/pedido','processOrder')->name('process.order');
            Route::get('/pedido/pagar','checkout')->name('checkout');
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
