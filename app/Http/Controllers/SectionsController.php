<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use App\Models\Questions;
use App\Models\QuestionDesigns;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class SectionsController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function getSection()
    {
    	$data = Sections::latest()->get();
    	$response =array();
    	foreach ($data as $row) {
    		$question_count = Questions::where('section_id',$row->id)->count('id');
    		
    		array_push($response, 
    			array(
					"id" => $row->id,
					"section_name" => $row->section_name,
                    "image" => $this->assets_image_path."section-icon/".$row->image,
					"question_count" => $question_count,
				)
    		);
    	}
    	
    	return $this->response("Section List",true,200,$response);
    }

    public function sectionWiseDesign(Request $request)
    {
        $section_id = $request->input('section_id');

        $this->validate($request, [
            'section_id' => 'required'
        ]);

        $data = QuestionDesigns::latest()->where("section_id",$section_id)->get();

        
        
        return $this->response("Section wise design List",true,200,$data);
    }

}

?>