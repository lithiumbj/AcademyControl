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
Route::get('auth/logout', 'Auth\AuthController@getLogout');
//ONLY ON DEV
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');
/*
 * //zone END//
 */
Route::group(['middleware' => 'auth'], function () {
  Route::get('/', 'HomeController@home');
  Route::get('/home', 'HomeController@home');
  //Clients
  Route::get('/client/create', 'ClientController@getCreate');
  Route::post('/client/create', 'ClientController@postCreate');
  Route::post('/client/search', 'ClientController@postSearch');
  Route::get('/client/view/{id}', 'ClientController@getView');
  Route::get('/client/update/{id}', 'ClientController@getUpdate');
  Route::post('/client/update', 'ClientController@postUpdate');
  Route::get('/client/list/', 'ClientController@getList');
  Route::post('/client/addService', 'ClientController@ajaxSetService');
  //Services
  Route::get('/services', 'ServicesController@getList');
  Route::post('/services/create', 'ServicesController@postCreate');
  Route::post('/services/ajaxGetProductInfo', 'ServicesController@ajaxGetProductInfo');
  //Rooms / Horarios
  Route::get('/rooms', 'RoomController@getPreview');
  Route::get('/rooms/{id}', 'RoomController@getPreview');
  Route::post('/rooms/create', 'RoomController@postCreate');
  Route::post('/rooms/assign', 'RoomController@postAssignToService');
  Route::post('/room/assign_client', 'RoomController@postAssignClientToGroup');
  Route::post('/room/delink_client', 'RoomController@postDelinkClient');
  //invoices
  Route::get('/invoice', 'InvoiceController@getList');
  Route::get('/invoice/generate', 'InvoiceController@getGenerateAutoInvoices');
  Route::post('/invoice/generate', 'InvoiceController@postGenerateAutoInvoices');
  Route::post('/invoice/ajaxCreate', 'InvoiceController@ajaxCreateInvoice');
  Route::post('/invoice/massiveprint', 'InvoiceController@postMassivePrint');
  Route::get('/invoice/{id}', 'InvoiceController@getView');
  Route::get('/invoice/delete/{id}', 'InvoiceController@getDelete');
  Route::get('/invoice/pay/{id}', 'InvoiceController@setPayedInvoice');
  Route::get('/invoice/print/{id}', 'InvoiceController@printInvoice');
  Route::get('/invoice/unpay/{id}', 'InvoiceController@setUnpayedInvoice');
  Route::get('/invoice/create/{id}', 'InvoiceController@getCreateInvoice');
});
