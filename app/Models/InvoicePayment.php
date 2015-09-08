<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

class InvoicePayment extends Model
{
    //Table definition
    protected $table = 'invoice_payments';

    /*
     * This function returns the current revenue for the current year
     */
     public static function getMonthlyMoney()
     {
       $data = DB::table('invoice_payments')
          ->select(DB::raw("SUM(total) AS total, MONTH(created_at) AS month"))
          ->whereRaw("fk_company = ".Auth::user()->fk_company." AND YEAR(created_at) = ".date('Y')." GROUP BY MONTH(created_at)")
          ->get();
      //Return the data
      return $data;
     }

     /*
      * Get's the current due
      */
     public static function getDue()
     {
       $income = DB::table('invoice_payments')->where("fk_company",'=',Auth::user()->fk_company)->sum('total');
       $due = DB::table('invoice')->where("fk_company",'=',Auth::user()->fk_company)->sum('total');
       //Return the data
       return $due - $income;
     }
}
