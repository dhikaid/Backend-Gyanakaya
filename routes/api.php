<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// AUTH
Route::post('/user/signup', [AuthController::class, 'signup'])->middleware('guest');
Route::post('/user/signin', [AuthController::class, 'signin'])->middleware('guest')->name('login');
Route::post('/user/signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');
Route::get('/user/me', [AuthController::class, 'user'])->middleware('auth:sanctum');

//
