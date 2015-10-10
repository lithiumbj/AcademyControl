<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\SMS;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class SMSController extends Controller {

    public static $sid = "PN1438223ace347a99ddec8b0780f78f94";
    public static $token = "d36d960a6b5b01908d6ce1f02354ee95";
    public static $limit = 10;

    /*
     * This function send's a sms to the clientphone
     */

    public static function sendAssistanceSms($phone, $clientName, $fk_client) {
        //First get how much sms have sended yet
        $sends = SMS::whereRaw('DATE(created_at) = "' . date('Y-m-d') . '"')->count();
        //If not sended up to the limit, continue
        if ($sends < 10) {
            //Generate the log
            $smsLog = new SMS();
            $smsLog->client = $fk_client;
            $smsLog->save();
            //Start sms send
            $client = new \Services_Twilio("PN1438223ace347a99ddec8b0780f78f94", "d36d960a6b5b01908d6ce1f02354ee95");
            //Send the message
            $client->account->messages->create(array(
                'To' => $phone,
                'From' => "34986080671",
                'Body' => "El alumno " . $clientName . " ha faltado hoy (" . date('d-m-Y') . ") a clase de repaso en la academia Inforfenix",
            ));
            if ($client->id != null) {
                return true;
            }
        } else {
            return false;
        }
    }

}
