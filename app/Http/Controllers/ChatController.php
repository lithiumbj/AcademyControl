<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
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
        $messages = Chat::whereRaw('fk_receiver = ' . $request['fk_user'] . ' OR fk_sender = ' . $request['fk_user'])->get();
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
     * This function returns the number of unred messages as the receiver
     */
    public function checkFeed()
    {
        echo Chat::whereRaw('fk_receiver = '.\Auth::user()->id.' AND seen = 0')->count();
    }
}
