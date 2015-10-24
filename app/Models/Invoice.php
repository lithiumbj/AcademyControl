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
     * Returns the invoice DUE's for every month in the current year
     */
    public static function getMonthlyDue()
    {
        //SELECT MONTH(date_creation) AS mes, SUM(total) AS total FROM `invoice` WHERE status = 1 AND YEAR(date_creation) = "2015" GROUP BY MONTH(date_creation)
        $due = DB::table('invoice')
                ->groupBy(DB::raw('MONTH(date_creation)'))
                ->whereRaw('status = 1 AND YEAR(date_creation) = "'.date('Y').'"')
                ->select(DB::raw('MONTH(date_creation) AS mes, SUM(total) AS total'))
                ->get();
        //return the array
        return $due;
    }
    /*
     * Returns the invoice total renue for every month in the current year
     */
    public static function getMonthlyInvoiced()
    {
        //SELECT MONTH(date_creation) AS mes, SUM(total) AS total FROM `invoice` WHERE status = 1 AND YEAR(date_creation) = "2015" GROUP BY MONTH(date_creation)
        $due = DB::table('invoice')
                ->groupBy(DB::raw('MONTH(date_creation)'))
                ->whereRaw('YEAR(date_creation) = "'.date('Y').'"')
                ->select(DB::raw('MONTH(date_creation) AS mes, SUM(total) AS total'))
                ->get();
        //return the array
        return $due;
    }
}
