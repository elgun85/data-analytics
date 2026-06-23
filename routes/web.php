<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::view('/internet-analytics', 'internet_analytics')
    ->name('internet.analytics');