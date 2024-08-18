<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\GetResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MateriController;
use App\Models\Kategori;

// AUTH
Route::post('/user/signup', [AuthController::class, 'signup'])->middleware('guest');
Route::post('/user/signin', [AuthController::class, 'signin'])->middleware('guest')->name('login');
Route::post('/user/signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');
Route::get('/user/me', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::put('/user/edit', [AuthController::class, 'update'])->middleware('auth:sanctum');


// KATEGORI
Route::get('/kategori/all', [KategoriController::class, 'index']);

// MATERI
Route::post('/materi', [MateriController::class, 'search']);
Route::get('/materi/all', [MateriController::class, 'index']);
Route::get('/materi/{materi:uuid}', [MateriController::class, 'show']);

// DEV
Route::get('/user/all', function () {
    return new GetResource(200, 'Sukses mengambil data.', User::all());
});
