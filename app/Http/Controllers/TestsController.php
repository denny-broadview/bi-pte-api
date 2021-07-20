<?php



namespace App\Http\Controllers;


use App\Models\Sections;

use App\Models\Tests;

use App\Models\UserAssignTests;

use App\Models\StudentTests;

use App\Models\StudentsAnswerData;

use App\Models\Answerdata;

use App\Models\Questions;

use App\Models\SectionQuestionScores;

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

	public function getQuestions(Request $request){
    	$this->validate($request, [
			'test_id' => 'required',
		]);
		$test_id = $request->test_id;
		if (!empty($test_id)) {
			$data = Sections::with(['question' => function ($query) use ($test_id) {
				$query->where('test_id', $test_id);
			}])->get();
			if (!empty($data)) {
				return $this->response("Questions List",true,200,$data);
			} else {
				return $this->response("No data found", 200, false);
			}
		} else {
			return $this->response("test_id not found", 200, false);
		}
	}

	public function addStudentTestDetail(Request $request) {
		$this->validate($request, [
			'student_id' => 'required',
			'question_id' => 'required',
			'answer_type' => 'required',
			'time_taken' => 'required'
		]);

		$question = Questions::where('id',$request->question_id)->first();
		if (!empty($question)) {

			$answerData = Answerdata::where(['question_id' => $request->question_id, 'answer_type' => $request->answer_type])->first();
			$where = ['section_id' => $question->section_id, 'question_type_id' => $question->question_type_id];
			$sectionQuestionScores = SectionQuestionScores::where($where)->first();

			if (!empty($answerData) && !empty($sectionQuestionScores)) {
				$studentTest =  StudentTests::where(['user_id' => $request->student_id, 'test_id' => $question->test_id])->update(['status' => 'I']);
				$studentsAnswerData = StudentsAnswerData::where(['question_id' => $request->question_id, 'student_id' => $request->student_id ,'answer_type' => $request->answer_type])->first();
				$answer = [];
				if (!empty($request->textofaudio)) {
					$answer['audio_to_text'] = $request->textofaudio; 
				} else if (!empty($request->audiofile)) {
					$answer['answer_value'] = $request->audiofile;
				} else {
					$answer['answer_value'] = $request->answer;
				}

				echo "<pre>";
				print_r($studentsAnswerData);die;

				
				if (!empty($studentsAnswerData)) {
					$result = StudentsAnswerData::where(['question_id' => $request->question_id, 'student_id' => $request->student_id,'answer_type' => $request->answer_type])->update($answer);
				} else {
					$data = ['question_id' => $request->question_id, 'student_id' => $request->student_id, 'answer_type' => $request->answer_type];
					if (!empty($answer['answer_value'])) {
						$data['answer_value'] = $answer['answer_value'];
					}
					if (!empty($answer['audio_to_text'])) {
						$data['audio_to_text'] = $answer['answer_value'];
					} 
					$result = StudentsAnswerData::save($data);
				}

			} else {
				return $this->response("No data found", 200, false);	
			}


		} else {
			return $this->response("No data found", 200, false);
		}
 		

	}

}