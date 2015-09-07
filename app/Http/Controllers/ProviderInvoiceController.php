<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Provider;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CashflowController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\AngularHelper;
use App\Helpers\SettingsHelper;

use DB;
use View;
use Validator;

class ProviderInvoiceController extends Controller
{
   /*
    * This function show's the create invoice form
    */
   public function getCreateInvoice($fk_client)
   {
     $provider = Provider::find($fk_client);
     //Render view
     return view('providerInvoice.new', ['provider' => $provider]);
   }
}
