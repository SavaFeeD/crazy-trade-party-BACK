<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;

Route::get('/', function () {
    return response()->json([
        'message' => 'Work!'
    ]);
});

Route::post('users', [UserController::class, 'index'])->middleware('auth:api');
Route::get('products', [ProductController::class, 'index']);

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
Route::get('logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::get('get_user/{slug}', [UserController::class, 'get_user']);

Route::post('add_viewCount', [ProductController::class, 'addViewsCount']);

Route::post('add_to_wl', [WishlistController::class, 'add']);
Route::get('getWL/{user_id}', [WishlistController::class, 'getWL']);
