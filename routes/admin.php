<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\Sales\OrdersController;
use App\Http\Controllers\Cms\Settings\UsersController;
use App\Http\Controllers\Cms\Support\PromptController;
use App\Http\Controllers\Cms\Support\TicketsController;
use App\Http\Controllers\Cms\Auth\NewPasswordController;
use App\Http\Controllers\Cms\Auth\VerifyEmailController;
use App\Http\Controllers\Cms\Catalogs\ProductController;
use App\Http\Controllers\Cms\Customers\CustomersController;
use App\Http\Controllers\Cms\Auth\PasswordResetLinkController;
use App\Http\Resources\Cms\Exports\Catalogs\ProductCollection;
use App\Http\Controllers\Cms\Settings\General\SliderController;
use App\Http\Controllers\Cms\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Cms\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Cms\Settings\RolesPermissionsController;
use App\Http\Controllers\Cms\Settings\SystemInformationController;
use App\Http\Controllers\Cms\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Cms\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Cms\Support\LogViewerController;

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
        Route::controller(ProductController::class)
            ->prefix('productos')->name('products.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/nuevo-producto', 'create')->name('create');
            Route::post('/nuevo-producto', 'store')->name('store');
            Route::get('/{product}', 'show')->name('show');
            Route::put('/{product}', 'update')->name('update');
            Route::delete('/{product}', 'destroy')->name('delete');
            Route::put('/restore/{product}', 'restore')->name('restore');
            Route::post('/upload/{product}', 'upload')->name('upload.file');
            Route::delete('/remove/{product}/{id}', 'remove')->name('remove.file');
        });
        // Route::get('/export', [ProductController::class,'export'])->name('products.export');
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
        Route::name('customer.')->controller(CustomersController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{customer}', 'show')->name('show');
            Route::delete('/{customer}', 'destroy')->name('delete');
            Route::put('/{customer}', 'restore')->name('restore');
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
        Route::prefix('tickets')->name('ticket.')->controller(TicketsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{ticket}', 'show')->name('show');
        });
        Route::get('logs', [LogViewerController::class, 'index'])->name('logs');
        Route::get('logs/crypt', [LogViewerController::class, 'crypt'])->name('logs.crypt');
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
        Route::prefix('general')->name('general.')->group(function () {
            Route::prefix('tienda')->name('store.')->group(function () {
                # code...
            });
            Route::prefix('seo')->name('seo.')->group(function () {
                # code...
            });
            Route::prefix('etiquetas')->name('tags.')->group(function () {
                # code...
            });
            Route::prefix('busqueda')->name('search.')->group(function () {
                # code...
            });
            Route::prefix('slider')->name('slider.')->controller(SliderController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/agregar-imagen/{slider}', 'store')->name('store');
                Route::put('/actualizar/{slider}', 'update')->name('update');
                Route::delete('/eliminar/{slider}/{uuid}', 'destroy')->name('delete');
            });
        });
        /*
        |--------------------------------------------------------------------------
        | Advanced Settings Routes
        |--------------------------------------------------------------------------
        |
         */
        Route::prefix('avanzado')->name('advanced.')->group(function () {
            Route::prefix('usuarios')->controller(UsersController::class)->name('users.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/nuevo', 'create')->name('create');
                Route::post('/nuevo', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::post('/{user}', 'update')->name('update');
                Route::delete('/{user}', 'destroy')->name('delete');
                Route::put('/restaurar/{user}', 'restore')->name('restore');
                Route::post('/', 'resetPassword')->name('password.email');
            });
            Route::prefix('roles-y-permisos')->controller(RolesPermissionsController::class)->name('roles.permissions.')->group(function () {
                Route::get('/', 'index')
                    ->middleware(['permission:role.read|permission.read'])
                    ->name('index');
                Route::post('/nuevo-rol', 'store')
                    ->middleware(['permission:role.create'])
                    ->name('save.role');
                Route::post('/nuevo-permiso', 'storePermission')
                    ->middleware(['role_or_permission:permission.create|Super Administrador'])
                    ->name('save.permission');
                Route::put('/{rol}/asignar-permisos', 'update')
                    ->middleware(['permission:permission.update'])
                    ->name('update.permissions');
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
