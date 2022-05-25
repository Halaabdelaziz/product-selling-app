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
    // route to update login user info
    Route::patch('user',[UserController::class,'update']);
    // route to get user products
    Route::get('user-products',[ProductController::class,'getUserProducts']);
    // route to logout
    Route::post('logout',[CustomAuthController::class,'CustomLogout']);
    // route to create product
    Route::post('product',[ProductController::class,'store']);
      // route to update product
    Route::patch('product/{id}',[ProductController::class,'update']);
});

// route to login user 
Route::post('login',[CustomAuthController::class,'CustomLogin']);

// route to store new user
Route::post('user',[UserController::class,'store']);

Route::group(['prefix'=>'products'], function(){
    // get all products 
    Route::get('',[ProductController::class,'index']);
    // route to delete product by id
    Route::delete('/{id}',[ProductController::class,'destroy']);
});

// route to send product info to multi users throun mail trap
Route::post('send-email', [UserController::class, 'sendEmail'])->name('send.email');
