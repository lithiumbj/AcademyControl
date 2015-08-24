<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Client;
use App\Models\ServiceClient;
use App\Models\Service;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\AngularHelper;
use App\Helpers\SettingsHelper;

use Validator;

class InvoiceController extends Controller
{

  /*
   * This function generates a matricula invoice for a client
   */
  public static function createMatriculaInvoice($fk_client, $fk_service)
  {
    //First get the service details
    $service = Service::where('id', '=', $fk_service)->first();
    //Second create the line
    $newLine = new InvoiceLine;
    $newLine->fk_service = $service->id;
    $newLine->prod_name = $service->name;
    $newLine->prod_description = $service->description;
    $newLine->tax_base = $service->matricula;
    $newLine->tax = $service->iva;
    //Set into an array
    $lines = [$newLine];
    //Create the invoice
    return InvoiceController::createDueInvoice(InvoiceController::generateFacNumber(), Auth::user()->id, $fk_client, Auth::user()->fk_company, 1, '', '', date('Y-m-d'), $lines);
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
  public static function createDueInvoice($facnumber, $fk_user, $fk_client, $fk_company, $status, $text_public, $text_private, $date_creation, $lines)
  {
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
    //Save / Create the invoice
    if($invoice->save()){
      //Ok, so continue
      foreach($lines as $line){
        //Write a line
        $newLine = new InvoiceLine;
        $newLine->fk_invoice = $invoice->id;
        $newLine->fk_service = $line->fk_service;
        $newLine->prod_name = $line->prod_name;
        $newLine->prod_description = $line->prod_description;
        $newLine->tax_base = $line->tax_base;
        $newLine->tax = $line->tax;
        //Save it
        if(!$newLine->save()){
          return false;
        }
      }
    }else{
      //Revert the facnumber increment
      $currFacnumber = SettingsHelper::fetchSetting('facnumber');
      SettingsHelper::setSetting('facnumber', $currFacnumber-1);
      return false;
    }
    return true;
  }
  /*
   * Generates the next invoice number
   */
  public static function generateFacNumber()
  {
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
    $newFacnumber = $constant;
    //We get the limit (The maximun length of the mask)
    $limit = strlen($constant) + $digits;
    //We will walk for every character from the first # up to the first digit to set
    for($i = $limit - $digits; $i < $limit; $i++){
      //IF true concatenate a 0, if not, concatenate the digit
      if(($limit-$i) - strlen($currFacnumber)>0){
        $newFacnumber = $newFacnumber.'0';
      }else{
        $newFacnumber = $newFacnumber.$currFacnumber;
      }
    }
    //Set the new facnumber
    SettingsHelper::setSetting('facnumber', $currFacnumber+1);
    //return the data
    return $newFacnumber;
  }
}
