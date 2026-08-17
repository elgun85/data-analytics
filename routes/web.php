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

Route::get('/mhmVcBilling', [InternetAnalyticsController::class, 'mhmVcBilling'])->name('mhmVcBilling');
Route::get('/mhmVcBilling/export', [InternetAnalyticsController::class, 'mhmVcBillingExport'])->name('mhmVcBillingExport');

Route::get('/mhmVcLks', [InternetAnalyticsController::class, 'mhmVcLks'])->name('mhmVcLks');
Route::get('/mhmVcLks/export', [InternetAnalyticsController::class, 'mhmVcLksExport'])->name('mhmVcLksExport');

Route::get('/lksVcBilling', [InternetAnalyticsController::class, 'lksVcBilling'])->name('lksVcBilling');
Route::get('/lksVcBilling/export', [InternetAnalyticsController::class, 'lksVcBillingExport'])->name('lksVcBillingExport');


Route::get('/phone-analytics', [PhoneAnalyticsController::class, 'index'])->name('phone.analytics');
Route::get('/phone-analytics/export', [PhoneAnalyticsController::class, 'exportCvc'])->name('phone.analytics.export');
