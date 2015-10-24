<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\SMS;
use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class SMSController extends Controller {

    public static $sid = "AC113689b3ade38f49b712aa925d17dffd";
    public static $token = "d36d960a6b5b01908d6ce1f02354ee95";
    public static $limit = 10;

    /*
     * This function send's a sms to the clientphone
     */

    public static function sendAssistanceSms($phone, $clientName, $fk_client) {
        //First get how much sms have sended yet
        $sends = SMS::whereRaw('DATE(created_at) = "' . date('Y-m-d') . '"')->get();
        //If not sended up to the limit, continue
        if (count($sends) <= 10) {
            //Generate the log
            $smsLog = new SMS();
            $smsLog->client = $fk_client;
            $smsLog->save();
            //Start sms send
            $client = new \Services_Twilio("AC113689b3ade38f49b712aa925d17dffd", "d36d960a6b5b01908d6ce1f02354ee95");
            //Send the message
            $client->account->messages->create(array(
                'To' => $phone,
                'From' => "34986080671",
                'Body' => "El alumno " . $clientName . " ha faltado hoy (" . date('d-m-Y') . ") a clase de repaso en la academia Inforfenix",
            ));
            return true;
        } else {
            return false;
        }
    }

    /*
     * This function gets the post request to send a report SMS
     */

    public function sendReport(Request $request) {
        $data = $request->all();
        $client = Client::find($data['fk_client']);
        //Check if have phone
        if (strlen($client->phone_parents) > 8 && (substr($client->phone_parents, 0, 1) == 6 || (substr($client->phone_parents, 0, 1) == 7))) {
            //Start sms send
            $smsClient = new \Services_Twilio("AC113689b3ade38f49b712aa925d17dffd", "d36d960a6b5b01908d6ce1f02354ee95");
            //Send the message
            $smsClient->account->messages->create(array(
                'To' => $client->phone_parents,
                'From' => "34986080671",
                'Body' => $data['message'],
            ));
            echo 'ok';
        }else{
            echo 'badPhone';
        }
    }

}
