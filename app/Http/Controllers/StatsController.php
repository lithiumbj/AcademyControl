<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\ContactWay;
use App\Models\Cashflow;
use App\Models\ServiceClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use Validator;
use DB;

class StatsController extends Controller {
    /*
     * Renders a view with new clients stats
     */

    public function getNewClients() {
        $clients = DB::table('client')
                ->groupBy(DB::raw('YEAR(client.created_at), MONTH(client.created_at)'))
                ->whereRaw('client.status = 1')
                ->select(DB::raw('count(id) AS count, YEAR(created_at) AS year, MONTH(created_at) AS month'))
                ->get();
        return view('stats.newClients', ['data' => $clients]);
    }

    /*
     * Renders a view with new infos stats
     */

    public function getNewInfos() {
        $clients = DB::table('client')
                ->groupBy(DB::raw('YEAR(client.created_at), MONTH(client.created_at)'))
                ->whereRaw('client.status = 0 OR (client.status = 1 AND client.was_info = 1)')
                ->select(DB::raw('count(id) AS count, YEAR(created_at) AS year, MONTH(created_at) AS month'))
                ->get();
        return view('stats.newInfos', ['data' => $clients]);
    }

    /*
     * Renders a view with information to client conversion
     */

    public function getInfoToClientConversions() {
        $clients = DB::table('client')
                ->groupBy(DB::raw('YEAR(client.created_at), MONTH(client.created_at)'))
                ->whereRaw('client.status = 1 AND client.was_info = 1')
                ->select(DB::raw('count(id) AS count, YEAR(created_at) AS year, MONTH(created_at) AS month'))
                ->get();
        return view('stats.conversions', ['data' => $clients]);
    }

    /*
     * Renders a view with information refered to client to ex-client conversion
     */

    public function getClientToExclientConversions() {
        $clients = DB::table('client')
                ->groupBy(DB::raw('YEAR(client.date_cancelation), MONTH(client.date_cancelation)'))
                ->whereRaw('client.status = 2')
                ->select(DB::raw('count(id) AS count, YEAR(date_cancelation) AS year, MONTH(date_cancelation) AS month'))
                ->get();
        return view('stats.newExclients', ['data' => $clients]);
    }

    /*
     * Return's the clients-by-service configurator view
     */

    public function getClientByService() {
        $services = Service::fetchCompanyServices();
        return view('stats.clientsByService', ['services' => $services]);
    }

    /*
     * This function returns the client search query for the requested services
     * 
     * @param {Request} $request - The post request
     * 
     * @return {JSON} the data
     */

    public function postClientByService(Request $request) {
        $data = $request->all();
        $where = '';
        $isFirst = true;
        //Generate a dinamic where for the query
        foreach ($data['data'] as $fk_service) {
            if ($isFirst)
                $where.=" (";
            if (!$isFirst)
                $where.=' ' . $data['condition'] . ' ';
            $where.= 'service_client.fk_service = ' . $fk_service['id'];
            //Set the initial value to false
            $isFirst = false;
        }
        //Generate the query
        $clients = DB::table('client')
                ->whereRaw($where . " ) AND service_client.active = 1")
                ->join('service_client', 'service_client.fk_client', '=', 'client.id')
                ->join('users', 'users.id', '=', 'client.fk_user')
                ->select(DB::raw('client.*, users.name AS username'))
                ->get();
        //generate the JSON
        print_r(json_encode($clients));
    }
    
    /*
     * Returns an array with the incomplete clients
     */
    public static function fetchIncompleteClients() {
        //Generate the query
        $clients = DB::table('client')
                ->whereRaw("client.status = 1 AND (lastname_1 = '' OR client.address = '' OR client.address = 'C/' OR client.poblation = '' OR client.city = '' OR ((phone_parents = '' AND phone_client = '' AND phone_whatsapp = '') OR (phone_parents = 0 AND phone_client = 0 AND phone_whatsapp = 0)) OR fk_contact_way = 99) OR (nif = '' OR parnet_nif = '')")
                ->join('users', 'users.id', '=', 'client.fk_user')
                ->select(DB::raw('client.*, users.name AS username'))
                ->get();
        return $clients;
    }
    
    public function getIncompleteClients() {
        return view('stats.incompleteClients', ['clients' => StatsController::fetchIncompleteClients()]);
    }

}
