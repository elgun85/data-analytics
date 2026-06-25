<?php

use App\Http\Controllers\InternetAnalyticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// Route::view('/internet-analytics', 'internet_analytics')
//     ->name('internet.analytics');

    Route::get('/internet-analytics',[InternetAnalyticsController::class,'index'])->name('internet.analytics');