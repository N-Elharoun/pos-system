<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::get('items', [ItemController::class, 'index']);
    Route::post('items', [ItemController::class, 'store']);
    Route::get('items/{item}', [ItemController::class, 'show']);
    Route::put('items/{item}', [ItemController::class, 'update']);
    Route::delete('items/{item}', [ItemController::class, 'destroy']);
});
