<?php
use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group( function () {

    Route::get('sliders/datatable'	,'SliderController@datatable')
        ->name('sliders.datatable');

    Route::get('sliders/deletes'	,'SliderController@deletes')
        ->name('sliders.deletes');

    Route::resource('sliders','SliderController')->names('sliders');
});