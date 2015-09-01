<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Service;
use App\Models\ServiceClient;
use App\Models\RoomService;
use App\Models\RoomReserve;
use App\Http\Controllers\Controller;
use App\Helpers\AngularHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
class ServicesController extends Controller
{
    /**
     * Show's the service's list
     */
    public function getList()
    {
      $services = Service::where('fk_company', '=', Auth::user()->fk_company)->get();
      return view('services.list',['services' => $services]);
    }

    /*
     * This function creates the new service
     */
    public function postCreate(Request $request)
    {
      //Get the data
      $data = $request->all();
      //Filter the data to check if any is wrong
      $validator = Validator::make($data, [
           'name' => 'required|max:254',
           'description' => 'required|max:254',
           'iva' => 'required|max:254',
           'price' => 'required|max:254',
           'matricula' => 'required|max:254',
       ]);
       //Check if validator fails
       if(!$validator->fails()){
         //Innitial validation ok
         $service = new Service();

         $service->name = $data['name'];
         $service->description = $data['description'];
         $service->iva = $data['iva'];
         $service->price = $data['price'];
         $service->matricula = $data['matricula'];
         $service->fk_company = $data['is_active'];
         //Set fixed fk's
         $service->is_active = 1;

         //Save the client
         if($service->save()){
           //Ok, go to view
            return redirect('/services');
         }else{
           //ko, return to form
           return redirect('/services')
                    ->withErrors(['Error' => 'Error desconocido'])
                    ->withInput();
         }
       }else{
         //Innitial validation KO, redirect to form
         return redirect('/services')
                  ->withErrors($validator)
                  ->withInput();
       }
    }
    /*
     * Return's as json the service extra info
     */
    public function ajaxGetProductInfo()
    {
      $request = AngularHelper::parseClientSideData();
      if($request){
        return Service::find($request->id);
      }else{
        return '[]';
      }
    }

    /*
     * Erases the link between a service and the client, also erases the room reserve
     * asgination
     */
    public function getUnlink($id)
    {
      //Get the ServiceUser object
      $serviceClient = ServiceClient::find($id);
      //First of all unlink the room reserves (horario)
      $roomServices = RoomService::whereRaw('fk_service = '.$serviceClient->fk_service)->get();
      //for every roomservice look for a coincidence in the roomReserve and delete
      foreach($roomServices as $roomService){
        $roomReserves = RoomReserve::whereRaw('fk_room_service = '.$roomService->id.' AND fk_client = '.$serviceClient->fk_client)->get();
        //Delete them
        foreach($roomReserves as $roomReserve){
          //!!Delete!
          $roomReserve->delete();
        }
      }
      //After all, delete the relation between user and service
      $serviceClient->delete();
      //return a redirect
      return redirect('/client/view/'.$serviceClient->fk_client);
    }

    /*
     * This function updates the service based on his id
     */
    public function postUpdate(Request $request)
    {
      //Get the data
      $data = $request->all();
      //Filter the data to check if any is wrong
      $validator = Validator::make($data, [
           'name' => 'required|max:254',
           'description' => 'required|max:254',
           'iva' => 'required|max:254',
           'price' => 'required|max:254',
           'matricula' => 'required|max:254',
       ]);
       //Check if validator fails
       if(!$validator->fails()){
         //Innitial validation ok
         $service = Service::find($data['id']);

         $service->name = $data['name'];
         $service->description = $data['description'];
         $service->iva = $data['iva'];
         $service->price = $data['price'];
         $service->matricula = $data['matricula'];
         $service->fk_company = $data['is_active'];
         //Set fixed fk's
         $service->is_active = 1;

         //Save the client
         if($service->save()){
           //Ok, go to view
            return redirect('/services');
         }else{
           //ko, return to form
           return redirect('/services')
                    ->withErrors(['Error' => 'Error desconocido'])
                    ->withInput();
         }
       }else{
         //Innitial validation KO, redirect to form
         return redirect('/services')
                  ->withErrors($validator)
                  ->withInput();
       }
    }
    /*
     * This function deletes the service
     */
    public function getDelete($id)
    {
      $service = Service::find($id);
      //Delete the relation with client
      $serviceClient = ServiceClient::where("fk_service", "=", $service->id)->get();
      foreach($serviceClient as $srv){
        $srv->delete();
      }
      //Delete the relation with room_service
      $roomService = RoomService::where("fk_service", "=", $service->id)->get();
      foreach($roomService as $srv){
        $roomReserve = RoomReserve::where("fk_room_service", "=", $srv->id)->get();
        foreach($roomReserve as $rsv){
          $rsv->delete();
        }
        $srv->delete();
      }
      //Delete the reserve room
      $service->delete();

      return redirect('/services');
    }

    /*
     * This function return's the active and linked services number
     */
    public static function getTotalLinkedServices()
    {
      $services = ServiceClient::all();
      return count($services);
    }
}
