<?php

use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contacto', [HomeController::class, 'sendContact'])->name('contact.form');
Route::get('/corporativo', [HomeController::class, 'corporate'])->name('corporate');

/**
 * Quick Links
 */
Route::get('/aviso-de-privacidad', [HomeController::class, 'policy'])->name('policy');
Route::get('/politicas-de-garantia-y-devolucion', [HomeController::class, 'warranty'])->name('warranty');
Route::get('/terminos-y-condiciones', [HomeController::class, 'terms'])->name('terms');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
