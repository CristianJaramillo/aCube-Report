<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Debugbar::disable();

Route::get('/', ['as' => 'dashboar', 'uses' => 'DashboardController@show']);

Route::post('report', ['as' => 'report', 'uses' => 'LogQueueController@report']);

Route::post('queues-and-members', ['as' => 'queues-and-members', 'uses' => 'QueueController@withMembers']);

Route::get('recording/{id}/{uniqueid}', ['as' => 'recording', 'uses' => 'RecordingController@make']);

Route::get('download/{id}/{uniqueid}', ['as' => 'download', 'uses' => 'RecordingController@download']);
