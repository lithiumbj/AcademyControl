<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Service;
use App\Models\Room;
use App\Models\RoomService;
use App\Models\RoomReserve;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use DB;

class RoomController extends Controller
{
  /*
   * Generates a view with all the rooms available for the company
   */
  public function getPreview($roomId = null)
  {
    //Get the rooms
    $rooms = Room::where('fk_company', '=', Auth::user()->fk_company)->get();
    if($roomId){
      //Render the view
      return view('rooms.preview',['rooms' => $rooms, 'fk_room' => $roomId]);
    }else{
      //Render the view
      return view('rooms.preview',['rooms' => $rooms, 'fk_room' => 0]);
    }
  }

  /*
   * This function get's the post request and creates a new room
   */
  public function postCreate(Request $request)
  {
    $data = $request->all();
    //If the class have any name continue, if not return
    if(strlen($data['name'])>0){
      $room = new Room;
      $room->name = $data['name'];
      $room->capacity = $data['capacity'];
      $room->fk_company = Auth::user()->fk_company;
      $room->is_active = 1;
      //If saved ok, continue if not return with error
      if($room->save())
        return redirect('/rooms');
      else
        return redirect('/rooms');
    }else{
      return redirect('/rooms');
    }
  }

  /*
   * This fucntion asigns a service to an specific room and day and hour
   */
  public function postAssignToService(Request $request)
  {
    $data = $request->all();
    //Create model
    $assign = new RoomService;
    $assign->fk_user = Auth::user()->id;
    $assign->fk_service = $data['fk_service'];
    $assign->fk_room = $data['fk_room'];
    $assign->day = $data['day'];
    $assign->hour = $data['hour'];
    //save
    $assign->save();
    //redirect
    return redirect('/rooms');
  }

  /*
   * This function returns an array of services for every room, day and hour
   *
   * @param {Integer} $fk_room - The room id
   * @param {Integer} $day - Day number (1-6)
   * @param {Integer} $hour - Hour number (10-21)
   */
  public static function getServicesForRoom($fk_room, $day, $hour)
  {
    $services = DB::table('room_service')
      ->join('service', 'service.id', '=', 'room_service.fk_service')
      ->whereRaw("fk_room = ".$fk_room." AND day = ".$day." AND hour = ".$hour)
      ->select('room_service.id', 'service.name')
      ->get();
    if($services)
      return $services;
    else
      return [];
  }

  /*
   * This function return the avalable and the availability of the rooms
   * for a specific service
   *
   * @param {Integer} $fk_service - The service id
   * @param {Integer} $hour - The hour
   * @param {Integer} $day - The day
   *
   * @return {Mixed[]} The array with the data
   */
  public static function getRoomsForService($fk_service, $hour, $day)
  {
    $rooms = DB::table('room_service')
      ->join('room', 'room.id', '=', 'room_service.fk_room')
      ->whereRaw('room_service.fk_service = '.$fk_service.' AND room_service.hour = '.$hour.' AND room_service.day = '.$day)
      ->select('room_service.id', 'room.name', 'room.capacity')
      ->get();
      //return the data
      return $rooms;
  }
  /*
   * Return's the ocupance number for a specific group
   */
  public static function getRoomOcupance($fk_room_service)
  {
    $ocupance = RoomReserve::where('fk_room_service','=', $fk_room_service)->count();
    return $ocupance;
  }

  /*
   * This static funtion check's if the user is enroled into a specific service
   *
   * @param {Integer} $fk_room_service - The room service assignment id
   * @param {Integer} $fk_client - The client's id
   */
  public static function isClientEnroled($fk_room_service, $fk_client)
  {
    return RoomReserve::whereRaw('fk_room_service = '.$fk_room_service. ' AND fk_client = '.$fk_client)->get();
  }
  /*
   * This function enroles a client into a group (rooms)
   */
  public function postAssignClientToGroup(Request $request)
  {
    $roomReserve = new RoomReserve;
    $data = $request->all();
    //Set parametters
    $roomReserve->fk_company = Auth::user()->fk_company;
    $roomReserve->fk_user = Auth::user()->id;
    $roomReserve->fk_client = $data['fk_client'];
    $roomReserve->fk_room_service = $data['fk_room_service'];
    //Save it
    $roomReserve->save();
    return redirect('/client/view/'.$data['fk_client']);
  }

  /*
   * This function unlinks the client in the group
   */
  public function postDelinkClient(Request $request)
  {
      $data = $request->all();
      $roomReserve = RoomReserve::whereRaw('fk_client = '.$data['fk_client'].' AND fk_room_service = '.$data['fk_room_service']);
      //Delete it if exists
      if($roomReserve)
        $roomReserve->delete();
      //Return to the client's view
      return redirect('/client/view/'.$data['fk_client']);
  }
}
