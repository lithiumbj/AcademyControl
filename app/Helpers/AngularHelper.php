<?php
namespace App\Helpers;

class AngularHelper{

	/**
	*	Parse the JSON object Angular sends to server side
	*/
	public static function parseClientSideData(){
		$postData = file_get_contents("php://input");
    $data = json_decode($postData);
    return $data;
	}
}
