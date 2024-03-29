<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\ContactWay;
use App\Models\Cashflow;
use App\Models\ServiceClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use Validator;
use DB;

class CashflowController extends Controller {
    /*
     * This function renders the cash flow resume
     */

    public function showCashFiltered(Request $request) {
        $data = $request->all();
        $cashflows = Cashflow::whereRaw('fk_company = ' . Auth::user()->fk_company . ' AND created_at BETWEEN "' . $data['date_cashflow'] . ' 00:00:00" AND "' . $data['date_cashflow'] . ' 23:59:59"')->get();
        return view('cashflow.view', ['cashflows' => $cashflows]);
    }

    /*
     * This function renders the cash flow resume
     */

    public function showCash() {
        $cashflows = Cashflow::whereRaw('fk_company = ' . Auth::user()->fk_company . ' AND created_at BETWEEN "' . date('Y-m-d') . ' 00:00:00" AND "' . date('Y-m-d') . ' 23:59:59"')->get();
        return view('cashflow.view', ['cashflows' => $cashflows]);
    }

    /*
     * Render's the open cashflow form
     */

    public function getOpen() {
        return view('cashflow.open');
    }

    /*
     * Renders the exit cashflow form
     */

    public function getExit() {
        return view('cashflow.exit');
    }

    /*
     * This function render's the close cash form
     */

    public function getClose() {
        $cashflows = Cashflow::whereRaw('fk_company = ' . Auth::user()->fk_company . ' AND created_at BETWEEN "' . date('Y-m-d') . ' 00:00:00" AND "' . date('Y-m-d') . ' 23:59:59"')->get();
        return view('cashflow.close', ['cashflows' => $cashflows]);
    }

    /*
     *  This function saves the cashflow open
     */

    public function postOpen(Request $request) {
        $cashflow = new Cashflow;
        $data = $request->all();
        //Set the values
        $cashflow->fk_company = Auth::user()->fk_company;
        $cashflow->fk_user = Auth::user()->id;
        $cashflow->concept = "Apertura de caja - " . date('d/m/Y');
        $cashflow->value = $data['value'];
        $cashflow->is_open = 1;
        $cashflow->is_closed = 0;
        $cashflow->save();
        //Save and return
        return redirect('/cashflow');
    }

    /*
     *  This function saves the cashflow exit
     */

    public function postExit(Request $request) {
        $cashflow = new Cashflow;
        $data = $request->all();
        //Set the values
        $cashflow->fk_company = Auth::user()->fk_company;
        $cashflow->fk_user = Auth::user()->id;
        $cashflow->concept = $data['concept'];
        $cashflow->value = $data['value'];
        $cashflow->is_open = 0;
        $cashflow->is_closed = 0;
        $cashflow->save();
        //Save and return
        return redirect('/cashflow');
    }

    /*
     * This function closes the cash
     */

    public function postClose(Request $request) {
        $cashflow = new Cashflow;
        $data = $request->all();
        //Set the values
        $cashflow->fk_company = Auth::user()->fk_company;
        $cashflow->fk_user = Auth::user()->id;
        $cashflow->concept = $data['concept'];
        $cashflow->value = $data['value'];
        $cashflow->is_open = 0;
        $cashflow->is_closed = 1;
        $cashflow->save();
        //Save and return
        return redirect('/cashflow');
    }

    /*
     * This function creates a positive movement in the cashflow diary
     *
     * @param {String} $concept
     * @param {Double} $value
     */

    public static function createInMovement($concept, $value) {
        $cashflow = new Cashflow;
        //Set the values
        $cashflow->fk_company = Auth::user()->fk_company;
        $cashflow->fk_user = Auth::user()->id;
        $cashflow->concept = $concept;
        $cashflow->value = $value;
        $cashflow->is_open = 0;
        $cashflow->is_closed = 0;
        $cashflow->save();
        //Return the id
        return $cashflow->id;
    }

    /*
     * Fetch's the arrastre for the cashflow
     */

    public static function getArrastre() {
        $amount = Cashflow::where('fk_company', '=', Auth::user()->fk_company)->sum('value');
        return $amount;
    }

}
