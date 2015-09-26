<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //Table definition
    protected $table = 'room';
    
    /*
     * Return's the room's
     */
    public static function getRooms()
    {
        return Room::where('fk_company','=', \Auth::user()->id)->get();
    }
}
