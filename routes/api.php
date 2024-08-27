<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\GetResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ModulController;
use App\Models\Kategori;

// AUTH
Route::post('/user/signup', [AuthController::class, 'signup'])->middleware('guest');
Route::post('/user/signin', [AuthController::class, 'signin'])->middleware('guest')->name('login');
Route::post('/user/signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');
Route::get('/user/me', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::put('/user/edit', [AuthController::class, 'update'])->middleware('auth:sanctum');
Route::post('/user/reset', [AuthController::class, 'forgot'])->middleware('guest')->name('password.request');
Route::post('/user/reset/{token}', [AuthController::class, 'forgetPassword'])->middleware('guest')->name('password.reset');
Route::post('/user/reset-password', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum');
Route::post('/user/cektoken', [AuthController::class, 'cekToken'])->middleware('guest');


// KATEGORI
Route::get('/kategori/all', [KategoriController::class, 'index']);
Route::get('/kategori/front', [KategoriController::class, 'front']);
Route::get('/kategori/{kategori:uuid}', [KategoriController::class, 'detail']);

// MATERI
Route::post('/materi', [MateriController::class, 'search']);
Route::get('/materi/lastest', [MateriController::class, 'lastest']);
Route::get('/materi/all', [MateriController::class, 'index']);
Route::get('/materi/{materi:uuid}', [MateriController::class, 'show'])->middleware('auth:sanctum');
Route::get('/materi/{materi:uuid}/{modul}', [MateriController::class, 'detail'])->middleware('auth:sanctum');


// CEK USER BELAJAR
Route::get('/user/materi/{materi:uuid}', [MateriController::class, 'checkUser'])->middleware('auth:sanctum');
Route::post('/user/materi/{materi:uuid}', [MateriController::class, 'registerCourse'])->middleware('auth:sanctum');
Route::post('/user/modul/{modul:uuid}', [ModulController::class, 'checkModul'])->middleware('auth:sanctum');


// DEV
Route::get('/user/all', function () {
    return new GetResource(200, 'Sukses mengambil data.', User::with('role')->get());
});
