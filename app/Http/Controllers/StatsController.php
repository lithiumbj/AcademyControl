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

class StatsController extends Controller
{
  /*
   * Renders a view with new clients stats
   */
  public function getNewClients()
  {
    $clients = DB::table('client')
                ->groupBy(DB::raw('MONTH(client.created_at)'))
                ->whereRaw('YEAR(client.created_at) = "'.date('Y').'"')
                ->select(DB::raw('count(id) AS count, MONTH(created_at) AS month'))
                ->get();
    return view('stats.newClients', ['data' => $clients]);
  }

  /*
   * Renders a view with new infos stats
   */
  public function getNewInfos()
  {

    return view('stats.newInfos');
  }
}
