<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppChat extends Model
{
    //Table definition
    protected $table = 'app_chat';
    
    public static function getAppMessageCountForUser($fk_receiver)
    {
        return AppChat::whereRaw('fk_sender = '.$fk_receiver.' AND seen = 0')->count();
    }
}
