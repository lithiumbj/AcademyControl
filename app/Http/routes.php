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

Route::get('/', function () {
    return view('welcome');
});
/*
 * Login zone
 */
Route::get('/login',function(){
    return view('login');
});
Route::post('auth/login', 'Auth\AuthController@postLogin');
//ONLY ON DEV
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');
/*
 * //zone END//
 */
Route::group(['middleware' => 'auth'], function () {
  Route::get('/', 'HomeController@home');
  //Clients
  Route::get('/client/create', 'ClientController@getCreate');
});
