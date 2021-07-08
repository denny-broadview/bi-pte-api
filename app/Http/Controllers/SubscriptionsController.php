<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class SubscriptionsController extends Controller
{

	 public function getSubscription()
    {
    	$data = Subscriptions::where("status","E")->latest()->get();
    	return $this->response("Subscription List",true,200,$data);
    }


}
?>