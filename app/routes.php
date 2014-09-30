<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'home', 'uses' => 'ReportUIController@showReportUI']);

Route::post('/', ['as' => 'responce', 'uses' => 'ReportUIController@getReport']);