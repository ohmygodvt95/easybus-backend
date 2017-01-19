<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('report', "ReportController@getIndex");
Route::group(['prefix' => 'api'], function () {
    Route::resource('report', 'ReportController');
	Route::group(['prefix' => 'province'], function () {
	    Route::get('/', "ProvinceController@index");
	});
});