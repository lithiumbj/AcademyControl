<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
