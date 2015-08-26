<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Service;
use App\Models\Room;
use App\Models\RoomService;
use App\Models\RoomReseve;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
class RoomController extends Controller
{
  /*
   * Generates a view with all the rooms available for the company
   */
  public function getPreview()
  {
    //Get the rooms
    $rooms = Room::where('fk_company', '=', Auth::user()->fk_company)->get();
    //Render the view
    return view('rooms.preview',['rooms' => $rooms]);
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
}
