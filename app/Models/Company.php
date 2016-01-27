<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //Table definition
    protected $table = 'company';
    
    /*
     * get's the companies enabled
     */
    public static function fetchCompanies()
    {
        return Company::all();
    }

}

