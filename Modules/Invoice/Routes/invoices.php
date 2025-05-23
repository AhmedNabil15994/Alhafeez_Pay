<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {

    Route::get('invoices/datatable'	,'InvoiceController@datatable')
        ->name('invoices.datatable');

    Route::get('invoices/deletes'	,'InvoiceController@deletes')
        ->name('invoices.deletes');

    Route::resource('invoices','InvoiceController')->names('invoices');
});