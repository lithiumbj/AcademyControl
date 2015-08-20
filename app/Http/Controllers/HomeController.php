<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show's the home page
     */
    public function home()
    {
      return view('main.home');
    }
}
