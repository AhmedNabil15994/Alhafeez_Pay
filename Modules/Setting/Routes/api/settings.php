<?php
Route::group(['prefix' => 'settings'], function () {
    Route::get('/', 'SettingController@settings') ->middleware("cacheResponse");
    Route::get('/phone-codes', 'SettingController@phoneCodes')
                                                ->middleware("cacheResponse")
                                                ;
    Route::get('currency/{code}', 'SettingController@convertCurrency')->name('api.convert.currency');
});
