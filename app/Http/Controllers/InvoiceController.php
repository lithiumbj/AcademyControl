<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\InvoiceLine;
use App\Models\Client;
use App\Models\ServiceClient;
use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CashflowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use App\Helpers\SettingsHelper;
use DB;
use View;
use Validator;

class InvoiceController extends Controller {
    /*
     * This function generates a matricula invoice for a client
     */

    public static function createMatriculaInvoice($fk_client, $fk_service) {
        //First get the service details
        $service = Service::where('id', '=', $fk_service)->first();
        //Second create the line
        $newLine = new InvoiceLine;
        $newLine->fk_service = $service->id;
        $newLine->prod_name = $service->name . ' Reserva de plaza / Matricula';
        $newLine->prod_description = $service->description;
        $newLine->tax_base = $service->matricula;
        $newLine->tax = $service->iva;
        //Set into an array
        $lines = [$newLine];
        //Create the invoice
        return InvoiceController::createDueInvoice(InvoiceController::generateFacNumber(), Auth::user()->id, $fk_client, Auth::user()->fk_company, 1, '', '', date('Y-m-d'), $lines);
    }

    /*
     * Get's the ajax request to create a new invoice
     */

    public function ajaxCreateInvoice() {
        $request = AngularHelper::parseClientSideData();
        if ($request) {
            $finalId = InvoiceController::createDueInvoice(InvoiceController::generateFacNumber(), Auth::user()->id, $request->fk_client, Auth::user()->fk_company, 1, $request->note, $request->note, $request->date, $request->lines);
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
     * @param {String} $facnumber - The invoice number
     * @param {Integer} $fk_user - The user that are creating the invoice
     * @param {Integer} $fk_client - The client to link the invoice
     * @param {Integer} $fk_company - The company id to write the invoice
     * @param {Integer} $status - The status of the invocie (0 = draft, 1 = validated, 2 = Fully payed, 3 = dead)
     * @param {String} $text_public - The public text to show in the invoice receipt
     * @param {String} $text_private - The private text (hidden in the receipt)
     * @param {String} $date_creation - The creation date (MYSQL Format)
     * @param {InvoiceLine[]} $lines - An array with InvoiceLines (full-fields)
     *
     * @return {Boolean} True if ok, False if ko
     */

    public static function createDueInvoice($facnumber, $fk_user, $fk_client, $fk_company, $status, $text_public, $text_private, $date_creation, $lines) {
        $invoice = new Invoice;
        //Set all parametters
        $invoice->facnumber = $facnumber;
        $invoice->fk_user = $fk_user;
        $invoice->fk_client = $fk_client;
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
                $newLine = new InvoiceLine;
                $newLine->fk_invoice = $invoice->id;
                $newLine->fk_service = $line->fk_service;
                $newLine->prod_name = $line->prod_name;
                $newLine->prod_description = $line->prod_description;
                $newLine->tax_base = $line->tax_base;
                $newLine->tax = $line->tax;
                $total += $newLine->tax_base;
                $tax += ($newLine->tax_base * $newLine->tax);
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
            //Revert the facnumber increment
            $currFacnumber = SettingsHelper::fetchSetting('facnumber');
            SettingsHelper::setSetting('facnumber', $currFacnumber - 1);
            return false;
        }
        return $invoice->id;
    }

    /*
     * Generates the next invoice number
     */

    public static function generateFacNumber() {
        $mask = SettingsHelper::fetchSetting('invoiceMask');
        //separate the static part from the dinamic
        $explodedMask = explode("#", $mask);
        //Get the constant
        $constant = $explodedMask[0];
        //Get digits of mask
        $digits = substr_count($mask, "#");
        //Get the current facnumber
        $currFacnumber = SettingsHelper::fetchSetting('facnumber');
        //Build the new facnumber
        //We get the limit (The maximun length of the mask)
        $limit = strlen($constant) + $digits;
        //How many # are?
        $zeros = $digits - strlen($currFacnumber);
        $newMask = '';
        for ($i = 0; $i < $zeros; $i++) {
            $newMask.='0';
        }
        $newMask = $constant . $newMask . $currFacnumber;
        //Set the new facnumber
        SettingsHelper::setSetting('facnumber', $currFacnumber + 1);
        //return the data
        return $newMask;
    }

    /*
     * This function renders the invoice / "recibos" list
     */

    public function getList() {
        $invoices = Invoice::where('fk_company', '=', Auth::user()->fk_company)->get();
        //Return the data
        return view('invoice.list', ['invoices' => $invoices]);
    }

    /*
     * Set's the invoice as payed
     */

    public function setPayedInvoice(Request $request) {
        $data = $request->all();
        //Get the invoice
        $invoice = Invoice::find($data['fk_invoice']);
        //create the payment
        $payment = new InvoicePayment;
        $payment->fk_user = Auth::user()->id;
        $payment->fk_company = Auth::user()->fk_company;
        $payment->fk_client = $invoice->fk_client;
        $payment->fk_invoice = $invoice->id;
        //Check if customer pays more than the invoice due
        if ($data['toPay'] > $invoice->total)
            $payment->total = $invoice->total;
        else
            $payment->total = $data['toPay'];
        //Continue with cashflow movement
        $payment->fk_cashflow = CashflowController::createInMovement('Pago de recibo de ' . Client::getClientName($payment->fk_client), $payment->total);
        //Create the payment
        $payment->save();
        //Check if the payments cover all the money of the invoice
        $paymentsTotal = 0;
        foreach (InvoicePayment::where('fk_invoice', '=', $invoice->id)->get() as $payment) {
            $paymentsTotal += $payment->total;
        }
        //If enought money, payed
        if ($paymentsTotal >= $invoice->total) {
            //Update the status
            $invoice->status = 2;
            $invoice->save();
        }
        //return to the invoice list
        return redirect('/invoice/' . $invoice->id);
    }

    /*
     * This function set's the invoice to unpay
     */

    public function setUnpayedInvoice($invoiceId) {
        //Get the invoice
        $invoice = Invoice::find($invoiceId);
        //Update the status
        $invoice->status = 1;
        $invoice->save();
        //Delete the payments
        $payment = InvoicePayment::where('fk_invoice', '=', $invoice->id);
        //Create the payment
        $payment->delete();
        //Generate a exit money cashflow
        $payment->fk_cashflow = CashflowController::createInMovement('Devolución de recibo de ' . Client::getClientName($invoice->fk_client), ($invoice->total * -1));
        //return to the invoice list
        return redirect('/invoice/'.$invoice->id);
    }

    /*
     * Returns the view of the invoice
     */

    public function getView($invoiceId) {
        $invoice = Invoice::find($invoiceId);
        $client = Client::find($invoice->fk_client);
        $payments = InvoicePayment::where('fk_invoice', '=', $invoiceId)->get();
        $lines = InvoiceLine::where('fk_invoice', '=', $invoiceId)->get();
        //generate the view
        return view('invoice.view', ['invoice' => $invoice, 'client' => $client, 'payments' => $payments, 'lines' => $lines]);
    }

    /*
     * This function print's the invoice
     */

    public function printInvoice($invoiceId) {
        $invoice = Invoice::find($invoiceId);
        $client = Client::find($invoice->fk_client);
        $payments = InvoicePayment::where('fk_invoice', '=', $invoiceId)->get();
        $lines = InvoiceLine::where('fk_invoice', '=', $invoiceId)->get();
        //generate the view
        return view('invoice.print', ['invoice' => $invoice, 'client' => $client, 'payments' => $payments, 'lines' => $lines]);
    }

    /*
     * This function render's the view of the auto-generated invoices
     */

    public function getGenerateAutoInvoices() {
        //Current month client invoices
        $currentMonthClientInvoices = DB::table('invoice')
                        ->join('client', 'client.id', '=', 'invoice.fk_client')
                        ->whereRaw("YEAR(invoice.date_creation) = " . date('Y') . " AND MONTH(invoice.date_creation) = " . date('m'))
                        ->select(DB::raw('client.*'))->get();
        return view('invoice.generate', ['clientsWithInvoices' => $currentMonthClientInvoices]);
    }

    /*
     * This function get's the post request and generates the invoices automatically
     */

    public function postGenerateAutoInvoices(Request $request) {
        $data = $request->all();
        //Check if the client exception array exists
        //Get the clients
        $clients;
        if (isset($data['client'])) {
            //Generate query without these clients
            $extraWhere = ' ';
            foreach ($data['client'] as $client) {
                $extraWhere .= ' AND id != ' . $client . ' ';
            }
            $clients = Client::whereRaw('fk_company = ' . Auth::user()->fk_company . $extraWhere)->get();
        } else {
            //Normal function
            $clients = Client::where('fk_company', '=', Auth::user()->fk_company)->get();
        }
        //After get the clients, get the services foreac
        foreach ($clients as $client) {
            //Get associated services
            $services = ServiceClient::whereRaw('fk_client = ' . $client->id . ' AND active = 1')->get();
            //For-each service generate the monthly due
            $lines = [];
            foreach ($services as $serviceClient) {
                //Get service details
                $service = Service::where('id', '=', $serviceClient->fk_service)->first();
                //Second create the line
                $newLine = new InvoiceLine;
                $newLine->fk_service = $service->id;
                $newLine->prod_name = $service->name;
                $newLine->prod_description = $service->description;
                $newLine->tax_base = $service->price;
                $newLine->tax = $service->iva;
                //Set into an array
                $lines[] = $newLine;
            }
            //Create the invoice
            InvoiceController::createDueInvoice(InvoiceController::generateFacNumber(), Auth::user()->id, $client->id, Auth::user()->fk_company, 1, $data['note_public'], '', date('Y-m-d'), $lines);
        }
        //Return to the invoice list
        return redirect('/invoice');
    }

    /*
     * This function generates a massive print for a time interval
     */

    public function postMassivePrint(Request $request) {
        $data = $request->all();
        //Get the invoices
        $invoices = Invoice::whereRaw('fk_company = ' . Auth::user()->fk_company . ' AND date_creation BETWEEN "' . date('Y-m-d', strtotime($data['date_start'])) . '" AND "' . date('Y-m-d', strtotime($data['date_end'])) . '"')->get();
        $rawData = [];
        foreach ($invoices as $invoice) {
            $client = Client::find($invoice->fk_client);
            $payments = InvoicePayment::where('fk_invoice', '=', $invoice->id)->get();
            $lines = InvoiceLine::where('fk_invoice', '=', $invoice->id)->get();
            //Update invoice with the new note public
            $invoice->text_public = $data['note_public'];
            $invoice->save();
            //generate the data to the view
            $rawData[] = ['invoice' => $invoice, 'client' => $client, 'payments' => $payments, 'lines' => $lines];
        }
        return view('invoice.massivePrint', ['rawData' => $rawData]);
    }

    /*
     * This function show's the create invoice form
     */

    public function getCreateInvoice($fk_client) {
        $client = Client::find($fk_client);
        $services = Service::where('fk_company', '=', Auth::user()->fk_company)->get();
        //Render view
        return view('invoice.new', ['client' => $client, 'services' => $services]);
    }

    /*
     * This function deletes an invoice
     */

    public function getDelete($facid) {
        //Delete the payments
        $payments = InvoicePayment::where('fk_invoice', '=', $facid)->get();
        foreach ($payments as $payment) {
            $payment->delete();
        }
        //Delete the lines
        $lines = InvoiceLine::where('fk_invoice', '=', $facid)->get();
        foreach ($lines as $line) {
            $line->delete();
        }
        //Delete the invoice
        $invoice = Invoice::find($facid);
        $invoice->delete();

        //return to the list
        return redirect('/invoice');
    }

    /*
     * Deletes the invoice
     */

    public static function deleteInvoice($facid) {
        //Delete the payments
        $payments = InvoicePayment::where('fk_invoice', '=', $facid)->get();
        foreach ($payments as $payment) {
            $payment->delete();
        }
        //Delete the lines
        $lines = InvoiceLine::where('fk_invoice', '=', $facid)->get();
        foreach ($lines as $line) {
            $line->delete();
        }
        //Delete the invoice
        $invoice = Invoice::find($facid);
        $invoice->delete();
    }

    /*
     * This function updates the public note of the invoice
     */

    public function updatePublicNote(Request $request) {
        $data = $request->all();
        //Load the invoice
        $invoice = Invoice::find($data['id']);
        $invoice->text_public = $data['txt'];
        $invoice->save();
        //Redirect
        return redirect('/invoice/' . $invoice->id);
    }

    /*
     * This function updates the private note of the invoice
     */

    public function updatePrivateNote(Request $request) {
        $data = $request->all();
        //Load the invoice
        $invoice = Invoice::find($data['id']);
        $invoice->text_private = $data['txt'];
        $invoice->save();
        //Redirect
        return redirect('/invoice/' . $invoice->id);
    }
    /*
     * This functiobn returns an array with the clients that not have a
     * invoice due in this month
     */
    public static function getUnDueClientsForMonth()
    {
      $noDueClients = [];
      //fetch all the clients (first)
      $clients = Client::where('status','=',1)->get();
      //for each client, get who not have a invoice for this month
      foreach($clients as $client){

        //Have a invoice for this month??
        $invoices = Invoice::whereRaw("MONTH(date_creation) = ".date("m")." AND YEAR(date_creation) = ".date("Y"). " AND fk_client = ".$client->id)->get();
        //check if have invoices
        if(count($invoices)==0){
          $noDueClients[] = $client;
        }
      }
      //Return the data
      return $noDueClients;
    }
}
