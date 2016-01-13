<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';

    /*
     * Return's statically all the current logged in company services
     */
    public static function fetchCompanyServices()
    {
      $services = Service::where('fk_company', '=', \Auth::user()->fk_company)->get();
      //Check if services array is not null, and if not return they
      if($services)
        return $services;
      else
        return [];
    }
}
