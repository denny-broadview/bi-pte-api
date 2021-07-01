<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function response($message,bool $data = false,int $responseCode = 401,$response = ""){
    	if(!empty($response)){
    		return response()->json(["data" => $data,"status_code" => $responseCode,"message" => $message,"response" => $response]);
    	}else{
    		return response()->json(["data" => $data,"status_code" => $responseCode,"message" => $message]);
    	}
    }

}
