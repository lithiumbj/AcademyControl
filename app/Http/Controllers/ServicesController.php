<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Service;
use App\Http\Controllers\Controller;

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
}
