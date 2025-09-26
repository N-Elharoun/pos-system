<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController;

Route::redirect('/','admin/home');

Route::group(['prefix'=>'admin','as'=>'admin.'], function() {
    Auth::routes();
    Route::group(['middleware'=>'auth'], function (){
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('users',UserController::class);
    });
});