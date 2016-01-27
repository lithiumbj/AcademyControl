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
       //SELECT MONTH(date_creation) AS mes, SUM(total) AS total FROM `invoice` WHERE status = 1 AND YEAR(date_creation) = "2015" GROUP BY MONTH(date_creation)
        $data = DB::table('invoice')
                ->groupBy(DB::raw('YEAR(date_creation), MONTH(date_creation)'))
                ->join('invoice_payments','invoice_payments.fk_invoice','=','invoice.id')
                ->whereRaw('date_creation BETWEEN "'.date('Y-m-d', strtotime(date('Y-m-d')." - 1 year")).'" AND "'.date('Y-m-d').'" AND invoice.fk_company = '.\Auth::user()->fk_company)
                ->select(DB::raw('MONTH(date_creation) AS month, YEAR(date_creation) AS year, SUM(invoice_payments.total) AS total '))
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
