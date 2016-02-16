<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Client;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/login');

    }
    
    public function appLogin()
    {
        //Find the client
        $client = Client::whereRaw('parent_nif = "'.$_GET['nif'].'" AND phone_parents = '.$_GET['phone'])->first();
        if($client){
            //Update and save the cipher
            $ciph = $_GET['uuid'];
            $rawDate = explode("-", date('Y-m-d'));
            $currDate = intval($rawDate[0].$rawDate[1].$rawDate[2]);
            $key = $ciph/$currDate;
            $client->auth = $key;
            $client->save();
            echo $client->id;
        }else{
            echo 'notFound';
        }
    }
}
