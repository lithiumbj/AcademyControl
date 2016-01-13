<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class InvoiceProvider extends Model {

    //Table definition
    protected $table = 'invoice_provider';

    /*
     * Return's the 5 days lapsed invoices
     */

    public static function getInvoices($fk_provider) {
        $invoices = InvoiceProvider::whereRaw('fk_provider = ' . $fk_provider)->get();
        return $invoices;
    }

    /*
     * Return's the waste per month
     */

    public static function getMonthlyMoney() {
        //Get the invoiced monhts
        $months = DB::table('invoice')
                ->groupBy(DB::raw('YEAR(date_creation), MONTH(date_creation)'))
                ->whereRaw('date_creation BETWEEN "' . date('Y-m-d', strtotime(date('Y-m-d') . " - 1 year")) . '" AND "' . date('Y-m-d') . '"')
                ->select(DB::raw('MONTH(date_creation) AS month, YEAR(date_creation) AS year, \'0\' AS total'))
                ->get();

        $data = DB::table('invoice_provider')
                ->select(DB::raw("SUM(total + tax) AS total, MONTH(date_creation) AS month, YEAR(date_creation)"))
                ->whereRaw("fk_company = " . Auth::user()->fk_company . " AND date_creation BETWEEN '" . date('Y-m-d', strtotime(date('Y-m-d') . " - 1 year")) . "' AND '" . date('Y-m-d') . "' GROUP BY MONTH(date_creation)")
                ->get();
        //Set the due for the months
        foreach ($data as $dueMonth) {
            //Iterate over the $due array and get the equivalent month
            for ($i = 0; $i < count($months); $i++) {
                //if month are the same, set the value, if not, keep it 0 due
                if ($dueMonth->month == $months[$i]->month)
                    $months[$i]->total = $dueMonth->total;
            }
        }
        //Return the data
        return $months;
    }

}
