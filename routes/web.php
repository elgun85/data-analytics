<?php

use App\Http\Controllers\InternetAnalyticsController;
use App\Http\Controllers\PhoneAnalyticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// Route::view('/internet-analytics', 'internet_analytics')
//     ->name('internet.analytics');

Route::get('/internet-analytics', [InternetAnalyticsController::class, 'index'])->name('internet.analytics');
Route::get('/internet-analytics/export', [InternetAnalyticsController::class, 'exportExcel'])->name('internet.analytics.export');

Route::get('/phone-analytics', [PhoneAnalyticsController::class, 'index'])->name('phone.analytics');
Route::get('/phone-analytics/export', [PhoneAnalyticsController::class, 'exportCvc'])->name('phone.analytics.export');
