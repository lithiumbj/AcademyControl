<?php
namespace App\Helpers;

class DateHelper{

  /*
   * Return's the date in a european human way
   */
  public static function getDate($date)
  {
    return date('d/m/Y', strtotime($date));
  }

}
