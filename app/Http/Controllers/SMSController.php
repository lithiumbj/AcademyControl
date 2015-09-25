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

    public $sid = "AC113689b3ade38f49b712aa925d17dffd";
    public $token = "d36d960a6b5b01908d6ce1f02354ee95";
    public $limit = 20;

    /*
     * This function send's a sms to the clientphone
     */

    public static function sendAssistanceSms($phone, $clientName) {
        var_dump($phone, $clientName);die;
        //First get how much sms have sended yet
        $sends = SMS::whereRaw('DATE(created_at) = "' . date('Y-m-d') . '"')->count();
        //If not sended up to the limit, continue
        if ($sends < self::limit) {
            $client = new Services_Twilio(self::account_sid, self::auth_token);
            //Send the message
            $client->account->messages->create(array(
                'To' => "637107315",
                'From' => "637107315",
                'Body' => "preuba",
            ));
            if ($client->id != null) {
                return true;
            }
        } else {
            return false;
        }
    }

}
