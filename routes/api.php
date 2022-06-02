<?php

use App\Http\Controllers\Api\AutocompleteController;
use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\CountriesController;
use App\Http\Controllers\Api\NeighborhoodsController;
use App\Http\Controllers\Api\StatesController;
use App\Http\Controllers\Api\VehiclesController;
use App\Http\Controllers\Api\ZipCodesController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {
    Route::get('engines', [SearchController::class, 'getEngines'])->name('engines');

    Route::prefix('v2')->name('v2.')->group(function () {
        Route::get('countries', [CountriesController::class, '__invoke'])->name('countries');
        Route::get('states/{country?}', [StatesController::class, '__invoke'])->name('states');
        Route::get('cities/{country?}/{state?}', [CitiesController::class, '__invoke'])->name('cities');
        Route::get('zip-codes/{country}/{state}/{city?}', [ZipCodesController::class, '__invoke'])->name('zip.code');
        Route::get('neighborhood/{zip_code}', [NeighborhoodsController::class, '__invoke'])->name('neighborhood');

        Route::controller(VehiclesController::class)->prefix('vehicles')->name('vehicles.')->group(function () {
            Route::get('years', 'years')->name('years');
            Route::get('makes', 'makes')->name('makes');
            Route::get('models/{make?}/{year?}', 'models')->name('models');
            Route::get('categories/{category?}', 'categories')->name('categories');
        });

        Route::controller(AutocompleteController::class)->prefix('autocomplete')->name('autocomplete.')->group(function () {
            Route::get('city/{country?}/{state?}', 'cities')->name('city');
            Route::get('zip-codes/{country}/{state}/{city?}', 'zipCodes')->name('zip.code');
            Route::get('neighborhood/{zip_code?}', 'neighborhood')->name('neighborhood');
        });
    });

});
