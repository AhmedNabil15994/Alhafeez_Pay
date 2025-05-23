<?php

Route::any('/callback/{transaction_number}', 'PaymentsController@callback')->name('callback');
Route::get('/error/{transaction_number}', 'PaymentsController@failure')->name('failure');
