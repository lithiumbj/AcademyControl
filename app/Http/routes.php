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
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
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
  Route::get('/client/list/{type}', 'ClientController@getTypedList');
  Route::post('/client/addService', 'ClientController@ajaxSetService');
  Route::get('/client/delete/{id}', 'ClientController@deleteClient');
  //Services
  Route::get('/services', 'ServicesController@getList');
  Route::post('/services/create', 'ServicesController@postCreate');
  Route::post('/services/update', 'ServicesController@postUpdate');
  Route::post('/services/ajaxGetProductInfo', 'ServicesController@ajaxGetProductInfo');
  Route::get('/service/unlink/{id}', 'ServicesController@getUnlink');
  Route::get('/services/delete/{id}', 'ServicesController@getDelete');
  //Rooms / Horarios
  Route::get('/rooms', 'RoomController@getPreview');
  Route::get('/rooms/getReserveClients/{id}', 'RoomController@getRoomReserveClients');
  Route::get('/rooms/{id}', 'RoomController@getPreview');
  Route::post('/rooms/create', 'RoomController@postCreate');
  Route::post('/rooms/assign', 'RoomController@postAssignToService');
  Route::post('/room/assign_client', 'RoomController@postAssignClientToGroup');
  Route::post('/room/delink_client', 'RoomController@postDelinkClient');
  Route::get('/room/delink/{id}','RoomController@getDelinkRoom');
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
  //Caja
  Route::get('/cashflow/', 'CashflowController@showCash');
  Route::get('/cashflow/open', 'CashflowController@getOpen');
  Route::post('/cashflow/open', 'CashflowController@postOpen');
  Route::get('/cashflow/exit', 'CashflowController@getExit');
  Route::post('/cashflow/exit', 'CashflowController@postExit');
  Route::get('/cashflow/close', 'CashflowController@getClose');
  Route::post('/cashflow/close', 'CashflowController@postClose');
  //Teacher routes
  Route::get('/teacher/view', 'HomeController@teacher');
  Route::get('/teacher/teach', 'TeacherController@getTeacherView');
  //Asistance / incidences / reports routes
  Route::post('/assistance/checkin','IncidenceController@checkIn');
  Route::get('/assistance/list','IncidenceController@getAssitanceList');
  Route::post('/incidence/client/create', 'IncidenceController@createClientIncidence');
  Route::get('/incidence/client', 'IncidenceController@getClientIncidences');
  Route::get('/incidence/client/complete/{id}', 'IncidenceController@completeIncidence');
  Route::post('/report/client/get','IncidenceController@getClientReport');
  Route::post('/report/client/create','IncidenceController@crateClientReport');
  //Stats routes
  Route::get('/stats/new_clients', 'StatsController@getNewClients');
  Route::get('/stats/new_infos', 'StatsController@getNewInfos');
  //Provider Routes
  Route::get('/provider/', 'ProviderController@getList');
  Route::get('/provider/create', 'ProviderController@getCreate');
  Route::post('/provider/create', 'ProviderController@postCreate');
  Route::get('/provider/view/{id}', 'ProviderController@getProvider');
  Route::get('/provider/update/{id}', 'ProviderController@getUpdate');
  Route::get('/provider/delete/{id}', 'ProviderController@getDelete');
  Route::post('/provider/update', 'ProviderController@postUpdate');
  //Provider invoices
  Route::get('/provider_invoice/', 'ProviderInvoiceController@getList');
  Route::get('/provider_invoice/create/{id}', 'ProviderInvoiceController@getCreateInvoice');
  Route::get('/provider_invoice/{id}', 'ProviderInvoiceController@getView');
  Route::get('/provider_invoice/delete/{id}', 'ProviderInvoiceController@getDelete');
  Route::get('/provider_invoice/pay/{id}', 'ProviderInvoiceController@setPayedInvoice');
  Route::get('/provider_invoice/unpay/{id}', 'ProviderInvoiceController@setUnpayedInvoice');
  Route::post('/provider_invoice/create/', 'ProviderInvoiceController@ajaxCreateInvoice');
});
