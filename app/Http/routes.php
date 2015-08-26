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
  Route::post('/client/create', 'ClientController@postCreate');
  Route::get('/client/view/{id}', 'ClientController@getView');
  Route::get('/client/update/{id}', 'ClientController@getUpdate');
  Route::post('/client/update', 'ClientController@postUpdate');
  Route::get('/client/list/', 'ClientController@getList');
  Route::post('/client/addService', 'ClientController@ajaxSetService');
  //Services
  Route::get('/services', 'ServicesController@getList');
  Route::post('/services/create', 'ServicesController@postCreate');
  //Rooms / Horarios
  Route::get('/rooms', 'RoomController@getPreview');
  Route::post('/rooms/create', 'RoomController@postCreate');
});
