<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EditionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\WasteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

Route::middleware(['web'])->group(function () {

    // idioma
    Route::get('locale/{locale}', function ($locale) {
        if (in_array($locale, ['es', 'en', 'fr', 'de', 'it'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
            Cookie::queue(Cookie::make('locale', $locale, 525600));
        }
        return redirect()->back();
    })->name('locale.switch');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Ventas
    Route::prefix('ventas')->name('ventas.')->controller(SaleController::class)->group(function () {
        Route::get('/historial', 'index')->name('index');     
        Route::get('/caja', 'create')->name('create');        
        Route::post('/', 'store')->name('store');                  
        Route::get('/{sale}', 'show')->name('show');         
    });

    // Ediciones
    Route::prefix('inventario')->name('inventario.')->controller(EditionController::class)->group(function () {
        Route::get('/', 'index')->name('index');              
        Route::get('/recepcion', 'create')->name('create');   
        Route::post('/', 'store')->name('store');
        Route::get('/{edition}/edit', 'edit')->name('edit');
        Route::put('/{edition}', 'update')->name('update');              
    });

    // Catálogo
    Route::prefix('catalogo')->name('catalogo.')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('index');              
        Route::get('/crear', 'create')->name('create');       
        Route::post('/', 'store')->name('store');             
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::put('/{product}', 'update')->name('update');
    });

    // Mermas
    Route::prefix('mermas')->name('mermas.')->controller(WasteController::class)->group(function () {
        Route::get('/', 'index')->name('index');              
        Route::get('/registrar', 'create')->name('create');   
        Route::post('/', 'store')->name('store');
        Route::get('/{waste}/edit', 'edit')->name('edit');
        Route::put('/{waste}', 'update')->name('update');              
    });

});