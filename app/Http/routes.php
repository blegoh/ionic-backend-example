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

Route::get('/', function()
{

	// Variable data ini yang berupa array ini akan bisa diakses di dalam "view".
	//$data = ['prize' => 'Peke', 'total' => 3 ];

	// "emails.hello" adalah nama view.
	/*Mail::send('emails.hello', $data, function ($mail)
	{
		// Email dikirimkan ke address "momo@deviluke.com"
		// dengan nama penerima "Momo Velia Deviluke"
		$mail->to('info@yusufeka.me', 'Momo Velia Deviluke');

		
		$mail->subject('Hello World!');
	});*/

});

Route::group(['prefix' => 'api', 'middleware' => ['cors','api']], function()
{
	Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
	Route::post('authenticate', 'AuthenticateController@authenticate');
	Route::post('register', 'AuthenticateController@register');
	Route::get('authenticate/user','AuthenticateController@getAuthenticatedUser');
	Route::put('authenticate/user','AuthenticateController@update');
	Route::resource('lahan','LahanController');
	Route::get('decision','DecisionController@index');
	Route::get('decision/label','DecisionController@labels');
});
