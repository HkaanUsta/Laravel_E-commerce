<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[\App\Http\Controllers\authController::class, 'login']);
Route::post('register',[\App\Http\Controllers\authController::class, 'register']);

//discount
Route::post('discount/create',[\App\Http\Controllers\discountController::class, 'add']);
Route::get('discount',[\App\Http\Controllers\discountController::class, 'list']);
Route::post('discount/delete/{id}',[\App\Http\Controllers\discountController::class, 'delete']);

//categories
Route::post('category/create',[\App\Http\Controllers\categoryController::class, 'add']);
Route::post('category/update',[\App\Http\Controllers\categoryController::class, 'update']);
Route::get('categories',[\App\Http\Controllers\categoryController::class, 'list']);
Route::get('category/delete/{id}',[\App\Http\Controllers\categoryController::class, 'delete']);

//product
Route::post('product/create',[\App\Http\Controllers\productController::class, 'add']);
Route::post('product/update',[\App\Http\Controllers\productController::class, 'update']);
Route::get('product',[\App\Http\Controllers\productController::class, 'list']);
Route::get('product/delete/{id}',[\App\Http\Controllers\productController::class, 'delete']);
Route::post('product/addcart',[\App\Http\Controllers\productController::class, 'addcart']);
Route::post('product/addcart/order',[\App\Http\Controllers\productController::class, 'order']);
Route::post('product/addcart/order/cancel',[\App\Http\Controllers\productController::class, 'cancelOrder']);
Route::post('product/addcart/order/allcancel',[\App\Http\Controllers\productController::class, 'allCancelOrder']);

//cart
Route::get('cart/{$id}',[\App\Http\Controllers\cartController::class, 'list']);
Route::get('cart/delete/{$id}',[\App\Http\Controllers\cartController::class, 'delete']);

