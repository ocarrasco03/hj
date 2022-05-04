<?php

use App\Http\Controllers\Api\VehiclesController;
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
    Route::get('years', [SearchController::class, 'getYears'])->name('years');
    Route::get('makes', [SearchController::class, 'getMakes'])->name('makes');
    Route::get('models/{year}/{make}', [SearchController::class, 'getModels'])->name('models');
    Route::get('engines', [SearchController::class, 'getEngines'])->name('engines');
    Route::get('categories', [SearchController::class, 'getCategories'])->name('categories');
    Route::get('subcategories/{parent}', [SearchController::class, 'getSubCategories'])->name('subcategories');

    Route::controller(VehiclesController::class)->prefix('vehiculos')->name('vehicles.')->group(function () {
        Route::get('years', 'years')->name('year.names');
        Route::get('makes', 'makes')->name('makes');
        Route::get('make-names', 'makeNames')->name('makes.names');
        Route::get('models', 'modelNames')->name('models.names');
        Route::get('models/{make}', 'modelNamesByMake')->name('models.make');
        Route::get('models/{make}/{year}', 'modelNamesByAppliaction')->name('models.application');
    });

});
