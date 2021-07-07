<?php

namespace App\Http\Controllers;

use App\Models\TestResults;
use App\Models\Certificates;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class CertificatesController extends Controller
{
 	/**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function getCertificate(Request $request)
    {
    	$user_id = $request->input('user_id');
        $this->validate($request, [
            'user_id' => 'required'
        ]);
        
        $data = Certificates::with(['test','user'])->where(['student_user_id' => $user_id])->paginate(10);
    	
    	return $this->response("Student Certificates List",true,200,$data);
    }


}

?>