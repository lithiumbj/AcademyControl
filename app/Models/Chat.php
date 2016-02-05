<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //Table definition
    protected $table = 'chat';
    
    public static function getMessageCountForUser($fk_receiver)
    {
        return Chat::whereRaw('fk_sender = '.$fk_receiver.' AND seen = 0')->count();
    }
    
}
