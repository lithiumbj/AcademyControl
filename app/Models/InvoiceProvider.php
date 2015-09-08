<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class InvoiceProvider extends Model
{
    //Table definition
    protected $table = 'invoice_provider';

    /*
     * Return's the 5 days lapsed invoices
     */
    public static function getInvoices($fk_provider)
    {
      $invoices = InvoiceProvider::whereRaw('fk_provider = '.$fk_provider)->get();
      return $invoices;
    }
    /*
     * Return's the waste per month
     */
    public static function getMonthlyMoney()
    {
       $data = DB::table('invoice_provider')
          ->select(DB::raw("SUM(total + tax) AS total, MONTH(date_creation) AS month"))
          ->whereRaw("fk_company = ".Auth::user()->fk_company." AND YEAR(date_creation) = ".date('Y')." GROUP BY MONTH(date_creation)")
          ->get();
      //Return the data
      return $data;
    }
}
