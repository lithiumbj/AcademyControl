<?php
namespace App\Helpers;

use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class SettingsHelper{

    /*
     * Returns a setting property from the db
     */
  	public static function fetchSetting($key)
    {
      $property = Settings::whereRaw('clave = "'.$key.'" AND fk_company = '.Auth::user()->fk_company)->first();
      if($property)
        return $property->value;
      else
        return '';
    }
    /*
     * Sets a setting property from the db if not exists, creates it
     */
  	public static function setSetting($key, $value)
    {
      $property = Settings::whereRaw('clave = "'.$key.'" AND fk_company = '.Auth::user()->fk_company)->first();
      //Check if propery exists
      if($property){
        //Update value
        $property->value = $value;
        $property->save();
      }else{
        //Create new one
        $property = new Settings;
        $property->fk_company = Auth::user()->fk_company;
        $property->clave = $key;
        $property->value = $value;
        $propery->save();
      }
    }
}
