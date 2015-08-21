<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Show's the home page
     */
    public function getCreate()
    {
      return view('client.create');
    }
}
