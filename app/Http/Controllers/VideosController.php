<?php

namespace App\Http\Controllers;

use App\Models\Videos;

class VideosController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
    	$data = Videos::latest()->get();
    	// dd($data);
    	return $this->response("Video List",true,200,$data);
    }


}

?>