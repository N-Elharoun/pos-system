<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;

Route::redirect('/', 'admin/home');

Route::group(['prefix' => 'admin','as' => 'admin.'], function () {
    Auth::routes();
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::resource('units', UnitController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('items', ItemController::class);
    });
});
