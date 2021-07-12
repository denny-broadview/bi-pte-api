<?php
namespace App\Http\Controllers;use App\Http\Controllers\Controller;use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Institues;
use App\Models\Api_auth;
use App\Models\Certificates;
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
				return $this->response("Login Successfully",true,200,$data);
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
    
}?>