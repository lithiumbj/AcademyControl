<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\ContactWay;
use App\Models\RoomReserve;
use App\Models\ServiceClient;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use Validator;
use DB;

class ClientController extends Controller {

    /**
     * Shows the create client's create form
     */
    public function getCreate() {
        //get the contat way's
        $contactWays = ContactWay::all();
        //render the view
        return view('client.create', ['contactWays' => $contactWays]);
    }

    /*
     * Insert's the client into the database or returns an error
     */

    public function postCreate(Request $request) {
        //Get the data
        $data = $request->all();
        //Filter the data to check if any is wrong
        $validator = Validator::make($data, [
                    'name' => 'required|max:254',
                    'lastname_1' => 'required|max:254',
                    'address' => 'required|max:254',
        ]);
        //Check if validator fails
        if (!$validator->fails()) {
            //Innitial validation ok
            $client = new Client();
            //Set the auto-foreign keys
            $client->fk_company = Auth::user()->fk_company;
            $client->fk_user = Auth::user()->id;
            //Load data
            $client->name = $data['name'];
            $client->lastname_1 = $data['lastname_1'];
            $client->lastname_2 = $data['lastname_2'];
            $client->nif = $data['nif'];
            $client->address = $data['address'];
            $client->poblation = $data['poblation'];
            $client->city = $data['city'];
            $client->parent_name = $data['parent_name'];
            $client->parent_lastname_1 = $data['parent_lastname_1'];
            $client->parent_lastname_2 = $data['parent_lastname_2'];
            $client->parent_nif = $data['parent_nif'];
            $client->status = $data['status'];
            $client->is_subscription = $data['is_subscription'];
            //Check if the client was registered as info
            if ($client->status == "0")
                $client->was_info = 1;

            $client->phone_parents = $data['phone_parents'];
            $client->phone_client = $data['phone_client'];
            $client->phone_whatsapp = $data['phone_whatsapp'];
            $client->fk_contact_way = $data['fk_contact_way'];
            $client->email_parents = $data['email_parents'];
            $client->email_client = $data['email_client'];
            $client->cp = $data['cp'];
            $client->other_address_info = $data['other_address_info'];

            //Save the client
            if ($client->save()) {
                //Ok, go to view
                return redirect('client/view/' . $client->id);
            } else {
                //ko, return to form
                return redirect('client/create')
                                ->withErrors($validator)
                                ->withInput();
            }
        } else {
            //Innitial validation KO, redirect to form
            return redirect('client/create')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /*
     * Render's the update of the model
     */

    public function getUpdate($id) {
        $model = Client::find($id);
        //get the contat way's
        $contactWays = ContactWay::all();
        return view('client.update', ['model' => $model, 'contactWays' => $contactWays]);
    }

    /*
     * This function is called to update a client model
     */

    public function postUpdate(Request $request) {
        //Get the data
        $data = $request->all();
        //Filter the data to check if any is wrong
        $validator = Validator::make($data, [
                    'name' => 'required|max:254',
                    'lastname_1' => 'required|max:254',
                    'address' => 'required|max:254',
        ]);
        //Check if validator fails
        if (!$validator->fails()) {
            //Innitial validation ok
            $client = Client::find($data['id']);
            //Load data
            $client->name = $data['name'];
            $client->lastname_1 = $data['lastname_1'];
            $client->lastname_2 = $data['lastname_2'];
            $client->nif = $data['nif'];
            $client->parent_name = $data['parent_name'];
            $client->parent_lastname_1 = $data['parent_lastname_1'];
            $client->parent_lastname_2 = $data['parent_lastname_2'];
            $client->parent_nif = $data['parent_nif'];
            $client->address = $data['address'];
            $client->poblation = $data['poblation'];
            $client->city = $data['city'];
            $client->status = $data['status'];
            $client->is_subscription = $data['is_subscription'];
            //Check if the client was a client, and is not being it anymore
            if ($client->status == "2")
                $client->date_cancelation = date('Y-m-d');

            $client->phone_parents = $data['phone_parents'];
            $client->phone_client = $data['phone_client'];
            $client->phone_whatsapp = $data['phone_whatsapp'];
            $client->fk_contact_way = $data['fk_contact_way'];
            $client->email_parents = $data['email_parents'];
            $client->email_client = $data['email_client'];
            $client->cp = $data['cp'];
            $client->other_address_info = $data['other_address_info'];

            //Save the client
            if ($client->save()) {
                //Ok, go to view
                return redirect('client/view/' . $client->id);
            } else {
                //ko, return to form
                return redirect('client/update/' . $client->id)
                                ->withErrors($validator)
                                ->withInput();
            }
        } else {
            //Innitial validation KO, redirect to form
            return redirect('client/update/' . $client->id)
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /*
     * Render's the view of the model
     */

    public function getView($id) {
        $model = Client::find($id);
        //get the contat way's
        $contactWays = ContactWay::all();
        //Get the client services
        $services = DB::table('service_client')
                        ->join('service', 'service.id', '=', 'service_client.fk_service')
                        ->where('service_client.fk_client', '=', $model->id)
                        ->select('service_client.id', 'service.id as serviceId', 'service.name', 'service_client.created_at', 'service_client.active', 'service_client.reason', 'service_client.date_to')->get();
        //Get the client last invoices
        $invoices = Invoice::where('fk_client', '=', $model->id)->orderBy('date_creation', 'asc')->get();
        //Get the service offer
        $servicesOffer = Service::where('fk_company', '=', \Auth::user()->fk_company)->get(); 
        //Render the view 
        return view('client.view', ['model' => $model, 'contactWays' => $contactWays, 'services' => $services, 'invoices' => $invoices, 'servicesOffer' => $servicesOffer]);
    }

    /*
     * This function render's a list of clients
     */

    public function getList() {
        //Get all the clients for the current company
        $clients = Client::where('fk_company', '=', Auth::user()->fk_company)->get();
        return view('client.list', ['clients' => $clients]);
    }

    /*
     * This function get's the typed list of clients
     */

    public function getTypedList($type) {
        //Get all the clients for the current company
        $clients = Client::whereRaw('fk_company = ' . Auth::user()->fk_company . ' AND status = ' . $type)->get();
        return view('client.list', ['clients' => $clients]);
    }

    /*
     * This fucntion catches the angular request and links a service to a client
     * Also if the request indicates, creates a due invoice
     */

    public function ajaxSetService() {
        $request = AngularHelper::parseClientSideData();
        if ($request) {
            //Create the service
            $serviceClient = new ServiceClient;
            $serviceClient->fk_user = Auth::user()->id;
            $serviceClient->fk_service = $request->fk_service;
            $serviceClient->fk_client = $request->fk_client;
            $serviceClient->active = 1;
            //Save the serviceClient
            if ($serviceClient->save()) {
                //Check if the system need's to make a invoice
                if ($request->matricula)
                    if (InvoiceController::createMatriculaInvoice($request->fk_client, $request->fk_service))
                        print_r(json_encode(['result' => 'ok']));
                    else
                        print_r(json_encode(['result' => 'invoiceError']));
                else
                    print_r(json_encode(['result' => 'ok']));
            }else {
                print_r(json_encode(['result' => 'error']));
            }
        } else {
            print_r(json_encode(['result' => 'badData']));
        }
    }

    /*
     * This function searches client
     */

    public function postSearch(Request $request) {
        //Get the data
        $data = $request->all();
        //Get all the clients for the current company
        $clients = Client::whereRaw('fk_company = ' . Auth::user()->fk_company . " AND (name LIKE '%" . $data['q'] . "%' OR lastname_1 = '%" . $data['q'] . "%' OR lastname_2 = '%" . $data['q'] . "%')")->get();
        return view('client.list', ['clients' => $clients]);
    }

    /*
     * Deletes the client with all they info
     */

    public function deleteClient($id) {
        //First of all delete the room reserves
        $roomReserves = RoomReserve::where('fk_client', '=', $id)->get();
        foreach ($roomReserves as $roomReserve) {
            $roomReserve->delete();
        }
        //Delete the service assigned to the client
        $serviceClient = ServiceClient::where('fk_client', '=', $id)->get();
        foreach ($serviceClient as $service) {
            $service->delete();
        }
        //Delete invoices
        $invoices = Invoice::where('fk_client', '=', $id)->get();
        foreach ($invoices as $invoice) {
            InvoiceController::deleteInvoice($invoice->id);
        }
        //Delete the client
        $client = Client::find($id);
        $client->delete();
        //Return to the view
        return redirect('/client/list/1');
    }

    /*
     * This function render's a list with the undue clients for this month
     */

    public function getUndue() {
        $clients = InvoiceController::getUnDueClientsForMonth();
        return view('client.list', ['clients' => $clients]);
    }

    /*
     * This function render's a list with clients without services or services
     * enabled
     */

    public function getWithoutService() {
        //render the view
        return view('client.list', ['clients' => ClientController::getClientsWithoutServices()]);
    }

    /*
     * Return's an array with the client without services
     */

    public static function getClientsWithoutServices() {

        $clients = Client::where('fk_company', '=', \Auth::user()->fk_company)->where('status', '=', 1)->where('is_subscription', '!=', 1)->get();
        $clientsWithoutServices = [];
        //Iterate over the clients
        foreach ($clients as $client) {
            //get services for the client
            $services = ServiceClient::where('active', '=', 1)->where('fk_client', '=', $client->id)->get();
            //if not have any service enter the client into the array
            if (count($services) == 0)
                $clientsWithoutServices[] = $client;
        }
        //
        return $clientsWithoutServices;
    }

    /*
     * Renders a calendar view with availability of the room services
     */

    public function getServicesCalendar($id) {
        $service = Service::find($id);
        $service->serviceId;
        $fakeClient = new Client;
        $fakeClient->id = 0;
        return view('client.calendar', ['service' => $service, 'model' => $fakeClient]);
    }

    /*
     * this function will disable every room reserve for the disabled client
     */

    public function unsuscribeRoom($fk_client) {
        $reserves = RoomReserve::where('fk_client', '=', $fk_client)->get();
        foreach ($reserves as $reserve) {
            $reserve->delete();
        }
    }

}
