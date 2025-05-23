<?php

Route::group(['prefix' => 'user','middleware' => 'auth:sanctum'], function () {
    Route::get('profile', 'UserController@profile')->name('api.users.profile');
    Route::get('notifications', 'UserController@notifications')->name('api.users.notifications');
    Route::delete('notifications', 'UserController@deleteNotifications')->name('api.users.delete-notifications');
    Route::post('profile', 'UserController@updateProfile')->name('api.users.update-profile');
    Route::put('change-password', 'UserController@changePassword')->name('api.users.change.password');
});



Route::group(['prefix' => 'children','middleware' => ['auth:sanctum']], function () {
    Route::post('/', 'UserController@addChild');
    Route::get('/', 'UserController@listChild');
    Route::post('/{id}/update', 'UserController@updateChild');
    Route::delete('/{id}', 'UserController@deleteChild');
});


Route::group(['prefix' => 'users/{userId}','middleware' => ['auth:sanctum', "user.allow-show"] ], function () {
    Route::get('/', 'UserCircleController@index');
    Route::get('/circles/{id}/attends', 'UserCircleController@listAttends');
    Route::get('/circles/{id}/quizzes', 'UserCircleController@listQuizzes');
});