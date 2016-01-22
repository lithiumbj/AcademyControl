<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Client;
use App\Models\LMSFolder;
use App\Models\LMSFolderToClient;
use App\Models\LMSFile;
use App\Models\ServiceClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AngularHelper;
use Validator;
use DB;

class LMSController extends Controller {
    /*
     * Gets the LMS base view
     */

    public function showLMS() {
        return view('lms.root');
    }

    /*
     * Handles the get request to fetch via json, the folder content
     */

    public function ajaxFetch($path) {
        $data = [];
        if ($path != "null") {
            //Is a path
            $data['folders'] = LMSFolder::whereRaw('fk_parent = ' . $path)->get();
            $data['files'] = LMSFile::whereRaw('fk_parent = ' . $path)->get();
        } else {
            //Is root
            $data['folders'] = LMSFolder::whereRaw('fk_parent = 0')->get();
            $data['files'] = LMSFile::whereRaw('fk_parent = 0')->get();
        }
        //return the data
        print_r(json_encode($data));
    }

    /*
     * Creates a new folder (database LMSFolder entry)
     */

    public function ajaxCreateFolder(Request $request) {
        //Get the post data
        $data = $request->all();

        $folder = new LMSFolder;
        $folder->name = $data['name'];
        $folder->fk_parent = $data['path'];
        $folder->fk_user = \Auth::user()->id;
        $folder->fk_company = \Auth::user()->fk_company;
        //Fixed params for now
        $folder->can_see_others = 1;
        $folder->can_view_others = 1;
        $folder->can_write_others = 1;

        if ($folder->save())
            print_r('ok');
        else
            print_r('ko');
    }

    /*
     * This function catches the POST request and handles the file saving
     */

    public function ajaxUploadFile(Request $request) {
        $data = $request->all();
        //Create an empty LMSFile object
        $fileToSave = new LMSFile;
        $fileToSave->name = $data[0]->getClientOriginalName();
        $hash = time()*rand(0, 4);
        $fileToSave->path = "/";
        $fileToSave->hash = $hash;
        $fileToSave->type = $data[0]->getExtension();
        //Fk's
        $fileToSave->fk_parent = $data['parent'];
        $fileToSave->fk_user = \Auth::user()->id;
        $fileToSave->fk_company = \Auth::user()->fk_company;
        //Move the file
        $data[0]->move(storage_path().'/lms', $hash);
        //Save
        $fileToSave->save();
    }

}
