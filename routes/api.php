<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\SubTypeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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

Route::get('/test', function () {
   return response()->json([
       'status' => 200,
       'message' => 'success',
       'data' => [
           'test' => 'Halo API'
       ]
   ]);
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('product_list');
    Route::get('/{productId}', [ProductController::class, 'show'])->name('product_show');
    Route::get('/best-seller', [ProductController::class, 'bestSeller'])->name('product_best_seller');
    Route::post('/', [ProductController::class, 'save'])->name('product_save');
    Route::put('/{productId}', [ProductController::class, 'update'])->name('product_update');
    Route::delete('/{productId}', [ProductController::class, 'delete'])->name('product_delete');
});

Route::group(['prefix' => 'type-product'], function () {
    Route::get('/', [TypeController::class, 'index'])->name('type_list');
    Route::post('/', [TypeController::class, 'save'])->name('type_save');
    Route::put('/{typeId}', [TypeController::class, 'update'])->name('type_update');
    Route::delete('/{typeId}', [TypeController::class, 'delete'])->name('type_delete');
});

Route::group(['prefix' => 'sub-type-product'], function () {
    Route::get('/', [SubTypeController::class, 'index'])->name('sub_type_list');
    Route::post('/', [SubTypeController::class, 'save'])->name('sub_type_save');
    Route::put('/{subTypeId}', [SubTypeController::class, 'update'])->name('sub_type_update');
    Route::delete('/{subTypeId}', [SubTypeController::class, 'delete'])->name('sub_type_delete');
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index'])->name('cart_list');
    Route::post('/', [CartController::class, 'save'])->name('cart_save');
    Route::post('/delete', [CartController::class, 'delete'])->name('cart_delete');
});

Route::group(['prefix' => 'order'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('order_list');
    Route::post('/checkout', [OrderController::class, 'save'])->name('order_save');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order_detail');
});
