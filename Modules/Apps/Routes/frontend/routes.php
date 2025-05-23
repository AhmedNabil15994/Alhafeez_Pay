<?php

Route::group(['prefix' => '/' , 'middleware' => [ 'isVendor']], function () {
    Route::get('/', 'DashboardController@index')->name('vendors.home');
});

Route::group(['prefix' => '/ajax' , 'middleware' => [ 'isVendor']], function () {
    Route::post('/', 'DashboardController@ajaxFindClientAutoComplete')->name('vendors.ajax.autocomplet.civil');
});
