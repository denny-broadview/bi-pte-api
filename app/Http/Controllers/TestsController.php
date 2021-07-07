<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use App\Models\Tests;
use App\Models\UserAssignTests;
use App\Models\StudentTests;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class TestsController extends Controller
{
	public function getTest(Request $request)
    {
    	
    	$type = $request->input('type');
    	$user_id = $request->input('user_id');
    	
    	$this->validate($request, [
            'user_id' => 'required'
        ]);

    	if($type != ''){
			$data['tests'] = Tests::with('subject')->where('type',$type)->latest()->get();
		}else{
			$data['tests'] = Tests::with('subject')->latest()->get();
		}

		$alreadyAssign_practice = [];
		$alreadyAssign_mock = [];
		$userAssignTests = UserAssignTests::where('user_id',$user_id)->first();
		if($type == 'P'){
			if(isset($userAssignTests->practise_test_id) && !empty($userAssignTests->practise_test_id)){
	            $data['alreadyAssign_practice'] = explode(",",$userAssignTests->practise_test_id);
	        }
		}else if ($type == "M") {
	        if(isset($userAssignTests->mock_test_id) && !empty($userAssignTests->mock_test_id)){
	            $data['alreadyAssign_mock'] = explode(",",$userAssignTests->mock_test_id);
	        }
			
		}else{
			if(isset($userAssignTests->practise_test_id) && !empty($userAssignTests->practise_test_id)){
	            $data['alreadyAssign_practice'] = explode(",",$userAssignTests->practise_test_id);
	        }
	        
	        if(isset($userAssignTests->mock_test_id) && !empty($userAssignTests->mock_test_id)){
	            $data['alreadyAssign_mock'] = explode(",",$userAssignTests->mock_test_id);
	        }
	    }
		
		return $this->response("Test List",true,200,$data);
	}

	public function getCompletedPendingTest(Request $request){
		
		$type = $request->input('status'); //I,C
    	$user_id = $request->input('user_id');
    	
    	$this->validate($request, [
            'user_id' => 'required'
        ]);
    	// dd($user_id);
    	if($type != ''){
			$data = StudentTests::with(['test','user'])->where('user_id',$user_id)->where('status',$type)->get();
		}else{
			$data = StudentTests::with(['test','user'])->where('user_id',$user_id)->get();
		}

		
		return $this->response("Test List",true,200,$data);
	}


}