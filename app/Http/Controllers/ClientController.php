<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Http\Controllers\Controller;
use Validator;

class ClientController extends Controller
{
    /**
     * Shows the create client's create form
     */
    public function getCreate()
    {
      return view('client.create');
    }

    /*
     * Insert's the client into the database or returns an error
     */
    public function postCreate()
    {
      //Get the data
      $data = $_POST;
      //Filter the data to check if any is wrong
      $validator = Validator::make($data, [
           'name' => 'required|max:254',
           'lastname_1' => 'required|max:254',
           'address' => 'required|max:254',
       ]);
       //Check if validator fails
       if(!$validator->fails()){
         //Innitial validation ok
         var_dump($_POST);
       }else{
         //Innitial validation KO, redirect to form
         return redirect('client/create')
                  ->withErrors($validator)
                  ->withInput();
       }
    }
}
