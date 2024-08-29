<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use setasign\Fpdi\Fpdi;

Route::get('/', function () {
    
});


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
