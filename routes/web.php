<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(200, [
        'status' => 'Rafli, bentar lagi pengumpulan 😄'
    ]);
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
