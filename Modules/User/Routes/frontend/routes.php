<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function()
{
    Route::get('/', 'UserController@index')->name('vendors.users.index');
    Route::get('/create', 'UserController@create')->name('vendors.users.create');
    Route::post('/store', 'UserController@store')->name('vendors.users.store');
    Route::get('/edit/{id}', 'UserController@edit')->name('vendors.users.edit');
    Route::put('/update/{id}', 'UserController@update')->name('vendors.users.update');
    Route::delete('/delete/{id}', 'UserController@destroy')->name('vendors.users.destroy');
    Route::get('/deletes', 'UserController@deletes')->name('vendors.users.deletes');
    Route::get('/datatable', 'UserController@datatable')->name('vendors.users.datatable');
    Route::get('/enter_id', 'UserController@enterIdNumber')->name('vendors.users.enter_id');
    Route::post('/go_check_id', 'UserController@checkId')->name('vendors.users.go_check_id');
    Route::get('/add_note/{id_number}', 'UserController@addNote')->name('vendors.users.add_note');
    Route::post('/submit_note/{id_number}', 'UserController@submitNote')->name('vendors.users.submit_note');
});
