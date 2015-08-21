<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Service;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
class ServicesController extends Controller
{
    /**
     * Show's the service's list
     */
    public function getList()
    {
      $services = Service::where('fk_company', '=', Auth::user()->fk_user)->get();
      return view('services.list',['services' => $services]);
    }
}
