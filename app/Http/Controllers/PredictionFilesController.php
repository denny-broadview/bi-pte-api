<?php

namespace App\Http\Controllers;

use App\Models\PredictionFiles;

use App\Models\User;
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
        //first check student can show branch admin Prediction files or not 
        $show_video = User::with(['studentDetails'])->where("id",$user_id)->first();
        // if($show_video->studentDetails->show_admin_files == "Y"){
            $branch_admin_id = $show_video->parent_user_id;

            //second check student can show super admin videos or not 
            $branch_show_video = User::with(['institue'])->where("id",$branch_admin_id)->first();
            $superadmin = User::where("role_id",1)->first();
            $superadmin_id = $superadmin->id;
            
            if($branch_show_video->institue->show_admin_files == "Y"){
                //1 is superadmin user_id
                if($design_id !='' && $section_id != ''){
                    $data = PredictionFiles::latest()->where("user_id",$branch_admin_id)->orWhere("user_id",$superadmin_id)->where("section_id",$section_id)->where("design_id",$design_id)->paginate(10);
                }else if($section_id != ''){
                    $data = PredictionFiles::latest()->where("user_id",$branch_admin_id)->orWhere("user_id",$superadmin_id)->where("section_id",$section_id)->paginate(10);
                }else{
            	   $data = PredictionFiles::latest()->where("user_id",$branch_admin_id)->orWhere("user_id",$superadmin_id)->paginate(10);
                }
            }else{
                if($design_id !='' && $section_id != ''){
                    $data = PredictionFiles::latest()->where("user_id",$branch_admin_id)->where("section_id",$section_id)->where("design_id",$design_id)->paginate(10);
                }else if($section_id != ''){
                    $data = PredictionFiles::latest()->where("user_id",$branch_admin_id)->where("section_id",$section_id)->paginate(10);
                }else{
                   $data = PredictionFiles::latest()->where("user_id",$branch_admin_id)->paginate(10);
                } 
            }
        // }else{
        //     return $this->response("You have not permission to show video",true,200,$data);
        // }
    	
    	return $this->response("PredictionFiles List",true,200,$data);
    }

    
}

?>