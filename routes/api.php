<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AttrNameController;
use App\Http\Controllers\BuyProductController;
use App\Http\Controllers\RatingProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return response()->json([
        'message' => 'API Crazy Trade Party!'
    ]);
});

Route::post('users', [UserController::class, 'index'])->middleware('auth:api');
Route::get('products', [ProductController::class, 'index']);
Route::get('wishlist', [WishlistController::class, 'index'])->middleware('auth:api');
Route::get('buy', [BuyProductController::class, 'index'])->middleware('auth:api');
Route::get('rating', [RatingProductController::class, 'index']);
Route::get('category', [CategoryController::class, 'index']);


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
Route::get('logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::get('get_user/{slug}', [UserController::class, 'get_user']);
Route::get('user/add_coins/{user_id}/{add_value}', [UserController::class, 'addCoins']);

Route::get('product/getOne/{id}', [ProductController::class, 'getOne']);
Route::get('product/add_viewCount', [ProductController::class, 'addViewsCount']);
Route::post('product/store', [ProductController::class, 'store'])->middleware('auth:api');
Route::post('product/delete', [ProductController::class, 'delete'])->middleware('auth:api');
Route::get('product/user/{slug}', [ProductController::class, 'getUserCreatedProduct'])->middleware('auth:api');

Route::post('wl/add', [WishlistController::class, 'add'])->middleware('auth:api');
Route::get('wl/getUser/{slug}', [WishlistController::class, 'getWLForUser']);
Route::get('wl/user/{slug}/{id_product}', [WishlistController::class, 'user_product_wishlist']);
Route::get('wl/delete/{id}', [WishlistController::class, 'delete'])->middleware('auth:api');

Route::get('buy/user/{slug}', [BuyProductController::class, 'user'])->middleware('auth:api');
Route::get('buy/user/{slug}/{id_product}', [BuyProductController::class, 'user_product']);
Route::post('buy/product', [BuyProductController::class, 'buy'])->middleware('auth:api');

Route::get('rating/absolute', [RatingProductController::class, 'absoluteProduct']);

Route::post('category/create', [CategoryController::class, 'create']);
Route::get('category/{id}/all', [CategoryController::class, 'category']);

Route::get('file/get/{name}', [FileController::class, 'get']);
Route::post('file/upload', [FileController::class, 'store']);
