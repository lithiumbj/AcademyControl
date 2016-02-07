<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Chat;
use App\Models\AppChat;
use Mail;
use Illuminate\Http\Request;
use DB;

class ChatController extends Controller {
    /*
     * This function generates the list of the chats to other employees
     */

    public function getList() {
        //Get the employees of the same company 
        $users = User::where('fk_company', '=', \Auth::user()->fk_company)->get();
        return view('chat.list', ['users' => $users]);
    }

    /*
     * This function returns the messages to a user
     */

    public function getMessagesForUser(Request $request) {
        $data = $request->all();
        $messages = Chat::whereRaw('(fk_receiver = ' . \Auth::user()->id . ' AND fk_sender = ' . $request['fk_user'] . ') OR (fk_receiver = ' . $request['fk_user'] . ' AND fk_sender = ' . \Auth::user()->id . ')')->get();
        //Set my read messages as readed
        foreach ($messages as $message) {
            if ($message->fk_sender == $request['fk_user']) {
                $message->seen = 1;
                $message->save();
            }
        }
        print_r(json_encode(['messages' => $messages]));
    }

    /*
     * This function returns the messages to a user
     */

    public function getAppMessagesForUser(Request $request) {
        $data = $request->all();
        $messages = AppChat::whereRaw('(fk_receiver = ' . \Auth::user()->id . ' AND fk_sender = ' . $request['fk_user'] . ') OR (fk_receiver = ' . $request['fk_user'] . ' AND fk_sender = ' . \Auth::user()->id . ')')->get();
        //Set my read messages as readed
        foreach ($messages as $message) {
            if ($message->fk_sender == $request['fk_user']) {
                $message->seen = 1;
                $message->save();
            }
        }
        print_r(json_encode(['messages' => $messages]));
    }

    /*
     * This function catches the send message intent and sends a message to the 
     * selected user
     */

    public function sendMessage(Request $request) {
        $data = $request->all();
        $message = new Chat();
        $message->fk_sender = $data['fk_sender'];
        $message->fk_receiver = $data['fk_receiver'];
        $message->body = $data['message'];
        $message->seen = 0;
        if ($message->save())
            echo 'ok';
        else
            echo 'ko';
    }

    /*
     * The same as sendMessage but for the app
     */

    public function sendAppMessage(Request $request) {
        $data = $request->all();
        $message = new AppChat();
        $message->fk_sender = $data['fk_sender'];
        $message->fk_receiver = $data['fk_receiver'];
        $message->body = $data['message'];
        $message->seen = 0;
        if ($message->save())
            echo 'ok';
        else
            echo 'ko';
    }

    /*
     * This function returns the number of unred messages as the receiver
     */

    public function checkFeed() {
        echo Chat::whereRaw('fk_receiver = ' . \Auth::user()->id . ' AND seen = 0')->count();
    }

    /*
     * This function returns the number of unred messages as the receiver
     */

    public function checkAppFeed() {
        echo AppChat::whereRaw('fk_receiver = ' . \Auth::user()->id . ' AND seen = 0')->count();
    }

    /*
     * This function handles the sended message from the app
     */

    public function ajaxAppSendMessage(Request $request) {
        $data = $request->all();
        //send the message for all the users
        $chatApp = new AppChat;
        //$chatApp->fk_receiver = $user->id;
        $chatApp->fk_receiver = 1;
        $chatApp->fk_sender = $data['fk_sender'];
        $chatApp->body = $data['text'];
        //save
        $chatApp->save();
        //Send the message
        ChatController::sendAlertEmail();
        //response
        print_r('ok');
    }

    /*
     * Send's a new message incomming mail to the admin
     */

    public static function sendAlertEmail() {
        $dummy = [];
        Mail::send('emails.newMessage', [], function ($m) {
            $m->from('sat@inforfenix.com', 'Academy Control ERP - Inforfenix');

            $m->to("sat@inforfenix.com", "SAT - Inforfenix")->subject('Nuevo mensaje espera su contestación');
        });
    }

    /*
     * Gets the message list
     */

    public function ajaxAppGetMessages(Request $request) {
        $data = $request->all();
        $messages = AppChat::whereRaw('(fk_sender = ' . $data['fk_sender'] . ') OR (fk_receiver = ' . $data['fk_sender'] . ')')->distinct()->get();
        //Mark messages as readen
        foreach ($messages as $message) {
            $message->seen = 1;
            $message->save();
        }
        //return the messages
        print_r(json_encode($messages));
    }

    /*
     * This function render's a App-given messages
     */

    public function getAppList() {
        $users = DB::table('app_chat')
                ->groupBy(DB::raw('fk_sender'))
                ->whereRaw("fk_sender != " . \Auth::user()->id)
                ->select(DB::raw('DISTINCT fk_sender'))
                ->get();
        return view('chat.appList', ['users' => $users]);
    }

    /*
     * This function checks if the user have new messages to read
     */

    public function ajaxAppCheckMessages(Request $request) {
        $data = $request->all();
        $messages = AppChat::whereRaw('(fk_receiver = ' . $data['fk_sender'] . ') AND seen = 0')->distinct()->get();
        if (count($messages) > 0) {
            print_r('new');
        } else {
            print_r('no-new');
        }
    }

}
