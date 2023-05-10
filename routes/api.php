<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
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
Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
]);

Route::resource('product', ProductController::class)->only([
    'show', 'store', 'update'
]);
Route::get('/products', [ProductController::class, 'allProducts']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
