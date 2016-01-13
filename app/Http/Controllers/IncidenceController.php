<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Models\Assistance;
use App\Models\ClientReport;
use App\Models\RoomReserve;
use App\Models\RoomService;
use App\Models\ClientIncidence;
use App\Models\ServiceClient;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SMSController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use Validator;
use DB;

/*
 * Aglutinates the assistance, incidence and report functions of the ERP
 */

class IncidenceController extends Controller {
    /*
     * This function returns if the client has his assistance checked in or not for today
     *
     * @param {Integer} $id - The id of the client to check for
     * @param {Integer} $fk_room_reserve - The id of the reserve
     *
     * @return {Boolean/Null} true if yes or false if not, also null if it's not given
     */

    public static function isChekedIn($id, $fk_room_reserve) {
        $assistance = Assistance::whereRaw('fk_client = ' . $id . ' AND fk_room_reserve = ' . $fk_room_reserve . ' AND date(created_at) = "' . date('Y-m-d') . '"')->first();
        if ($assistance)
            return $assistance->assist;
        else
            return null;
    }

    /*
     * This function check's in the client
     */

    public function checkIn(Request $request) {
        $data = $request->all();
        //First of all check if exists the checkin
        $checkIn = Assistance::whereRaw('fk_client = ' . $data['fk_client'] . ' AND fk_room_reserve = ' . $data['fk_room_reserve'] . ' AND date(created_at) = "' . date('Y-m-d') . '"')->first();
        if ($checkIn) {
            //Update
            $checkIn->assist = $data['assist'];
            //Save
            if ($checkIn->save()) {
                if ($data['assist'] == 0) {
                    $client = Client::find($checkIn->fk_client);
                    //Only do the sms send if the user have parents phone
                    if (strlen($client->phone_parents) > 8 && (substr($client->phone_parents, 0, 1) == 6 || (substr($client->phone_parents, 0, 1) == 7)))
                        SMSController::sendAssistanceSms($client->phone_parents, $client->name, $client->id);
                    echo 'okWithSMS';
                    die;
                }
                echo 'ok';
            }else {
                echo 'ko';
            }
        } else {
            //Create and save
            $assistance = new Assistance;
            $assistance->fk_user = Auth::user()->id;
            $assistance->fk_company = Auth::user()->fk_company;
            $assistance->fk_room_reserve = $data['fk_room_reserve'];
            $assistance->fk_client = $data['fk_client'];
            $assistance->assist = $data['assist'];
            $saveStatus  = $assistance->save();
            if ($data['assist'] == 0) {
                $client = Client::find($assistance->fk_client);
                //Only do the sms send if the user have parents phone
                if (strlen($client->phone_parents) > 8 && (substr($client->phone_parents, 0, 1) == 6 || (substr($client->phone_parents, 0, 1) == 7)))
                    SMSController::sendAssistanceSms($client->phone_parents, $client->name, $client->id);
                    echo 'okWithSMS';
                    die;
            }
            //Save
            if ($saveStatus)
                echo 'ok';
            else
                echo 'ko';
        }
    }

    /*
     * This function creates a incidence for the client
     */

    public function createClientIncidence(Request $request) {
        $data = $request->all();
        $incidence = new ClientIncidence;
        //Set basic fk's
        $incidence->fk_client = $data['fk_client'];
        $incidence->fk_user = Auth::user()->id;
        $incidence->fk_company = Auth::user()->fk_company;
        //Other data
        $incidence->concept = $data['concept'];
        $incidence->observations = $data['description'];
        //Save
        if ($incidence->save())
            echo 'ok';
        else
            echo 'ko';
    }

    /*
     * This function returns the client report
     */

    public function getClientReport(Request $request) {
        $data = $request->all();
        //Get the service
        $roomReserve = RoomReserve::find($data['fk_service']);
        $roomService = RoomService::find($roomReserve->fk_room_service);
        //Execute final query
        $reports = ClientReport::whereRaw('fk_client = ' . $data['fk_client'] . ' AND fk_service = ' . $roomService->fk_service." AND is_calification IS NULL")->get();
        //Print return
        print_r(json_encode($reports));
    }
    /*
     * This function returns the client califications
     */

    public function getClientCalifications(Request $request) {
        $data = $request->all();
        //Get the service
        $roomReserve = RoomReserve::find($data['fk_service']);
        $roomService = RoomService::find($roomReserve->fk_room_service);
        //Execute final query
        $reports = ClientReport::whereRaw('fk_client = ' . $data['fk_client'] . ' AND fk_service = ' . $roomService->fk_service." AND is_calification = 1")->get();
        //Print return
        print_r(json_encode($reports));
    }

    /*
     * This function creates a client report
     */

    public function crateClientReport(Request $request) {
        $data = $request->all();
        //Create model and fill it
        $report = new ClientReport;
        $report->fk_user = Auth::user()->id;
        $report->fk_company = Auth::user()->fk_company;
        $report->fk_client = $data['fk_client'];
        $report->color = $data['color'];
        //check if is a calification
        if(isset($data['is_calification']))
            $report->is_calification = $data['is_calification'];

        //Get the service
        $roomReserve = RoomReserve::find($data['fk_service']);
        $roomService = RoomService::find($roomReserve->fk_room_service);
        //
        $report->fk_service = $roomService->fk_service;
        $report->concept = $data['concept'];
        $report->observations = $data['observations'];
        if ($report->save())
            return 'ok';
        else
            return 'ko';
    }

    /*
     * This function get's all the client incidencies
     */

    public function getClientIncidences() {
        $incidences = ClientIncidence::whereRaw('fk_company = ' . Auth::user()->fk_company . ' AND seen IS NULL')->get();
        return view('client.incidences', ['incidences' => $incidences]);
    }

    /*
     * This function completes the incidence
     */

    public function completeIncidence($id) {
        //Load the incidence
        $incidence = ClientIncidence::find($id);
        //Update the user and seen values
        $incidence->seen = 1;
        $incidence->fk_user = Auth::user()->id;
        //Save
        $incidence->save();
        //Redirect to the list
        return redirect('/incidence/client');
    }

    /*
     * This function returns an array with the client incidences
     */

    public static function fetchClientIncidences($fk_client) {
        $incidences = ClientIncidence::where('fk_client', '=', $fk_client)->get();
        return $incidences;
    }

    /*
     * This function renders the client assistance list view
     */

    public function getAssitanceList() {
        $assistance = Assistance::whereRaw('fk_company = ' . Auth::user()->fk_company . ' AND assist = 0')->get();
        return view('client.assistance', ['incidences' => $assistance]);
    }

    /*
     * This function fetchs the list of assistances
     */

    public static function fetchAssitanceList($fk_client) {
        $assistance = Assistance::whereRaw('fk_client = ' . $fk_client . ' AND assist = 0')->get();
        return $assistance;
    }

    /*
     * This function deletes the client report by their id
     */

    public function deleteClientReport(Request $request) {
        $id = $request->all()['id'];
        //Get the report
        $report = ClientReport::where('id', '=', $id)->first();
        //Delete and return awnser to script
        if ($report->delete())
            echo 'ok';
        else
            echo 'ko';
    }

    /*
     * This function modifies the client report by their id (And text)
     */

    public function editClientReport(Request $request) {
        $id = $request->all()['id'];
        $observations = $request->all()['observations'];
        //Get the report
        $report = ClientReport::where('id', '=', $id)->first();
        //Modify the data
        $report->observations = $observations;
        if ($report->save())
            echo 'ok';
        else
            echo 'ko';
    }

}
