<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'home', 'uses' => 'ReportUIController@show']);

Route::post('/', ['as' => 'responce', 'uses' => 'ReportUIController@getReport']);

Route::post('queue-members', ['as' => 'queue-members', 'uses' => 'ReportUIController@queueMembers']);