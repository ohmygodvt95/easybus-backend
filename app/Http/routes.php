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

Route::get('/', 'HomeController@index');
Route::resource('events', 'EventsController');
Route::resource('system', 'SystemController');
Route::resource('busline', 'BuslineController');
Route::group(['prefix' => 'api'], function () {
    Route::resource('report', 'ReportController');
    Route::resource('busstop', 'BusStopController');
    Route::resource('busline', 'BuslineController');
    Route::resource('filter', 'FilterController');
	Route::group(['prefix' => 'province'], function () {
	    Route::get('/', "ProvinceController@index");
	});
});
Route::resource('system', 'SystemController', ['only' => ['index', 'show']]);
Route::resource('system.userreport', 'UserReportController', ['only' => ['index', 'show']]);
