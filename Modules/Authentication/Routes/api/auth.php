<?php

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'LoginController@postLogin')->name('api.auth.login');
    Route::post('register', 'RegisterController@register')->name('api.auth.register');
    Route::post('company/register', 'RegisterController@companyRegister')->name('api.auth.company.register');
    Route::post('forget-password', 'ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::post('send-code', 'LoginController@sendCode');
    Route::post('verified-code', 'LoginController@verifiedCode');

    Route::group(['prefix' => '/','middleware' => 'auth:api'], function () {
        Route::post('logout', 'LoginController@logout')->name('api.auth.logout');
    });
});
