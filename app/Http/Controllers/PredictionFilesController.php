<?php

namespace App\Http\Controllers;

use App\Models\PredictionFiles;

class PredictionFilesController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
    	$data = PredictionFiles::latest()->get();
    	// dd($data);
    	return $this->response("PredictionFiles List",true,200,$data);
    }

    
}

?>