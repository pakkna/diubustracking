<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use App\Traits\ActivityTrait;
use App\Models\User;
use Validator;
use DB;

class ApiAuthController extends Controller
{
    use ActivityTrait;

    public function  __construct()
    {
        $this->middleware('auth:api', ['except' => ['registration', 'login_for_user', 'match_mobile_number', 'code_combination', 'cache_clear', 'LoginWithThirdPartyApi']]);
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function registration(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|string',
            'mobile' => 'required|regex:/(01)[0-9]{9}/|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|regex:/\w*$/|max:255|unique:users,username',
            'address' => 'required|string',
            'password' => 'required|min:7'
        ]);

        if ($validator->fails()) {

            $this->activity_log('Registration', 'Default Registration', implode(",", $validator->messages()->all()), 'Faild', $request->mobile);
            return $this->sendError(true, 'Validation Error.', $validator->messages()->all(), 406);
        } else {


            try {

                $user = User::create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'address' => $request->address,
                    'usertype' => "User",
                    'register_by' => "App"
                ]);


                if ($user->save()) {

                    $set_request = new Request([
                        'username' => $request->username,
                        'password' => $request->password
                    ]);

                    $this->activity_log('Registration', 'Default Registration', 'Registration Successfully', 'Done', $user->id);

                    return $this->login_for_user($set_request);
                } else {
                    return $this->success_error(true, 'Registration Faild!', '', 200);
                }


                return $this->ResponseJson(false, 'Registration Successful!', $user, 200);
            } catch (\Throwable $th) {
                $this->activity_log('Registration', 'Registration Insert Error', "Create User Error In Database", 'Faild', $request->mobile);
                return $this->sendError(true, 'Registration Insert Error', $th->getMessage(), 406);
            }
        }
    }

    public function LoginWithThirdPartyApi(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'registered_by' => 'required|string',
        ]);

        if ($validator->fails()) {

            //$this->activity_log('Registration', 'ThirdParty Registration', implode(",", $validator->messages()->all()), 'Faild', $request->mobile);
            return $this->sendError(true, 'Validation Error.', $validator->messages()->all(), 406);
        } else {
            $set_request = new Request([
                'username' => $request->email,
                'password' => $request->email . 'thirdPartyApi',
            ]);

            if (User::where("username", $request->email)->exists()) {
                $this->activity_log('Login', 'Social Login', 'Re-login With Email', 'Done', $request->email);
                return $this->login_for_user($set_request);
            } else {

                try {

                    $user = User::create([
                        'name' => $request->name,
                        'username' => $request->email,
                        'email' => $request->email,
                        'password' => Hash::make($request->email . 'thirdPartyApi'),
                        'user_type' => "User",
                        'register_by' => "Google"
                    ]);

                    return $this->login_for_user($set_request);
                } catch (\Throwable $th) {
                    $this->activity_log('Registration', 'Social Login', 'Database Insert Error', 'Faild', $request->email);
                    return $this->sendError(true, 'Registration Insert Error', 'Database Insert Error', 406);
                }
            }
        }
    }

    public function UserProfileUpdate(Request $request)
    {

        $validator =  \Validator::make($request->all(), [
            'user_id' => 'required|int',
            //'profile_photo_path'=>'required|mimes:jpeg,jpg,png,gif|required|max:10000',
            //'address'=>'required',
            // 'business_name'=>'required|string',
            // 'productOrservices'=>'required|string',
            // 'line_of_business'=>'required|string',
            // 'corporation_type'=>'required|string',
            // 'state'=>'required|string'
        ]);


        if ($validator->fails()) {

            //pass validator errors as errors object for ajax response
            $this->activity_log('Profile', 'Profile Update', 'Profile data not validated', 'Faild', $request->user_id);
            return $this->ResponseJson(true, "Input data error", $validator->errors(), 200);
        } else {

            $dt = User::findOrFail($request->user_id);

            $dt->name = isset($request->name) ? $request->name : $dt->name;
            $dt->email = isset($request->email) ? $request->email : $dt->email;
            $dt->mobile = isset($request->mobile) ? $request->mobile : $dt->mobile;
            $dt->address = isset($request->address) ? $request->address : $dt->email;

            if ($request->file('profile_photo_path')) {
                $file = $request->file('profile_photo_path');
                $Ext = $file->getClientOriginalExtension();
                $file_path = public_path('profile_image/');
                $iName = date('YmdHis') . "." . $Ext;
                $dt->profile_photo_path = 'public/profile_image/' . $iName;
                $file->move($file_path, $iName);
            }
            $dt->save();
            $this->activity_log('Profile', 'Profile Update', 'Profile Data Updated', 'Done', $dt->id);
            return $this->ResponseJson(false, 'Profile Updated Successfully', "", 200);
        }
    }


    public function login_for_user(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            $this->activity_log('Registration', 'ThirdParty Registration', implode(",", $validator->messages()->all()), 'Faild', $request->mobile);
            return $this->sendError(true, 'Validation Error.', $validator->messages()->all(), 406);
        } else {

            $token = $this->guard()->attempt(['username' => $request->username, 'password' => $request->password]);

            if ($token) {
                $user =  auth('api')->user();
                //$update_user = User::UpdateLoginDate($user->id);
                $data["id"] = $user->id;
                $data["name"] = $user->name;
                $data["email"] = $user->email != "" ? $user->email : '';
                $data["username"] = $user->username != "" ? $user->username : '';
                $data["mobile"] = $user->mobile != "" ? $user->mobile : '';
                $data["address"] = $user->address != "" ? $user->address : '';
                $data["registered_by"] = $user->registered_by;
                $authenticate_token = $this->respondWithToken($token);
                $data["jwt_token"] = $authenticate_token;

                $this->activity_log('Login', 'Deafult Login', 'Login Successfully', 'Done', $user->id);
                return $this->ResponseJson(false, 'Login Successfull!', $data, 200);
            } else {
                $this->activity_log('Login', 'Deafult Login', 'Login Credentials Not Matched', 'Faild', $request->username);
                return $this->ResponseJson(true, "Invalid Credentials.", (object)[], 401);
            }
        }
    }

    public function cache_clear()
    {
        $exitCode1 = Artisan::call('cache:clear');
        $exitCode2 = Artisan::call('route:cache');
        $exitCode3 = Artisan::call('config:cache');

        echo "all Cleared";
    }


    public function userInfo()
    {
        $data = $this->guard()->user();
        return $this->ResponseJson(false, 'User Profile Data', $data, 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function match_mobile_number(Request $req)
    {

        if ($req->username) {
            $username = $req->username;
            $dt = User::where('username', $username);
        } else {
            $mobile = $req->mobile;
            $dt = User::where('mobile', $mobile);
        }


        $resend_expired = date("Y-m-d H:i:s");
        $code = rand(100000, 999999);

        if ($dt->exists()) {
            $upds = $dt->first();

            $upd = User::find($upds->id);
            $upd->otp = $code;

            if ($upd->save()) {

                $msg = "Security code sent in your registered mobile - " . $upds->mobile;


                $senderid = '8809612440231';
                $number = $this->formatPhoneToSendSms($req->username);

                $messsage = "Hi" . $upds->name . "Your Builder-App O-T-P Code - " . $code;

                // $data = array('userid' => 'spcoxsbazar@police.gov.bd', 'password' => 'police123', 'recipient' => $number, 'sender' => $senderid, 'body' => $messsage);

                // $string = http_build_query($data);
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, 'https://psms.dianahost.com/api/sms/v1/send');
                // curl_setopt($ch, CURLOPT_POST, true);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $string);


                // $content = curl_exec($ch);

                // $result = json_decode($content);

                // print_r($result);
                // exit;

                // curl_close($ch);

                //  if ($result->code == 200 && $result->status == 'success') {

                //       $this->activity_log('Account','Account Reset','Account Reset code send successfully','Done',$upds->id);
                //       return $this->ResponseJson(false, $msg, ["userid" => $upds->id, "resend_expired" => $resend_expired], 200);

                //  }else{
                //       $this->activity_log('Account','Account Otp Send Error','Account Otp Not Send','Done',$upds->id);
                //       return $this->ResponseJson(false, "Unable to send OTP, please try later", ["userid" => $upds->id, "resend_expired" => $resend_expired], 200);
                //  }

                return $this->ResponseJson(false, $msg, ["userid" => $upds->id, "resend_expired" => "User OTP Expire Time 5 Minutes", "otp" => $code], 200);
            } else {
                $this->activity_log('Account', 'Account Reset', 'User Access not match', 'Faild', "-");
                return $this->ResponseJson(true, "Unable to send OTP, please try later", $upd, 200);
            }
        } else {
            $this->activity_log('Account', 'Account Reset', 'User Access not match', 'Faild', "-");
            return $this->ResponseJson(true, "Login ID not found", (object)[], 200);
        }
    }

    public function code_combination(Request $req)
    {
        $otp = $req->otp;
        $id = $req->userid;
        if ($otp && $id && $req->password) {
            $dt = User::where('id', $id)->where("otp", $otp);
            if ($dt->exists()) {
                $dt = User::find($id);
                $dt->password = Hash::make($req->password);
                if ($dt->save()) {
                    $this->activity_log('Account', 'Account Reset', 'Account Password change successfully', 'Done', $dt->user_id);
                    return $this->ResponseJson(false, "Your new password set successfully ", (object)[], 200);
                } else {
                    return $this->ResponseJson(true, "Unable to set new password", (object)[], 406);
                }
            } else {
                return $this->ResponseJson(true, "Invalid security code", (object)[], 406);
            }
        } else {
            return $this->ResponseJson(true, "Userid, password & security code required", (object)[], 406);
        }
    }

    public function formatPhoneToSendSms($phoneNumber)
    {
        $phoneNumber = str_replace(' ', '', $phoneNumber);
        $phoneNumber = str_replace('-', '', $phoneNumber);
        if (strlen($phoneNumber) == 11) {
            $phoneNumber = '+88' . $phoneNumber;
        } else if (strlen($phoneNumber) == 13) {
            $phoneNumber = '+' . $phoneNumber;
        } else {
            $phoneNumber = $phoneNumber;
        }
        return $phoneNumber;
    }
}
