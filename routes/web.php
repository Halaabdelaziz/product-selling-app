<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController;

Route::get('users',[UserController::class,'index'])->name('users');
Route::get('create',[UserController::class,'create'])->name('userCreate');
Route::post('create',[UserController::class,'store'])->name('userStore');
Route::delete('user/{id}',[UserController::class,'destroy'])->name('deleteUser');
Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
