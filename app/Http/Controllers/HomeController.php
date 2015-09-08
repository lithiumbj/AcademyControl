<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

use Auth;

class HomeController extends Controller
{
    /**
     * Show's the home page
     */
    public function home()
    {
      if(Auth::user()->fk_role == 4)
        //Is a professor
        return view('main.professor');
      else
        //Is a normal user
        return view('main.home');
    }
    public function teacher()
    {
      return view('main.professor');
    }
}
