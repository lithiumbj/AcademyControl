<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Invoice extends Model
{
    //Table definition
    protected $table = 'invoice';

    /*
     * Return's the 5 days lapsed invoices
     */
    public static function get5DaysInvoices()
    {
      $invoices = Invoice::whereRaw('fk_company = '.\Auth::user()->fk_company.' AND (status != 0 AND status != 2) AND date_creation < "'.date('Y-m-d', strtotime(date('Y-m-d').' -5 days')).'"')->get();
      return $invoices;
    }
    /*
     * Return's the 10 days lapsed invoices
     */
    public static function get10DaysInvoices()
    {
      $invoices = Invoice::whereRaw('fk_company = '.\Auth::user()->fk_company.' AND (status != 0 AND status != 2) AND date_creation < "'.date('Y-m-d', strtotime(date('Y-m-d').' -10 days')).'"')->get();
      return $invoices;
    }
    
    /*
     * Return's the 60 days lapsed invoices
     */
    public static function get60DaysInvoices()
    {
      $invoices = Invoice::whereRaw('fk_company = '.\Auth::user()->fk_company.' AND (status != 0 AND status != 2) AND date_creation < "'.date('Y-m-d', strtotime(date('Y-m-d').' -2 months')).'"')->get();
      return $invoices;
    }

    /*
     * Returns the invoice DUE's for every month in the current year
     */
    public static function getMonthlyDue()
    {
        //Get the invoiced monhts
        $months = DB::table('invoice')
                ->groupBy(DB::raw('YEAR(date_creation), MONTH(date_creation)'))
                ->whereRaw('date_creation BETWEEN "'.date('Y-m-d', strtotime(date('Y-m-d')." - 1 year")).'" AND "'.date('Y-m-d').'"')
                ->select(DB::raw('MONTH(date_creation) AS month, YEAR(date_creation) AS year, \'0\' AS total'))
                ->get();
        //SELECT MONTH(date_creation) AS mes, SUM(total) AS total FROM `invoice` WHERE status = 1 AND YEAR(date_creation) = "2015" GROUP BY MONTH(date_creation)
        $due = DB::table('invoice')
                ->groupBy(DB::raw('YEAR(date_creation), MONTH(date_creation)'))
                ->whereRaw('date_creation BETWEEN "'.date('Y-m-d', strtotime(date('Y-m-d')." - 1 year")).'" AND "'.date('Y-m-d').'" AND status = 1')
                ->select(DB::raw('MONTH(date_creation) AS month, YEAR(date_creation) AS year, SUM(total) AS total '))
                ->get();
        //Set the due for the months
        foreach($due as $dueMonth){
          //Iterate over the $due array and get the equivalent month
          for($i=0; $i<count($months); $i++){
            //if month are the same, set the value, if not, keep it 0 due
            if($dueMonth->month == $months[$i]->month)
              $months[$i]->total = $dueMonth->total;
          }
        }
        return $months;
    }
    /*
     * Returns the invoice total renue for every month in the current year
     */
    public static function getMonthlyInvoiced()
    {
        //SELECT MONTH(date_creation) AS mes, SUM(total) AS total FROM `invoice` WHERE status = 1 AND YEAR(date_creation) = "2015" GROUP BY MONTH(date_creation)
        $due = DB::table('invoice')
                ->groupBy(DB::raw('YEAR(date_creation), MONTH(date_creation)'))
                ->whereRaw('date_creation BETWEEN "'.date('Y-m-d', strtotime(date('Y-m-d')." - 1 year")).'" AND "'.date('Y-m-d').'" ')
                ->select(DB::raw('MONTH(date_creation) AS month, YEAR(date_creation) AS year, SUM(total) AS total'))
                ->get();
        //return the array
        return $due;
    }
}
