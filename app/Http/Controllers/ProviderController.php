<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Provider;
use App\Models\InvoiceProvider;
use App\Models\InvoiceProviderLine;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\AngularHelper;

use DB;
use View;
use Validator;

class ProviderController extends Controller
{
    /*
     * This function render's the list view with the providers
     */
    public function getList()
    {
        return view('provider.list',['providers' => Provider::getProviders()]);
    }
    
    /*
     * This function render's the create form
     */
    public function getCreate()
    {
        return view('provider.create');
    }
    
    /*
     * Insert's the provider into the database or returns an error
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
         $provider = new Provider();
         //Set the auto-foreign keys
         $provider->fk_company = Auth::user()->fk_company;
         //Load data
         $provider->name = $data['name'];
         $provider->lastname_1 = $data['lastname_1'];
         $provider->lastname_2 = $data['lastname_2'];
         $provider->nif = $data['nif'];
         $provider->address = $data['address'];
         $provider->poblation = $data['poblation'];
         $provider->city = $data['city'];
         $provider->email = $data['email'];
         $provider->cp = $data['cp'];
         $provider->other_address_info = $data['other_address_info'];

         //Save the client
         if($provider->save()){
           //Ok, go to view
            return redirect('provider/view/'.$provider->id);
         }else{
           //ko, return to form
           return redirect('provider/create')
                    ->withErrors($validator)
                    ->withInput();
         }
       }else{
         //Innitial validation KO, redirect to form
         return redirect('provider/create')
                  ->withErrors($validator)
                  ->withInput();
       }
    }
    
    /*
     * This function renders the provider view
     */
    public function getProvider($id)
    {
      $model = Provider::find($id);
      //get the contat way's
      //$invoices = Invoice::where('fk_client', '=', $model->id)->orderBy('date_creation', 'asc')->get();
      $invoices = [];
      //Render the view
      return view('provider.view',['model' => $model, 'invoices' => $invoices]);
    }
    
    /*
     * Render's the update of the model
     */
    public function getUpdate($id)
    {
      $model = Provider::find($id);
      return view('provider.update',['model' => $model]);
    }

    /*
     * This function is called to update a provider model
     */
    public function postUpdate(Request $request)
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
          $provider = Provider::find($data['id']);
          //Load data
          $provider->name = $data['name'];
          $provider->lastname_1 = $data['lastname_1'];
          $provider->lastname_2 = $data['lastname_2'];
          $provider->nif = $data['nif'];
          $provider->address = $data['address'];
          $provider->poblation = $data['poblation'];
          $provider->city = $data['city'];
          $provider->phone = $data['phone'];
          $provider->email = $data['email'];
          $provider->cp = $data['cp'];
          $provider->other_address_info = $data['other_address_info'];

          //Save the client
          if($provider->save()){
            //Ok, go to view
             return redirect('provider/view/'.$provider->id);
          }else{
            //ko, return to form
            return redirect('provider/update/'.$provider->id)
                     ->withErrors($validator)
                     ->withInput();
          }
        }else{
          //Innitial validation KO, redirect to form
          return redirect('provider/update/'.$provider->id)
                   ->withErrors($validator)
                   ->withInput();
        }
     }
     
     /*
      * @TO-DO
      * this function deletes the provider
      */
     public function getDelete($id)
     {
         //Get the invoices
         $invoices = InvoiceProvider::where('fk_provider','=',$id)->get();
         foreach($invoices as $invoice){
            //Get the invoice lines
            $lines = InvoiceProviderLine::where('fk_provider_invoice', '=', $invoice->id)->get();
            foreach($lines as $line){
                $line->delete();
            }
            $invoice->delete();
         }
         //Delete the provider
         $provider = Provider::find($id);
         $provider->delete();
         return redirect('/provider');
     }
}
