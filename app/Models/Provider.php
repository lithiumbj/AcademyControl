<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    //Table definition
    protected $table = 'provider';

    /*
     * Returns the name of the Client
     *
     * @param {Integer} $id - The client id
     *
     * @return {String} The client name
     */
    public static function getProviderName($id)
    {
      $client = Provider::find($id);
      if($client)
        return $client->name.' '.$client->lastname_1.' '.$client->lastname_2;
      else
        return '';
    }
    /*
     * Returns the client list for the company
     */
    public static function getProviders()
    {
      $clients = Provider::where('fk_company', '=', \Auth::user()->fk_company)->get();
      return $clients;
    }
}
