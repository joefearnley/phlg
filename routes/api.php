<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('messages', 'MessageApiController@index');
Route::post('messages', 'MessageApiController@store');
Route::get('messages/{id}', 'MessageApiController@show');
Route::put('messages/{id}', 'MessageApiController@update');
Route::delete('messages/{id}', 'MessageApiController@delete');
