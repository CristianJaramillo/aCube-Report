<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'home', 'uses' => 'ReportUIController@show']);

Route::post('/', ['as' => 'responce', 'uses' => 'ReportUIController@getReport']);

Route::post('queue-members', ['as' => 'queue-members', 'uses' => 'ReportUIController@queueMembers']);

Route::get('file', function(){
	
	$file       = "audio.wav";

	$pathToFile = base_path($file);

	$content = file_get_contents($pathToFile);

	$headers = [
			"Cache-Control" => "no-cache",
			"Content-Disposition" => "filename=\"$file\"",
			"Content-length" => filesize($pathToFile),
			"Content-Transfer-Encoding" => "binary",
			"Content-Type" => "audio/wav audio/x-wav audio/wave audio/x-pn-wav",
			"X-Pad" => "avoid browser bug"
		];

	return Response::make($content, 200, $headers);
});

Route::get('download', function (){

	$file       = "Kalimba.wma";

	$pathToFile = base_path($file);

	$headers = [
			"Cache-Control" => "no-cache",
			"Content-Disposition" => "filename=\"$file\"",
			"Content-length" => filesize($pathToFile),
			"Content-Transfer-Encoding" => "binary",
			"Content-Type" => "audio/x-ms-wma",
			"X-Pad" => "avoid browser bug"
		];

	return Response::download($pathToFile, $file, $headers);

});

Route::get('recoding/{file}', ['as' => 'recoding', 'uses' => 'ReportUIController@getRecoding']);