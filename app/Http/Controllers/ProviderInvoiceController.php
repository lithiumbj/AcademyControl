<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Provider;
use App\Models\InvoiceProvider;
use App\Models\InvoiceProviderLine;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CashflowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use App\Helpers\SettingsHelper;
use DB;
use View;
use Validator;

class ProviderInvoiceController extends Controller {
    /*
     * This function show's the create invoice form
     */

    public function getCreateInvoice($fk_client) {
        $provider = Provider::find($fk_client);
        //Render view
        return view('providerInvoice.new', ['provider' => $provider]);
    }

    /*
     * Get's the ajax request to create a new invoice
     */

    public function ajaxCreateInvoice() {
        $request = AngularHelper::parseClientSideData();
        if ($request) {
            $finalId = ProviderInvoiceController::createDueInvoice(Auth::user()->id, $request->fk_provider, Auth::user()->fk_company, 1, $request->note, $request->note, $request->date, $request->lines);
            if ($finalId)
                print_r(json_encode(['status' => 'ok', 'id' => $finalId]));
            else
                print_r(json_encode(['status' => 'ko']));
        }else {
            print_r(json_encode(['status' => 'ko']));
        }
    }

    /*
     * Creates a due invoice, following the parametters
     *
     * @param {Integer} $fk_user - The user that are creating the invoice
     * @param {Integer} $fk_provider - The provider to link the invoice
     * @param {Integer} $fk_company - The company id to write the invoice
     * @param {Integer} $status - The status of the invocie (0 = draft, 1 = validated, 2 = Fully payed, 3 = dead)
     * @param {String} $text_public - The public text to show in the invoice receipt
     * @param {String} $text_private - The private text (hidden in the receipt)
     * @param {String} $date_creation - The creation date (MYSQL Format)
     * @param {InvoiceLine[]} $lines - An array with InvoiceLines (full-fields)
     *
     * @return {Boolean} True if ok, False if ko
     */

    public static function createDueInvoice($fk_user, $fk_provider, $fk_company, $status, $text_public, $text_private, $date_creation, $lines) {
        $invoice = new InvoiceProvider;
        //Set all parametters
        $invoice->facnumber = '';
        $invoice->fk_user = $fk_user;
        $invoice->fk_provider = $fk_provider;
        $invoice->fk_company = $fk_company;
        $invoice->status = $status;
        $invoice->text_public = $text_public;
        $invoice->text_private = $text_private;
        $invoice->date_creation = $date_creation;
        $tax = 0;
        $total = 0;
        //Save / Create the invoice
        if ($invoice->save()) {
            //Ok, so continue
            foreach ($lines as $line) {
                //Write a line
                $newLine = new InvoiceProviderLine;
                $newLine->fk_provider_invoice = $invoice->id;
                $newLine->prod_name = $line->prod_name;
                $newLine->prod_description = $line->prod_description;
                $newLine->tax_base = $line->tax_base;
                $newLine->tax = $line->tax;
                $total += $newLine->tax_base;
                $tax += ($newLine->tax_base * ($newLine->tax / 100));
                //Save it
                if (!$newLine->save()) {
                    return false;
                }
            }
            //Update the invoice
            $invoice->tax = $tax;
            $invoice->total = $total;
            $invoice->save();
        } else {
            return false;
        }
        return $invoice->id;
    }

    /*
     * Returns the view of the invoice
     */

    public function getView($invoiceId) {
        $invoice = InvoiceProvider::find($invoiceId);
        $client = Provider::find($invoice->fk_provider);
        $lines = InvoiceProviderLine::where('fk_provider_invoice', '=', $invoiceId)->get();
        //generate the view
        return view('providerInvoice.view', ['invoice' => $invoice, 'client' => $client, 'lines' => $lines]);
    }

    /*
     * Set's the invoice as payed
     */

    public function setPayedInvoice($invoiceId) {
        //Get the invoice
        $invoice = InvoiceProvider::find($invoiceId);
        //Update the status
        $invoice->status = 2;
        $invoice->save();
        //return to the invoice list
        return redirect('/provider_invoice/' . $invoice->id);
    }

    /*
     * This function set's the invoice to unpay
     */

    public function setUnpayedInvoice($invoiceId) {
        //Get the invoice
        $invoice = InvoiceProvider::find($invoiceId);
        //Update the status
        $invoice->status = 1;
        $invoice->save();
        //return to the invoice list
        return redirect('/provider_invoice/' . $invoiceId);
    }

    /*
     * Deletes the invoice
     */

    public static function getDelete($facid) {
        //Delete the lines
        $lines = InvoiceProviderLine::where('fk_provider_invoice', '=', $facid)->get();
        foreach ($lines as $line) {
            $line->delete();
        }
        //Delete the invoice
        $invoice = InvoiceProvider::find($facid);
        $invoice->delete();
        return redirect('/provider_invoice');
    }

    /*
     * This function renders the invoice / "recibos" list
     */

    public function getList() {
        $invoices = InvoiceProvider::where('fk_company', '=', Auth::user()->fk_company)->get();
        //Return the data
        return view('providerInvoice.list', ['invoices' => $invoices]);
    }

}
