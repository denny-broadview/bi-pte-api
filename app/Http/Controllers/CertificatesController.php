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
        $new_data = [];
        foreach ($data as $row) {

           array_push($new_data, array(
                "id" => $row->id,
                "student_user_id" => $row->student_user_id,
                "test_id" => $row->test_id ,
                "generate_by_user_id" => $row->generate_by_user_id ,
                "file_path" => $row->file_path ,
                "score" => $row->score ,
                "speaking" => $row->speaking ,
                "listening" => $row->listening ,
                "reading" => $row->reading ,
                "writing" => $row->writing ,
                "grammar" => $row->grammar ,
                "pronunciation" => $row->pronunciation ,
                "vocabulary" => $row->vocabulary ,
                "oral_fluency" => $row->oral_fluency ,
                "spelling" => $row->spelling ,
                "written_discourse" => $row->written_discourse ,
                "created_at" => $row->created_at ,
                "updated_at" => $row->updated_at ,
                "url" => env('WEB_URL')."/certificate/download/".$row->id,
           ));
        }
        return $this->response("Student Certificates List",true,200,$new_data);
    }


}

?>