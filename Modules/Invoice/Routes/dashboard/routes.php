<?php
    /**++++++++++++++++++
     * INVOICES ROUTES
     ++++++++++++++++++++*/
     Route::group(['prefix' => 'invoices', 'as' => 'dashboard.invoices.'], function()
     {
         Route::get('/', 'InvoiceController@index')->name('index');
         Route::get('datatable'	,'InvoiceController@datatable')->name('datatable');
         Route::get('{id}/show'	,'InvoiceController@show')->name('show');
         Route::get('create'	,'InvoiceController@create')->name('create');
         Route::post('store'	,'InvoiceController@store')->name('store');
         Route::get('{id}/edit'	,'InvoiceController@edit')->name('edit');
         Route::get('deletes'	,'InvoiceController@deletes')->name('deletes');
         Route::put('{id}'	,'InvoiceController@update')->name('update');
         Route::delete('{id}'	,'InvoiceController@destroy')->name('destroy');

         Route::group(['prefix' => 'payment_links'], function(){
             Route::get('/'	,'PaymentLinkController@index')->name('payment_links.index');
             Route::get('/datatable'	,'PaymentLinkController@datatable')->name('payment_links.datatable');
             Route::get('{id}/edit'	,'PaymentLinkController@edit')->name('payment_links.edit');
             Route::put('{id}'	,'PaymentLinkController@update')->name('payment_links.update');
             Route::delete('{id}'	,'PaymentLinkController@destroy')->name('payment_links.destroy');
             Route::get('{id}'	,'PaymentLinkController@deletes')->name('payment_links.deletes');
         });

         Route::group(['prefix' => 'transactions'], function(){
            Route::get('/'	,'TransactionController@index')->name('transactions.index');
            Route::get('/datatable'	,'TransactionController@datatable')->name('transactions.datatable');
        });
     });
