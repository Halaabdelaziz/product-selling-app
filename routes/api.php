<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CustomAuthController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout',[CustomAuthController::class,'CustomLogout']);
    Route::patch('users',[UserController::class,'update']);
    Route::get('user-products',[ProductController::class,'getUserProducts']);
});


Route::post('login',[CustomAuthController::class,'CustomLogin']);

Route::post('users',[UserController::class,'store']);

Route::get('products',[ProductController::class,'index']);
Route::post('products',[ProductController::class,'store']);
Route::PUT('products/{id}',[ProductController::class,'update']);
Route::delete('products/{id}',[ProductController::class,'destroy']);
