<?php

namespace App\Http\Controllers;

use App\Models\TestResults;
use App\Models\StudentTests;use App\Models\Tests;use App\Models\Questions;
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

    	$data = TestResults::with(['test','subject','user'])->where("status",'C')->where("user_id")->latest()->paginate(10);
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
	 public function getStudentResults(Request $request)    {    	$user_id = $request->input('user_id');		$type = $request->input('type');        $this->validate($request, [            'user_id' => 'required',			'type' => 'required'        ]);		if($type=='ALL'){			$getdata = StudentTests::with(['test'])->where("user_id",$user_id)->where("status",'C')->orderBy('id','desc')->get();			foreach ($getdata as $key => $row) {				$gdata=$row->test;				$question_count = Questions::with(['getsection'])->selectRaw('section_id,count(id) as total')->where('test_id',$gdata->id)->groupBy('section_id')->get();				$gdata->question_count=$question_count;				$getdata[$key]->test=$gdata;			}		}else{			$getdata = StudentTests::join('generate_tests', 'generate_tests.id', '=', 'student_tests.test_id')->where("generate_tests.type",$type)->where("student_tests.user_id",$user_id)->where("student_tests.status",'C')->orderBy('student_tests.id','desc')->get();			foreach ($getdata as $key => $row) {				$gdata=$row->test;				$question_count = Questions::with(['getsection'])->selectRaw('section_id,count(id) as total')->where('test_id',$gdata->id)->groupBy('section_id')->get();				$gdata->question_count=$question_count;				$getdata[$key]->test=$gdata;			}					}    	return $this->response("Result List",true,200,$getdata);    }

}

?>