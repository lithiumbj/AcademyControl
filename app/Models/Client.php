<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //Table definition
    protected $table = 'client';

    /*
     * Returns the name of the Client
     *
     * @param {Integer} $id - The client id
     *
     * @return {String} The client name
     */
    public static function getClientName($id)
    {
      $client = Client::find($id);
      return $client->name.' '.$client->lastname_1.' '.$client->lastname_2;
    }
    /*
     * Returns the client list for the company
     */
    public static function getClients()
    {
      $clients = Client::where('fk_company', '=', \Auth::user()->fk_company)->get();
      return $clients;
    }
}
