<?php

Route::group(['prefix' => 'areas'], function () {
    Route::get('/cities', 'AreaController@cities')->name('api.areas.cities');
    Route::get('/countries', 'AreaController@countries')->middleware("cacheResponse");
});
