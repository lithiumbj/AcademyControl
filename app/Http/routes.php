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
Route::get('/login', function() {
    return view('login');
});
Route::post('auth/login', 'Auth\AuthController@postLogin');

//JSON Request's
Route::get('invoice/ajaxinvoices', 'InvoiceController@getInvoicesForClient');

Route::get('auth/login', function() {
    return view('login');
});
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
    Route::get('/client/list/{type}', 'ClientController@getTypedList');
    Route::post('/client/addService', 'ClientController@ajaxSetService');
    Route::get('/client/delete/{id}', 'ClientController@deleteClient');
    Route::get('/client/undue/', 'ClientController@getUndue');
    Route::get('/client/noService', 'ClientController@getWithoutService');
    Route::get('/client/calendar/{id}', 'ClientController@getServicesCalendar');
    //Services
    Route::get('/services', 'ServicesController@getList');
    Route::post('/services/create', 'ServicesController@postCreate');
    Route::post('/services/update', 'ServicesController@postUpdate');
    Route::post('/services/ajaxGetProductInfo', 'ServicesController@ajaxGetProductInfo');
    Route::get('/service/unlink/{id}', 'ServicesController@getUnlink');
    Route::get('/service/disable/{id}', 'ServicesController@getDisable');
    Route::get('/service/enable/{id}', 'ServicesController@getEnable');
    Route::post('/service/switch/', 'ServicesController@switchService');
    Route::get('/services/delete/{id}', 'ServicesController@getDelete');
    //Rooms / Horarios
    Route::get('/rooms', 'RoomController@getPreview');
    Route::get('/rooms/getReserveClients/{id}', 'RoomController@getRoomReserveClients');
    Route::get('/rooms/{id}', 'RoomController@getPreview');
    Route::post('/rooms/create', 'RoomController@postCreate');
    Route::post('/rooms/assign', 'RoomController@postAssignToService');
    Route::post('/room/assign_client', 'RoomController@postAssignClientToGroup');
    Route::post('/room/delink_client', 'RoomController@postDelinkClient');
    Route::get('/room/delink/{id}', 'RoomController@getDelinkRoom');
    //invoices
    Route::get('/invoice', 'InvoiceController@getList');
    Route::get('/invoice/generate', 'InvoiceController@getGenerateAutoInvoices');
    Route::post('/invoice/generate', 'InvoiceController@postGenerateAutoInvoices');
    Route::post('/invoice/ajaxCreate', 'InvoiceController@ajaxCreateInvoice');
    Route::post('/invoice/ajaxFactureCreate', 'InvoiceController@ajaxFactureCreate');
    Route::post('/invoice/massiveprint', 'InvoiceController@postMassivePrint');
    Route::get('/invoice/{id}', 'InvoiceController@getView');
    Route::get('/invoice/delete/{id}', 'InvoiceController@getDelete');
    Route::post('/invoice/pay/', 'InvoiceController@setPayedInvoice');
    Route::post('/invoice/paybank', 'InvoiceController@setBankPayedInvoice');
    Route::get('/invoice/print/{id}', 'InvoiceController@printInvoice');
    Route::get('/invoice/printFacture/{id}', 'InvoiceController@printFacture');
    Route::get('/invoice/unpay/{id}', 'InvoiceController@setUnpayedInvoice');
    Route::get('/invoice/create/{id}', 'InvoiceController@getCreateInvoice');
    Route::get('/invoice/new/{id}', 'InvoiceController@getCreateFacture');
    Route::post('/invoice/update_public_note', 'InvoiceController@updatePublicNote');
    Route::post('/invoice/update_private_note', 'InvoiceController@updatePrivateNote');
    //Caja
    Route::get('/cashflow/', 'CashflowController@showCash');
    Route::post('/cashflow/', 'CashflowController@showCashFiltered');
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
    Route::post('/assistance/checkin', 'IncidenceController@checkIn');
    Route::get('/assistance/list', 'IncidenceController@getAssitanceList');
    Route::post('/incidence/client/create', 'IncidenceController@createClientIncidence');
    Route::get('/incidence/client', 'IncidenceController@getClientIncidences');
    Route::get('/incidence/client/complete/{id}', 'IncidenceController@completeIncidence');
    Route::post('/report/client/get', 'IncidenceController@getClientReport');
    Route::post('/califications/client/get', 'IncidenceController@getClientCalifications');
    Route::post('/report/client/create', 'IncidenceController@crateClientReport');
    Route::post('/report/client/delete', 'IncidenceController@deleteClientReport');
    Route::post('/report/client/edit', 'IncidenceController@editClientReport');
    //Stats routes
    Route::get('/stats/new_clients', 'StatsController@getNewClients');
    Route::get('/stats/new_infos', 'StatsController@getNewInfos');
    Route::get('/stats/info_conversion', 'StatsController@getInfoToClientConversions');
    Route::get('/stats/cancelation_conversion', 'StatsController@getClientToExclientConversions');
    Route::get('/stats/clients_by_service', 'StatsController@getClientByService');
    Route::post('/stats/clients_by_service', 'StatsController@postClientByService');
    Route::get('/stats/incomplete_clients', 'StatsController@getIncompleteClients');
    Route::get('/stats/occupation_info', 'StatsController@getOccupationInfo');
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
    //Employee routes
    Route::get('/user/create', 'UserController@getCreate');
    Route::get('/user/list', 'UserController@getList');
    Route::post('/user/create', 'UserController@postCreate');
    Route::get('/user/view/{id}', 'UserController@getView');
    Route::post('/user/update', 'UserController@postUpdate');
    //Chat
    Route::get('/chat/list', 'ChatController@getList');
    Route::post('/chat/getMessages', 'ChatController@getMessagesForUser');
    Route::post('/chat/getAppMessagesWeb', 'ChatController@getAppMessagesForUser');
    Route::post('/chat/sendMessage', 'ChatController@sendMessage');
    Route::post('/chat/sendAppMessageWeb', 'ChatController@sendAppMessage');
    Route::get('/chat/checkFeed', 'ChatController@checkFeed');
    //App-given messaging
    Route::get('/chat/checkAppFeed', 'ChatController@checkAppFeed');
    Route::get('/chat/app', 'ChatController@getAppList');
    //SMS Send routes 
    Route::post('/sms/sendReport', 'SMSController@sendReport');
    //LMS Routes
    Route::get('/lms', 'LMSController@showLMS');
    Route::get('/lms/fetch/{path}', 'LMSController@ajaxFetch');
    Route::post('/lms/new_folder', 'LMSController@ajaxCreateFolder');
    Route::post('/lms/upload_file', 'LMSController@ajaxUploadFile');
    //Settings
    Route::get("/settings", function() {
        return View::make("settings.settings");
    });
    Route::post('/settings/create_company', 'SettingsController@ajaxCreateCompany');
    Route::post('/lms/delete_file', 'LMSController@ajaxDeleteFile');
    Route::get('/lms/download/{id}', 'LMSController@downloadFile');
});
//App post emmiting
//App - Chat
Route::post('/chat/sendAppMessage', 'ChatController@ajaxAppSendMessage');
Route::post('/chat/getAppMessages', 'ChatController@ajaxAppGetMessages');
Route::post('/chat/checkAppMessages', 'ChatController@ajaxAppCheckMessages'); 
//App - login
Route::get('auth/login_app', 'Auth\AuthController@appLogin');
Route::post('invoice/app_get', 'InvoiceController@appGetInvoices');