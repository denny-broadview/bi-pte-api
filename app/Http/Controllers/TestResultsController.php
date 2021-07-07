<?php

namespace App\Http\Controllers;

use App\Models\TestResults;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class TestResultsController extends Controller
{
 	/**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function getTestResult(Request $request)
    {
    	$user_id = $request->input('user_id');
        $this->validate($request, [
            'user_id' => 'required'
        ]);

    	$data = TestResults::with(['test','subject','user'])->where("user_id",$user_id)->latest()->paginate(10);
    	return $this->response("Student Result List",true,200,$data);
    }

    public function getTestResultDetails(){
        $user_id = $request->input('user_id');
        $test_id = $request->input('test_id');
        $this->validate($request, [
            'user_id' => 'required',
            'test_id' => 'required'

        ]);
        $data = TestResults::with(['test','subject','user'])->where("user_id",$user_id)->latest()->paginate(10);
        return $this->response("Student Result List",true,200,$data);   
    }


}

?>