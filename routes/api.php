<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AttrNameController;

Route::get('/', function () {
    return response()->json([
        'message' => 'API Crazy Trade Party!'
    ]);
});

Route::post('users', [UserController::class, 'index'])->middleware('auth:api');
Route::get('products', [ProductController::class, 'index']);

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
Route::get('logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::get('get_user/{slug}', [UserController::class, 'get_user']);

Route::get('product/getOne/{id}', [ProductController::class, 'getOne']);
Route::post('product/add_viewCount', [ProductController::class, 'addViewsCount']);
Route::get('product/attr/createName', [AttrNameController::class, 'store']);

Route::post('wl/add', [WishlistController::class, 'add']);
Route::get('wl/getUser/{slug}', [WishlistController::class, 'getWLForUser']);
Route::get('wl/delete/{id}', [WishlistController::class, 'delete']);


