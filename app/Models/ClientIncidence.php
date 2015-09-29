<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientIncidence extends Model
{
    //Table definition
    protected $table = 'client_incidence';

    public static function getIncidencesCount()
    {
        return ClientIncidence::whereRaw('fk_company = '.\Auth::user()->fk_company.' AND seen IS NULL')->count();
    }
}
