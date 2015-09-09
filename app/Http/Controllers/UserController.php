<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use Hash;
use Validator;

class UserController extends Controller {
    /*
     * This function render's the create form for the employee
     */

    public function getCreate() {
        return view('user.create');
    }

    /*
     * This function get's the post request and creates the new user into db
     */

    public function postCreate(Request $request) {
        //Get the data
        $data = $request->all();
        //Filter the data to check if any is wrong
        $validator = Validator::make($data, [
                    'name' => 'required|max:254',
                    'password' => 'required|max:254',
                    'address' => 'required|max:254',
                    'nif' => 'required|max:254',
                    'nomina' => 'required|max:254',
        ]);
        //Check if validator fails
        if (!$validator->fails()) {
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->fk_company = 1;
            $user->fk_role = $data['fk_role'];
            $user->address = $data['address'];
            $user->cp = $data['cp'];
            $user->poblation = $data['poblation'];
            $user->nif = $data['nif'];
            $user->nomina = $data['nomina'];

            //Save the client
            if ($user->save()) {
                //Ok, go to view
                return redirect('user/view/' . $user->id);
            } else {
                //ko, return to form
                return redirect('user/create')
                                ->withErrors($validator)
                                ->withInput();
            }
        } else {
            //Innitial validation KO, redirect to form
            return redirect('user/create')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /*
     * This function get's the post request and updates the user
     */

    public function postUpdate(Request $request) {
        //Get the data
        $data = $request->all();
        //Filter the data to check if any is wrong
        $validator = Validator::make($data, [
                    'name' => 'required|max:254',
                    'address' => 'required|max:254',
                    'nif' => 'required|max:254',
                    'nomina' => 'required|max:254',
        ]);
        //Check if validator fails
        if (!$validator->fails()) {
            $user = User::find($data['id']);
            $user->name = $data['name'];
            $user->email = $data['email'];
            //Only change password if put on the field
            if (strlen($data['password']) > 0)
                $user->password = Hash::make($data['password']);
            $user->fk_company = 1;
            $user->fk_role = $data['fk_role'];
            $user->address = $data['address'];
            $user->cp = $data['cp'];
            $user->poblation = $data['poblation'];
            $user->nif = $data['nif'];
            $user->nomina = $data['nomina'];

            //Save the client
            if ($user->save()) {
                //Ok, go to view
                return redirect('user/view/' . $user->id);
            } else {
                //ko, return to form
                return redirect('user/create')
                                ->withErrors($validator)
                                ->withInput();
            }
        } else {
            //Innitial validation KO, redirect to form
            return redirect('user/create')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /*
     * This function render's the view form for the user
     */

    public function getView($id) {
        //Load user
        $user = User::find($id);
        return view('user.view', ['user' => $user]);
    }

    /*
     * This function render's the list
     */

    public function getList() {
        $users = User::all();
        return view('user.list', ['users' => $users]);
    }

}
