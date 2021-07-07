<?php

namespace App\Http\Controllers;

use App\Models\PredictionFiles;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class PredictionFilesController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function getPrediction(Request $request)
    {
        $section_id = $request->input('section_id');
        $design_id = $request->input('design_id');
        $user_id = $request->input('user_id');
        
        $this->validate($request, [
            'user_id' => 'required'
        ]);
        
        if($design_id !='' && $section_id != ''){
            $data = PredictionFiles::latest()->where("user_id",$user_id)->where("section_id",$section_id)->where("design_id",$design_id)->paginate(10);
        }else if($section_id != ''){
            $data = PredictionFiles::latest()->where("user_id",$user_id)->where("section_id",$section_id)->paginate(10);
        }else{
    	   $data = PredictionFiles::latest()->where("user_id",$user_id)->paginate(10);
        }
    	
    	return $this->response("PredictionFiles List",true,200,$data);
    }

    
}

?>