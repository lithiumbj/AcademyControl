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
                ->groupBy(DB::raw('YEAR(client.created_at), MONTH(client.created_at)'))
                ->whereRaw('client.status = 1')
                ->select(DB::raw('count(id) AS count, YEAR(created_at) AS year, MONTH(created_at) AS month'))
                ->get();
    return view('stats.newClients', ['data' => $clients]);
  }

  /*
   * Renders a view with new infos stats
   */
  public function getNewInfos()
  {
    $clients = DB::table('client')
                ->groupBy(DB::raw('YEAR(client.created_at), MONTH(client.created_at)'))
                ->whereRaw('client.status = 0 OR (client.status = 1 AND client.was_info = 1)')
                ->select(DB::raw('count(id) AS count, YEAR(created_at) AS year, MONTH(created_at) AS month'))
                ->get();
    return view('stats.newInfos', ['data' => $clients]);
  }

  /*
   * Renders a view with information to client conversion
   */
  public function getInfoToClientConversions()
  {
    $clients = DB::table('client')
                ->groupBy(DB::raw('YEAR(client.created_at), MONTH(client.created_at)'))
                ->whereRaw('client.status = 1 AND client.was_info = 1')
                ->select(DB::raw('count(id) AS count, YEAR(created_at) AS year, MONTH(created_at) AS month'))
                ->get();
    return view('stats.conversions', ['data' => $clients]);
  }

  /*
   * Renders a view with information refered to client to ex-client conversion
   */
  public function getClientToExclientConversions()
  {
    $clients = DB::table('client')
                ->groupBy(DB::raw('YEAR(client.date_cancelation), MONTH(client.date_cancelation)'))
                ->whereRaw('client.status = 2')
                ->select(DB::raw('count(id) AS count, YEAR(date_cancelation) AS year, MONTH(date_cancelation) AS month'))
                ->get();
    return view('stats.newExclients', ['data' => $clients]);
  }
}
