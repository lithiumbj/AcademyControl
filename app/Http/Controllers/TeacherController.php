<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Service;
use App\Models\Client;
use App\Models\ServiceClient;
use App\Models\RoomService;
use App\Models\RoomReserve;
use App\Http\Controllers\Controller;
use App\Helpers\AngularHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class TeacherController extends Controller {
    /*
     * Return the actual linked services for the teacher
     */

    public static function getServicesForTeacher() {
        $services = Service::where('fk_teacher', '=', Auth::user()->id)->get();
        return $services;
    }

    /*
     * This function returns the services for an hour and a day for the service id
     *
     */

    public static function getServicesForHourAndDay($fk_service, $hour, $day) {
        $services = RoomService::whereRaw('fk_service = ' . $fk_service . ' AND hour = ' . $hour . ' AND day = ' . $day)->get();
        return $services;
    }

    /*
     * This function renders the teacher view for a specific group
     */

    public function getTeacherView() {
        //Get the data
        $data = $_GET;
        //Get the client list
        $roomReserves = RoomReserve::whereRaw('fk_room = ' . $data['room'] . ' AND hour = ' . $data['hour'] . ' AND day = ' . $data['day'])->get();
        $clients = [];
        foreach ($roomReserves as $RoomReserve) {
            $tmpArray = [];
            $tmpArray[] = Client::find($RoomReserve->fk_client);
            $tmpArray[] = $RoomReserve->id;
            //Check for duplicates
            if(!$this->checkDuplicatedItems($clients, $tmpArray))
                $clients[] = $tmpArray;
        }
        //Render the view
        return view('teacher.teach', ['clients' => $clients]);
    }

    /*
     * Checks for duplicates in the array
     * 
     * @param {Array} $array - The data array
     * @param {Array} $object - The data array (with only one object)
     */

    public function checkDuplicatedItems($array, $object) {
        foreach ($array as $item) {
            if ($object[0]->id == $item[0]->id)
                return true;
        }
        return false;
    }

    /*
     * This function returns the amounth of clients for a specific room, hour, and day
     * 
     * @param {String} $room - The room id
     * @param {String} $hour - The room id
     * @param {String} $day - The room id
     * 
     * return {Integer} The quantity of people
     */

    public static function getClientsForHour($room, $hour, $day) {
        //Get the data
        $data = $_GET;
        //Get the client list
        $roomReserves = RoomReserve::whereRaw('fk_room = ' . $room . ' AND hour = ' . $hour . ' AND day = ' . $day)->get();
        $clients = [];
        foreach ($roomReserves as $RoomReserve) {
            $tmpArray = [];
            $tmpArray[] = Client::find($RoomReserve->fk_client);
            $tmpArray[] = $RoomReserve->id;
            $clients[] = $tmpArray;
        }
        //Render the view
        return count($clients);
    }

}
