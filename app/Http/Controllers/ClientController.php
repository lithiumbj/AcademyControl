<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Models\ContactWay;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;

class ClientController extends Controller
{
    /**
     * Shows the create client's create form
     */
    public function getCreate()
    {
      //get the contat way's
      $contactWays = ContactWay::all();
      //render the view
      return view('client.create', ['contactWays' => $contactWays]);
    }

    /*
     * Insert's the client into the database or returns an error
     */
    public function postCreate(Request $request)
    {
      //Get the data
      $data = $request->all();
      //Filter the data to check if any is wrong
      $validator = Validator::make($data, [
           'name' => 'required|max:254',
           'lastname_1' => 'required|max:254',
           'address' => 'required|max:254',
       ]);
       //Check if validator fails
       if(!$validator->fails()){
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
         $client->status = $data['status'];
         $client->phone_parents = $data['phone_parents'];
         $client->phone_client = $data['phone_client'];
         $client->phone_whatsapp = $data['phone_whatsapp'];
         $client->fk_contact_way = $data['fk_contact_way'];
         $client->email_parents = $data['email_parents'];
         $client->email_client = $data['email_client'];
         $client->cp = $data['cp'];
         $client->other_address_info = $data['other_address_info'];

         //Save the client
         if($client->save()){
           //Ok, go to view
            return redirect('client/view/'.$client->id);
         }else{
           //ko, return to form
           return redirect('client/create')
                    ->withErrors($validator)
                    ->withInput();
         }
       }else{
         //Innitial validation KO, redirect to form
         return redirect('client/create')
                  ->withErrors($validator)
                  ->withInput();
       }
    }
    /*
     * Render's the view of the model
     */
    public function getView($id)
    {
      $model = Client::find($id);
      return view('client.view',['model' => $model]);
    }
}
