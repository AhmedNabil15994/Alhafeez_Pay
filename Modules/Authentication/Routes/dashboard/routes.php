<?php

Route::group(['prefix' => 'login'], function () {

//    if (env('LOGIN')):

        // Show Login Form
        Route::get('/', 'LoginController@showLogin')
        ->name('dashboard.login.view')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'LoginController@postLogin')
        ->name('dashboard.login');

//    endif;

});


Route::group(['prefix' => 'logout','middleware' => 'dashboard.auth'], function () {

    // Logout
    Route::any('/', 'LoginController@logout')
    ->name('dashboard.logout');

});
