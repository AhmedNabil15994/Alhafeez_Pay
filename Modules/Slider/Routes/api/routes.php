<?php
Route::group(['prefix' => 'sliders','middleware' => []], function () {
    Route::get("/", "SliderController@index");
});
