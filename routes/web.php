<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('https://gyanakaya.bhadrikais.my.id');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
