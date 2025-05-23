<?php

Route::group(['prefix' => 'auth'], function()
{
    Route::any('/login', 'AuthController@login')->name('vendors.login');
    Route::post('/register', 'AuthController@register')->name('vendors.register');
    Route::post('/forgot_password', 'AuthController@forgot_password')->name('vendors.forgot_password');
    Route::post('/logout', 'AuthController@logout')->middleware('isVendor')->name('vendors.logout');
    Route::get('/verify/{email}/{token}', 'AuthController@verify')->name('vendors.verify')->middleware('throttle:6,1');
    Route::post('/verify/re-generate', 'AuthController@reGenerate')->name('vendors.re-generate')->middleware('throttle:6,1');
});
