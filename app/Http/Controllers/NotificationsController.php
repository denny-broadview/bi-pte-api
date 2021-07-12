<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class NotificationsController extends Controller
{

	public function getNotifications(Request $request){
		$student_id = $request->input('student_id');

        $this->validate($request, [
            'student_id' => 'required'
        ]);

		$data = Notifications::with(['senderDetails'])->where('user_id',$student_id)->latest()->get();
		
		return $this->response("Student Notification",true,200,$data);
	}

} ?>