<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.home');
});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]] , function()
{
    Route::get('invoice/{number}/{id}/{token}', [\Modules\Invoice\Http\Controllers\Frontend\InvoiceController::class, 'paymentLink'])->name('web.invoice.payment-link')->middleware('throttle:60,1');
    Route::post('pay', [\Modules\Invoice\Http\Controllers\Frontend\InvoiceController::class, 'pay'])->name('web.invoice.pay')->middleware('throttle:60,1');
    Route::get('success/{number}/{id}/{token}', [\Modules\Invoice\Http\Controllers\Frontend\InvoiceController::class, 'success'])->name('web.invoice.success')->middleware('throttle:60,1');
    Route::get('failure/{number}/{id}/{token}', [\Modules\Invoice\Http\Controllers\Frontend\InvoiceController::class, 'failure'])->name('web.invoice.failure')->middleware('throttle:60,1');
});
