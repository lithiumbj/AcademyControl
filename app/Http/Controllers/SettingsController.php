<?php

namespace App\Http\Controllers;

use App\User;
use App\Helpers\SettingsHelper;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class SettingsController extends Controller {
    
    /*
     * This function Creates a new company
     */
    public function ajaxCreateCompany(Request $request) {
        $data = $request->all();
        //Create a new company
        $company = new Company;
        $company->name = $data['name'];
        $company->description = $data['description'];
        $company->cif = $data['cif'];
        //Save and get the id
        $company->save();
        //Create basic settings for the new company
        SettingsHelper::setSettingForeignCompany('facnumber','1',$company->id);
        SettingsHelper::setSettingForeignCompany('invoiceMask','RECIBO-####',$company->id);
        //Process ended
        print_r('ok');
    }
}
