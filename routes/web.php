<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\settings\GeneralSettingsController;
use App\Http\Controllers\Admin\settings\AdvancedSettingsController;

Route::redirect('/', 'admin/home');

Route::group(['prefix' => 'admin','as' => 'admin.'], function () {
    Auth::routes();
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::resource('units', UnitController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('items', ItemController::class);
        Route::resource('clients', ClientController::class);
        Route::get('clients/{client}/balance', [ClientController::class,'balance'])->name('clients.balance');
        Route::put('clients/{client}/balance', [ClientController::class,'updateBalance'])
        ->name('clients.updateBalance');
        Route::resource('sales', SaleController::class)->except(['edit', 'update', 'destroy']);
        Route::resource('warehouses', WarehouseController::class);
        Route::get('warehouses/{warehouse}/inventory', [WarehouseController::class,'inventory'])
            ->name('warehouses.inventory');
        Route::put('warehouses/{warehouse}/inventory', [WarehouseController::class,'updateInventory'])
            ->name('warehouses.updateInventory');
        Route::get('/stocks/low', [StockController::class,'lowStock'])->name('stocks.low');
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/general', [GeneralSettingsController::class, 'view'])->name('general.view');
            Route::put('/general', [GeneralSettingsController::class, 'update'])->name('general.update');
            Route::get('/advanced', [AdvancedSettingsController::class, 'view'])->name('advanced.view');
            Route::put('/advanced', [AdvancedSettingsController::class, 'update'])->name('advanced.update');
        });
    });
});
