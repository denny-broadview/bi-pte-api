<?php
namespace App\Http\Controllers;use App\Http\Controllers\Controller;use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Institues;
use App\Models\Api_auth;
use App\Models\Certificates;
use App\Models\DeviceLogs;
use App\Models\UserSession;
use App\Models\Notifications;
use App\Models\RoleHasPermissions;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;use App\Mail\ForgetPasswordMail;use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
	public function login(Request $request){
	 	$UserId = $request->input('UserId');
        $password = Hash::make($request->input('password'));
        $this->validate($request, [
            'UserId' => 'required',
            'password' => 'required'
        ]);
        $data =  User::where('name', '=', $UserId)->first();

		if($data!=null){
			if(!empty($data) &&  $data->status == "A" && $data->role_id == 3){
				$authentication = Api_auth::where('user_id' , $data->id)->get();
				if(empty($authentication[0])){
					$token_string = hash("sha256", rand());  
					$authentication = Api_auth::updateOrCreate(['user_id' => $data->id],[
						'user_id' => $data->id,
						'token' => $token_string
					]); 
					$data->setAttribute('token', $token_string);
				}else{
					$data->setAttribute('token', $authentication[0]->token);
				}
					$loginrecord = UserSession::where("user_id",$data->id)->first();
	                if($loginrecord){
	                    $sessiondata = [
	                        "status" =>"A"
	                    ];
	                    UserSession::where("user_id",$data->id)->update($sessiondata);
	                }else{
	                    $sessiondata = [
	                        "role_id" =>$data->role_id,
	                        "user_id" =>$data->id,
	                        "status" =>"A"
	                    ];
	                    UserSession::create($sessiondata);
	                }
	                $browser  = $this->getBrowserInfo();
	                $devicelog = DeviceLogs::where("user_id",$data->id)->where("browser_name",$browser['browser'])
	                				->where("device_name",$browser['device'])->first();
                
                	$devicelogCount = ($devicelog != '') ? $devicelog->count() : 0;
					if($devicelogCount == 0)
					{
						$device                 = new DeviceLogs;
		                $device->user_id        = $data->id;
		                $device->user_agent     =  $browser['user_agent'];
		                $device->browser_name   = $browser['browser'];
		                $device->device_name    = $browser['device'];
		                $device->ip_address     = $this->getUserIP();
		                $device->login_time     = date('Y-m-d H:i:s');
		                $device->status         = 'N';
		                $device->save();

		                return $this->response("Login Successfully",true,200,$data);
					}
					else
					{
						if($devicelog->status == 'Y')
						{
							return $this->response("Your device not allow for login!");
						}
						else
						{
							return $this->response("Login Successfully",true,200,$data);
						}
					}
			 }else if(!empty($data) &&  $data->status == "R"){
				return $this->response("Your account rejected.");
			}else if(!empty($data) &&  $data->status == "P"){
				return $this->response("Your account not active.");
			}else if(!empty($data) &&  $data->role_id == 2 || $data->role_id == 1){
				 return $this->response("Your account is not authonticate.");
			}else{
				return $this->response("UserId or Password wrong");
			}
		}else{
			return $this->response("UserId or Password wrong");
		}
    }	

	public function signup(Request $request){
			
    	$this->validate($request, [
			'username' => 'required',
			'email' => 'required',
			'password' => 'required',
			'mobile_no' => 'required',
			'institute_name' => 'required',					
	    ]);			
		$user = User::create(['role_id'=>2,'parent_user_id'=>0,'name'=>$request->username,'email' => $request->email,'password'=>$request->password,'mobile_no'=>$request->mobile_no,'profile_image'=>'','ip_address'=>'','latitude'=>'','longitude'=>''])->id;		
		if (!empty($user)) {
				$institute = Institues::create(['user_id'=>$user,'sub_domain'=>'','domain'=>'','students_allowed'=>'0','welcome_message'=>'','country_phone_code'=>'','phone_number'=>'','mobile_no'=>$request->mobile_no,'institute_name'=>$request->institute_name]);
				return $this->response("Signup successfully");
		}else{
			return $this->response("Sorry, Signup faild..!", 200, false);
		}
    }
		
	public function forgetPassword(Request $request){    		
		$this->validate($request, ['email' => 'required']);			
		$user = User::where(['email' => $request->email])->first();
		if (!empty($user)) {
			$this->configSMTP();
			$verification_token = substr( str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 20 );
			$authentication = User::updateOrCreate(['email' => $request->email],['token' => $verification_token]);
			$data = [
			'name'=>$user->first_name.' '.$user->last_name,
			'verification_token'=>$verification_token,
			'email'=>$request->email,
			'app_url'=>env('APP_URL')
			];
			try{
				Mail::to($request->email)->send(new ForgetPasswordMail($data));
			}catch(\Exception $e){
				$msg = $e->getMessage();
				return $this->response($msg,200,false);
			}
			return $this->response("Email send successfully for forget password!");	
			}else{
				return $this->response("Email address not valid..!");
			}
	}
	
	public function verifyOtp(Request $request){
			
			$this->validate($request, [
				'email' => 'required',
				'otp' => 'required'
			]);
	    	
			$otp = User::where(['email' => $request->email,'token'=>$request->otp])->first();		
			if (!empty($otp)) {
				return $this->response("OTP verify successfully");
			}else{
				return $this->response("Sorry, Invalid OTP..!", 200, false);
			}
			
    }

    public function resetPassword(Request $request){
			
		$this->validate($request, [
				'email' => 'required',
				'newpassword' => 'required',
				'confirmpassword' => 'required'
      	]);
    	
    	
		if($request->newpassword==$request->confirmpassword){
			User::where('email',$request->email)->update(['password'=>md5($request->newpassword),'token'=>'']);
			return $this->response("Password update successfully");
		}else{
			return $this->response("Sorry, Password mismatch..!", 200, false);
		}
    }
    
    public function profileUpdate(Request $request)
    {
    	$this->validate($request, [
    		'user_id'=> 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'date_of_birth'=> 'required|before:18 years ago',
            'mobile_no'=>'required',
            'gender'=>'required|in:M,F,O',
            'country_citizen'=>'required',
            'country_residence'=>'required',
            'state'=>'required',
            'state_code'=>'required',
            'city'=>'required'
        ]);

    	$input = $request->all();
    	if(User::where('name',$input['username'])->where('id','!=',$input['user_id'])->exists())
    	{
    		return $this->response("username already exist!", 200, false);
    	}
    	if(User::where('email',$input['email'])->where('id','!=',$input['user_id'])->exists())
    	{
    		return $this->response("email already exist!", 200, false);
    	}

    	unset($input['user_id']);
    	unset($input['username']);

    	$input['name'] = $request->username;

    	$result = User::where('id',$request->user_id)->update($input);

    	if($result)
    	{
    		$data = User::find($request->user_id);
    		$mainUser = User::select('id')->where('role_id','1')->first();
    		$notification_data1= array(
                    'user_id' => $mainUser->id,
                    'sender_id' => $request->user_id,
                    'type' => "Super Admin",//$this->getRoleName($mainUser->id),
                    'title' => "Student Profile updated",
                    'body' => $input['first_name']." ".$input['last_name']." student update his profile from mobile app.",
                    'url' => ""
                );
    		$notification_data2 = array(
                    'user_id' => $data->parent_user_id,
                    'sender_id' => $request->user_id,
                    'type' => "Branch Admin",//$this->getRoleName($mainUser->parent_user_id),
                    'title' => "Student Profile updated",
                    'body' => $input['first_name']." ".$input['last_name']." student update his profile from mobile app.",
                    'url' => ""
                );
                $notification1 = Notifications::create($notification_data1);
                $notification2 = Notifications::create($notification_data2);
    		
    		return $this->response("Profile Updated!",true,200,$data);
    	}
    	else
    	{
    		return $this->response("Profile not update!try again.", 200, false);
    	}
    }

    public function getStates()
    {
    	$data = $this->states();

    	return $this->response("states list",true,200,$data);
    }

    public function getModule(Request $request){
    	$this->validate($request, [
				'role_id' => 'required'
      	]);

    	$slug_data  = RoleHasPermissions::with(['module'])->where('role_id', $request->role_id)->get();
    	if($slug_data){
    		return $this->response("module list",true,200,$slug_data);
		}else{
			return $this->response("Sorry, no premission", 200, false);
		}
    }

    public function logout(Request $request){
    	$this->validate($request, [
				'user_id' => 'required'
      	]);
      	$sessiondata = [
            "status" =>"D"
        ];
    	$res = UserSession::where("user_id",$request->user_id)->update($sessiondata);
    	if($res){
    		return $this->response("Now logout to user");
		}else{
			return $this->response("Sorry, something was wrong", 200, false);
		}
    }

}?>