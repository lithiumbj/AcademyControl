<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
