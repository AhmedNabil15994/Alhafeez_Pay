<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {

  	Route::get('/' ,'UserController@index')
  	->name('dashboard.users.index');

  	Route::get('datatable'	,'UserController@datatable')
  	->name('dashboard.users.datatable');

  	Route::get('create'		,'UserController@create')
  	->name('dashboard.users.create');

  	Route::post('/'			,'UserController@store')
  	->name('dashboard.users.store');

  	Route::get('{id}/edit'	,'UserController@edit')
  	->name('dashboard.users.edit');

  	Route::put('{id}'		,'UserController@update')
  	->name('dashboard.users.update');

  	Route::delete('{id}'	,'UserController@destroy')
  	->name('dashboard.users.destroy');

  	Route::get('deletes'	,'UserController@deletes')
  	->name('dashboard.users.deletes');

  	Route::get('{id}','UserController@show')
  	->name('dashboard.users.show');

});
// parents
Route::group(['prefix' => 'parents'], function () {

	Route::get('/' ,'ParentController@index')
	->name('dashboard.parents.index');

	Route::get('datatable'	,'ParentController@datatable')
	->name('dashboard.parents.datatable');

	Route::get('create'		,'ParentController@create')
	->name('dashboard.parents.create');

	Route::post('/'			,'ParentController@store')
	->name('dashboard.parents.store');

	Route::get('{id}/edit'	,'ParentController@edit')
	->name('dashboard.parents.edit');

	Route::put('{id}'		,'ParentController@update')
	->name('dashboard.parents.update');

	Route::delete('{id}'	,'ParentController@destroy')
	->name('dashboard.parents.destroy');

	Route::get('deletes'	,'ParentController@deletes')
	->name('dashboard.parents.deletes');

	Route::get('{id}','ParentController@show')
	->name('dashboard.parents.show');

});

