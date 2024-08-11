<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// AUTH
Route::post('/user/signup', [AuthController::class, 'signup'])->middleware('guest');
Route::post('/user/signin', [AuthController::class, 'signin'])->middleware('guest')->name('login');
