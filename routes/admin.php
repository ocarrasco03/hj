<?php

use App\Http\Controllers\Cms\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Cms\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Cms\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Cms\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Cms\Auth\NewPasswordController;
use App\Http\Controllers\Cms\Auth\PasswordResetLinkController;
use App\Http\Controllers\Cms\Auth\VerifyEmailController;
use App\Http\Controllers\Cms\Catalogs\ProductController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\Sales\OrdersController;
use App\Http\Controllers\Cms\Settings\RolesPermissionsController;
use App\Http\Controllers\Cms\Settings\SystemInformationController;
use App\Http\Controllers\Cms\Settings\UsersController;
use App\Http\Controllers\Cms\Support\PromptController;
use Illuminate\Support\Facades\Route;

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
| Authentication Routes
|--------------------------------------------------------------------------
|
 */
Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------
|
 */

Route::middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('ventas')->name('sales.')->group(function () {
        Route::prefix('pedidos')->name('orders.')->group(function () {
            Route::get('/', [OrdersController::class, 'index'])->name('index');
            Route::get('/{order}', [OrdersController::class, 'show'])->name('show');
        });
    });

    Route::prefix('catalogos')->name('catalogs.')->group(function () {
        Route::prefix('productos')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        });
        Route::prefix('paquetes')->name('bundles.')->group(function () {
            //
        });
        Route::prefix('categorias')->name('categories.')->group(function () {
            //
        });
        Route::prefix('vehiculos')->name('vehicles.')->group(function () {
            //
        });
        Route::prefix('archivos')->name('media.')->group(function () {
            //
        });
    });

    Route::prefix('clientes')->name('customers.')->group(function () {
        Route::name('customer.')->group(function () {
            //
        });
        Route::prefix('direcciones')->name('addresses.')->group(function () {
            //
        });
        Route::prefix('servicio-al-cliente')->name('customer.service.')->group(function () {
            //
        });
    });

    Route::prefix('estadisticas')->name('analytics.')->group(function () {
        //
    });

    Route::prefix('modulos')->name('modules.')->group(function () {
        //
    });

    Route::prefix('soporte')->name('support.')->group(function () {
        Route::post('/terminal', [PromptController::class, 'exeCommand'])->name('console.exec');
        Route::get('/terminal', [PromptController::class, 'index'])->name('console');
    });

    /*
    |--------------------------------------------------------------------------
    | Settings Routes
    |--------------------------------------------------------------------------
    |
     */
    Route::prefix('configuracion')->name('settings.')->group(function () {
        Route::get('informacion-del-sistema', [SystemInformationController::class, 'index'])->name('info');

        /*
        |--------------------------------------------------------------------------
        | General Settings Routes
        |--------------------------------------------------------------------------
        |
         */

        /*
        |--------------------------------------------------------------------------
        | Advanced Settings Routes
        |--------------------------------------------------------------------------
        |
         */
        Route::prefix('avanzado')->name('advanced.')->group(function () {
            Route::prefix('usuarios')->name('users.')->group(function () {
                Route::get('/', [UsersController::class, 'index'])->name('index');
                Route::get('/nuevo', [UsersController::class, 'create'])->name('create');
                Route::post('/nuevo', [UsersController::class, 'store'])->name('store');
                Route::get('/{id}', [UsersController::class, 'show'])->name('show');
                Route::put('/{id}', [UsersController::class, 'update'])->name('update');
                Route::delete('/{user}', [UsersController::class, 'destroy'])->name('delete');
                Route::put('/{user}', [UsersController::class, 'restore'])->name('restore');
                Route::post('/', [UsersController::class, 'resetPassword'])->name('password.email');
            });
            Route::prefix('roles-y-permisos')->name('roles.permissions.')->group(function () {
                Route::get('/', [RolesPermissionsController::class, 'index'])->middleware(['permission:role.read|permission.read'])->name('index');
                Route::post('/nuevo-rol', [RolesPermissionsController::class, 'store'])->middleware(['permission:role.create'])->name('save.role');
                Route::post('/nuevo-permiso', [RolesPermissionsController::class, 'storePermission'])->middleware(['role_or_permission:permission.create|Super Administrador'])->name('save.permission');
                Route::put('/{rol}/asignar-permisos', [RolesPermissionsController::class, 'update'])->middleware(['permission:permission.update'])->name('update.permissions');
            });
            Route::prefix('importar')->name('import.')->group(function () {
                //
            });
            Route::prefix('exportar')->name('export.')->group(function () {
                //
            });
            Route::prefix('respaldos')->name('backup.')->group(function () {
                //
            });
        });
    });

});
