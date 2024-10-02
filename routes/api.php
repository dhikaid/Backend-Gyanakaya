<?php

use App\Models\User;
use App\Models\Reviews;
use App\Models\Kategori;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Resources\GetResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CertificateController;

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
Route::post('/user/materi/{materi:uuid}/sertifikat', [MateriController::class, 'generateCertificate'])->middleware('auth:sanctum');
Route::get('/user/sertifikat', [CertificateController::class, 'index'])->middleware('auth:sanctum');
Route::post('/user/modul/{modul:uuid}', [ModulController::class, 'checkModul'])->middleware('auth:sanctum');

// REVIEW
Route::get('/reviews', [ReviewsController::class, 'index']);


// DEV
Route::get('/user/all', function () {
    return new GetResource(200, 'Sukses mengambil data.', User::with('role')->get());
});


// DASHBOARD

// USER
Route::get('/dashboard/user/all', [DashboardController::class, 'getUserAll'])->middleware('auth:sanctum');
Route::get('/dashboard/user/{user:uuid}', [DashboardController::class, 'getUserDetail'])->middleware('auth:sanctum');
Route::put('/dashboard/user/{user:uuid}/edit', [DashboardController::class, 'editUser'])->middleware('auth:sanctum');
Route::delete('/dashboard/user/{user:uuid}/delete', [DashboardController::class, 'deleteUser'])->middleware('auth:sanctum');

// ROLE
Route::get('/dashboard/role/all', [DashboardController::class, 'getRoleAll'])->middleware('auth:sanctum');

// MATERI
Route::get('/dashboard/materi/all', [DashboardController::class, 'getMateriAll'])->middleware('auth:sanctum');
Route::get('/dashboard/materi/{materi:uuid}', [DashboardController::class, 'getMateriDetail'])->middleware('auth:sanctum');
