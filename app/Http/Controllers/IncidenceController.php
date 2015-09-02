<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Models\Assistance;
use App\Models\ServiceClient;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\AngularHelper;

use Validator;
use DB;

/*
 * Aglutinates the assistance, incidence and report functions of the ERP
 */
class IncidenceController extends Controller
{
  /*
   * This function returns if the client has his assistance checked in or not for today
   *
   * @param {Integer} $id - The id of the client to check for
   * @param {Integer} $fk_room_reserve - The id of the reserve
   *
   * @return {Boolean/Null} true if yes or false if not, also null if it's not given
   */
  public static function isChekedIn($id, $fk_room_reserve)
  {
    $assistance = Assistance::whereRaw('fk_client = '.$id.' AND fk_room_reserve = '.$fk_room_reserve.' AND date(created_at) = "'.date('Y-m-d').'"')->first();
    if($assistance)
      return $assistance->assist;
    else
      return null;
  }

  /*
   * This function check's in the client
   */
  public function checkIn(Request $request)
  {
    $data = $request->all();
    //First of all check if exists the checkin
    $checkIn = Assistance::whereRaw('fk_client = '.$data['fk_client'].' AND fk_room_reserve = '.$data['fk_room_reserve'].' AND date(created_at) = "'.date('Y-m-d').'"')->first();
    if($checkIn){
      //Update
      $checkIn->assist = $data['assist'];
      //Save
      if($checkIn->save())
        echo 'ok';
      else
        echo 'ko';
    }else {
      //Create and save
      $assistance = new Assistance;
      $assistance->fk_user = Auth::user()->id;
      $assistance->fk_company = Auth::user()->fk_company;
      $assistance->fk_room_reserve = $data['fk_room_reserve'];
      $assistance->fk_client = $data['fk_client'];
      $assistance->assist = $data['assist'];
      //Save
      if($assistance->save())
        echo 'ok';
      else
        echo 'ko';
    }
  }
}
