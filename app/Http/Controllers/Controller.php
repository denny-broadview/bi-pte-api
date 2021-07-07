<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

	public $assets_image_path = "http://pte.bi-team.in/assets/images/";
	//same check testsmodel 

    public function response($message,bool $data = false,int $responseCode = 401,$response = ""){
    	if(!empty($response)){
    		return response()->json(["data" => $data,"status_code" => $responseCode,"message" => $message,"response" => $response]);
    	}else{
    		return response()->json(["data" => $data,"status_code" => $responseCode,"message" => $message]);
    	}
    }
	
	public function configSMTP()
    {
        config([
            'mail.driver' => 'smtp',
            'mail.host' => 'smtp.gmail.com',
            'mail.port' => 587,
            'mail.from' => ['address' => "rasmita.gangani@gmail.com", 'name' =>"PTE"],
            'mail.encryption' => "tls",
            'mail.username' =>  "rasmita.gangani@gmail.com",
            'mail.password' => "grbubgleqhewhtsn",
        ]);
    }

}
