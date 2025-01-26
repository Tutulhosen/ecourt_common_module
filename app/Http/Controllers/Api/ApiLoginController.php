<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\NDoptorRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;
use PhpParser\Node\Stmt\Return_;

class ApiLoginController extends BaseController
{
    //login process citizen
    public function logined_in(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'citizen_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([

                "success" => false,
                "message" => $validator->errors()->all(),
                "err_res" => "",
                "status" => 200,
                "data" => null


            ]);
        }
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'citizen_type_id' => $request->citizen_type_id]) ||    Auth::attempt(['username' => $request->email, 'password' => $request->password, 'citizen_type_id' => $request->citizen_type_id])) {
            $user = Auth::user();

            // Create a new Passport token for the authenticated user
            $tokenResult = $user->createToken('common-module-token');
    
            // Extract the access token from the token result
            $accessToken = $tokenResult->accessToken;
            // dd($accessToken);
            // Optionally, you can return additional information along with the token
            // $success['token'] = $accessToken->token;
            $success['user'] = $user;
          
            $jsonData = json_encode($success);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://127.0.0.1:7870/api/common-module-login',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'jss'=>$jsonData
                    ) ,
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court" ,
                 
                ),
            ));
    
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
            
        }else {
            return response()->json([
                'error' => 'Please Enter Valid Credential!',
                'nothi_msg' => 'সঠিক ইমেইল অথবা মোবাইল নং এবং পাসওয়ার্ড প্রদান করুন ',
    
            ]);
        }

        
    }


    public function logined_in_old(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'citizen_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([

                "success" => false,
                "message" => $validator->errors()->all(),
                "err_res" => "",
                "status" => 200,
                "data" => null


            ]);
        }
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'citizen_type_id' => $request->citizen_type_id]) ||    Auth::attempt(['username' => $request->email, 'password' => $request->password, 'citizen_type_id' => $request->citizen_type_id])) {
           
            return $user=Auth::user();

            // $secrate_key = 'common-court-key';
            // $from_request= $request->Header('secrate_key');
        
            // if ($secrate_key === $from_request) {
            //     $user=Auth::user();
                
            //     return $user;
            // }else {
            //     return "Invalid Request";
            // }
            
        }else {
            return response()->json([
                'error' => 'Please Enter Valid Credential!',
                'nothi_msg' => 'সঠিক ইমেইল অথবা মোবাইল নং এবং পাসওয়ার্ড প্রদান করুন ',
    
            ]);
        }
        
        
    }

    public function mobile_court_logined_in(Request $request){
       
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([

                "success" => false,
                "message" => $validator->errors()->all(),
                "err_res" => "",
                "status" => 200,
                "data" => null


            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // role name //
            $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
                ->first()->role_name;
            // Office name //
            $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                ->first();
            // Results
            $success['user_id']      =  isset($user->id) ? $user->id : null;
            $success['name']         =  isset($user->name) ? $user->name : null;
            $success['email']        =  isset($user->email) ? $user->email : null;
            $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
            $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
            $success['role_name']    =  isset($roleName) ? $roleName : null;
            $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
            $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
            $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
            $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
            $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
            $success['token']        =  $user->createToken('Login')->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        } else if (Auth::attempt(['citizen_nid' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // dd($user);
            // return $user;

            // role name //
            $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
                ->first()->role_name;
            // Office name //
            $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                ->first();


            // Results
            $success['user_id']      =  isset($user->id) ? $user->id : null;
            $success['name']         =  isset($user->name) ? $user->name : null;
            $success['email']        =  isset($user->email) ? $user->email : null;
            $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
            $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
            $success['role_name']    =  isset($roleName) ? $roleName : null;
            $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
            $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
            $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
            $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
            $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
            $success['token']        =  $user->createToken('Login')->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        } elseif (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
                ->first()->role_name;
            // Office name //
            $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                ->first();
            // Results
            $success['user_id']      =  isset($user->id) ? $user->id : null;
            $success['name']         =  isset($user->name) ? $user->name : null;
            $success['email']        =  isset($user->email) ? $user->email : null;
            $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
            $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
            $success['role_name']    =  isset($roleName) ? $roleName : null;
            $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
            $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
            $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
            $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
            $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
            $success['token']        =  $user->createToken('Login')->accessToken;


            return $this->sendResponse($success, 'User login successfully.');
        } else {
            
          
                if (Auth::attempt(['username' => $request->email,'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                    $user = Auth::user();
                    // $token = $user->createToken('Token Name')->accessToken;
                    // $mobilecourt = DB::table('doptor_user_access_info')->where('user_id', $user->id)->where('court_type_id',1)->first();
                    // $gccourt = DB::table('doptor_user_access_info')->where('user_id', $user->id)->where('court_type_id',2)->first();
                    // $emcourt = DB::table('doptor_user_access_info')->where('user_id', $user->id)->where('court_type_id',3)->first();

                    

                    // Office name //
                    $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                        ->first();
                    // Results
                    // $success['user_id']      =  isset($user->id) ? $user->id : null;
                    // $success['name']         =  isset($user->name) ? $user->name : null;
                    // $success['email']        =  isset($user->email) ? $user->email : null;
                    // $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
                    // $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
                    // $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
                    // $success['role_name']    =  isset($roleName) ? $roleName : null;
                    // $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
                    // $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
                    // $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
                    // $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
                    // $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
                    // $success['mobilecourt']  =  isset($mobilecourt) ? $mobilecourt : null;
                    // $success['gccourt']      =  isset($gccourt) ? $gccourt : null;
                    // $success['emcourt']      =  isset($emcourt) ? $emcourt : null;
                    $success['user_info']=DB::table('users as U')
                    ->where('U.id', $request->user()->id)
                    ->join('doptor_user_access_info as D', 'U.id', 'D.user_id')
                    ->where('D.court_type_id', 1)
                    ->select('U.id as id','U.name as name' ,'U.username as username','U.office_id as office_id','U.doptor_office_id as doptor_office_id' ,'U.doptor_user_flag as doptor_user_flag','U.doptor_user_active as doptor_user_active','U.peshkar_active as peshkar_active','U.court_id as court_id','U.mobile_no as mobile_no','U.profile_image as profile_image','U.signature as signature','U.designation as designation','U.email as email','U.email_verified_at as email_verified_at','U.is_verified_account as is_verified_account','U.profile_pic as profile_pic','U.created_at as created_at','U.updated_at as updated_at','D.id as user_access_id','D.court_type_id as user_access_court_type_id','D.role_id as user_access_role_id','D.court_id as user_access_court_id','D.created_at as user_access_created_at')
                    ->first();
                    $get_user_office=DB::table('users')->where('id', $request->user()->id)->select('office_id')->first();
                    $success['office_data']=DB::table('office')->where('id', $get_user_office->office_id)->first();
                    $success['password']=$user->password;
                  
                    // $success['token']        =  $user->createToken('EMC-CLIENT')->accessToken;

                    return $this->sendResponse($success, 'User login successfully.');
                     


                }
            
        }



        return $this->sendError('Unauthorised.', ['error' => 'User login failed.'], 401);
       
    }
    public function gcc_court_logined_in(Request $request){
       
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([

                "success" => false,
                "message" => $validator->errors()->all(),
                "err_res" => "",
                "status" => 200,
                "data" => null


            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // role name //
            $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
                ->first()->role_name;
            // Office name //
            $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                ->first();
            // Results
            $success['user_id']      =  isset($user->id) ? $user->id : null;
            $success['name']         =  isset($user->name) ? $user->name : null;
            $success['email']        =  isset($user->email) ? $user->email : null;
            $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
            $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
            $success['role_name']    =  isset($roleName) ? $roleName : null;
            $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
            $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
            $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
            $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
            $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
            $success['token']        =  $user->createToken('Login')->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        } else if (Auth::attempt(['citizen_nid' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // dd($user);
            // return $user;

            // role name //
            $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
                ->first()->role_name;
            // Office name //
            $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                ->first();


            // Results
            $success['user_id']      =  isset($user->id) ? $user->id : null;
            $success['name']         =  isset($user->name) ? $user->name : null;
            $success['email']        =  isset($user->email) ? $user->email : null;
            $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
            $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
            $success['role_name']    =  isset($roleName) ? $roleName : null;
            $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
            $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
            $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
            $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
            $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
            $success['token']        =  $user->createToken('Login')->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        } elseif (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
                ->first()->role_name;
            // Office name //
            $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                ->first();
            // Results
            $success['user_id']      =  isset($user->id) ? $user->id : null;
            $success['name']         =  isset($user->name) ? $user->name : null;
            $success['email']        =  isset($user->email) ? $user->email : null;
            $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
            $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
            $success['role_name']    =  isset($roleName) ? $roleName : null;
            $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
            $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
            $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
            $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
            $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
            $success['token']        =  $user->createToken('Login')->accessToken;


            return $this->sendResponse($success, 'User login successfully.');
        } else {
            $user_create = $this->test_login_fun($request->email, $request->password);
            if ($user_create) {
                if (Auth::attempt(['username' => $request->email,'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                    $user = Auth::user();
                    // Office name //
                    $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                        ->first();
            
                    $success['user_info']=DB::table('users as U')
                    ->where('U.id', $request->user()->id)
                    ->join('doptor_user_access_info as D', 'U.id', 'D.user_id')
                    ->where('D.court_type_id', 2)
                    ->select('U.id as id','U.name as name' ,'U.username as username','U.office_id as office_id','U.doptor_office_id as doptor_office_id' ,'U.doptor_user_flag as doptor_user_flag','U.doptor_user_active as doptor_user_active','U.peshkar_active as peshkar_active','U.court_id as court_id','U.mobile_no as mobile_no','U.profile_image as profile_image','U.signature as signature','U.designation as designation','U.email as email','U.email_verified_at as email_verified_at','U.is_verified_account as is_verified_account','U.profile_pic as profile_pic','U.created_at as created_at','U.updated_at as updated_at','D.id as user_access_id','D.court_type_id as user_access_court_type_id','D.role_id as user_access_role_id','D.court_id as user_access_court_id','D.created_at as user_access_created_at')
                    ->first();
                    $get_user_office=DB::table('users')->where('id', $request->user()->id)->select('office_id')->first();
                    $success['office_data']=DB::table('office')->where('id', $get_user_office->office_id)->first();
                    $success['password']=$user->password;
                  
                    // $success['token']        =  $user->createToken('EMC-CLIENT')->accessToken;

                    return $this->sendResponse($success, 'User login successfully.');
                     


                }
            }
            
        }



        return $this->sendError('Unauthorised.', ['error' => 'User login failed.'], 401);
       
    }
    public function emc_court_logined_in(Request $request){
       
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([

                "success" => false,
                "message" => $validator->errors()->all(),
                "err_res" => "",
                "status" => 200,
                "data" => null


            ]);
        }

        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     return 'ok';
        //     // role name //
        //     $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
        //         ->first()->role_name;
        //     // Office name //
        //     $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
        //         ->first();
        //     // Results
        //     $success['user_id']      =  isset($user->id) ? $user->id : null;
        //     $success['name']         =  isset($user->name) ? $user->name : null;
        //     $success['email']        =  isset($user->email) ? $user->email : null;
        //     $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
        //     $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
        //     $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
        //     $success['role_name']    =  isset($roleName) ? $roleName : null;
        //     $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
        //     $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
        //     $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
        //     $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
        //     $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
        //     $success['token']        =  $user->createToken('Login')->accessToken;

        //     return $this->sendResponse($success, 'User login successfully.');
        // } else if (Auth::attempt(['citizen_nid' => $request->email, 'password' => $request->password])) {
        //     $user = Auth::user();
        //     // dd($user);
        //     // return $user;
        //     return 'okfff';
        //     // role name //
        //     $roleName = DB::table('role')->select('role_name')->where('id', $user->role_id)
        //         ->first()->role_name;
        //     // Office name //
        //     $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
        //         ->first();


        //     // Results
        //     $success['user_id']      =  isset($user->id) ? $user->id : null;
        //     $success['name']         =  isset($user->name) ? $user->name : null;
        //     $success['email']        =  isset($user->email) ? $user->email : null;
        //     $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
        //     $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
        //     $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
        //     $success['role_name']    =  isset($roleName) ? $roleName : null;
        //     $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
        //     $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
        //     $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
        //     $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
        //     $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
        //     $success['token']        =  $user->createToken('Login')->accessToken;

        //     return $this->sendResponse($success, 'User login successfully.');
        // } elseif (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
        //   $user = Auth::user();
        //    $citizen_type_id= $user['citizen_type_id'];
           
        //   $citizen_info = DB::table('users')
        //    ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
        //    ->select('ecourt_citizens.citizen_NID','ecourt_citizens.citizen_phone_no','ecourt_citizens.id as citizen_id')
        //    ->where('users.id', $user->id)
        //    ->where('ecourt_citizens.citizen_type_id', 1)
        //    ->first();
           
        //     // $roleName = DB::table('emc_role')->select('role_name')->where('id', $user->role_id)
        //     //     ->first()->role_name;
        //     // Office name //
        // //    return  $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
        // //         ->first();
        // //    $officeInfo = DB::table('ecourt_citizens')->where('id', $user->id)->first();
        //     // Results
        //     $success['user_id']      =  isset($user->id) ? $user->id : null;
        //     $success['name']         =  isset($user->name) ? $user->name : null;
        //     $success['email']        =  isset($user->email) ? $user->email : null;
        //     $success['mobile_no']    =  isset($user->mobile_no) ? $user->mobile_no : null;
        //     $success['citizen_type_id']  =  isset($user->citizen_type_id) ? $user->citizen_type_id : null;
        //     $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
        //     $success['role_id']      =  isset($user->role_id) ? $user->role_id : null;
        //     $success['court_id']     =  isset($user->court_id) ? $user->court_id : null;
        //     $success['role_name']="নাগরিক ";
        //     $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
        //     $success['office_name']  =  isset( $citizen_info->office_name_bn) ?  $citizen_info->office_name_bn : null;
        //     $success['division_id']  =  isset( $citizen_info->division_id) ?  $citizen_info->division_id : null;
        //     $success['district_id']  =  isset( $citizen_info->district_id) ?  $citizen_info->district_id : null;
        //     $success['upazila_id']   =  isset( $citizen_info->upazila_id) ?  $citizen_info->upazila_id : null;
        //     $success['token']        =  $user->createToken('Login')->accessToken;
        //     $success['citizen_id']      =  isset( $citizen_info->citizen_id) ?  $citizen_info->citizen_id : null;
        //     $success['password']=$user->password;
  

        //     return $this->sendResponse($success, 'User login successfully.');
        // } else {
           
            $user_create = $this->test_login_fun($request->email, $request->password);
            if ($user_create) {
                if (Auth::attempt(['username' => $request->email,'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                    $user = Auth::user();
                    // Office name //
                    $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)
                        ->first();
            
                    $success['user_info']=DB::table('users as U')
                    ->where('U.id', $request->user()->id)
                    ->join('doptor_user_access_info as D', 'U.id', 'D.user_id')
                    ->where('D.court_type_id', 3)
                    ->select('U.id as id','U.name as name' ,'U.username as username','U.office_id as office_id','U.doptor_office_id as doptor_office_id' ,'U.doptor_user_flag as doptor_user_flag','U.doptor_user_active as doptor_user_active','U.peshkar_active as peshkar_active','U.court_id as court_id','U.mobile_no as mobile_no','U.profile_image as profile_image','U.signature as signature','U.designation as designation','U.email as email','U.email_verified_at as email_verified_at','U.is_verified_account as is_verified_account','U.profile_pic as profile_pic','U.created_at as created_at','U.updated_at as updated_at','D.id as user_access_id','D.court_type_id as user_access_court_type_id','D.role_id as user_access_role_id','D.court_id as user_access_court_id','D.created_at as user_access_created_at')
                    ->first();
                    $get_user_office=DB::table('users')->where('id', $request->user()->id)->select('office_id')->first();
                    $success['office_data']=DB::table('office')->where('id', $get_user_office->office_id)->first();
                    $success['password']=$user->password;
                  
                    // $success['token']        =  $user->createToken('EMC-CLIENT')->accessToken;

                    return $this->sendResponse($success, 'User login successfully.');
                     


                }
            }
            
        // }
 


        return $this->sendError('Unauthorised.', ['error' => 'User login failed.'], 401);
       
    }

    public function citizen_login_old(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
       
        if ($request->citizen_type_id == 4) {
            if (Auth::guard('parent_office')->attempt(['org_email' => $request->email, 'password' => $request->password])) {
                Session::put('court_type_id', $request->citizen_type_id);
                return response()->json(['success' => 'Successfully logged in!']);
            }
        } else {
         
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password ,'citizen_type_id' => $request->citizen_type_id]) || Auth::attempt(['username' => $request->email, 'password' => $request->password,'citizen_type_id' => $request->citizen_type_id])) {
            $user = Auth::user();
            
                $citizen_type_id= $user['citizen_type_id'];
                $success['user_info']= DB::table('users')
                ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
                ->select('*','ecourt_citizens.id as citizen_id')
                ->where('users.id', $user->id)
                ->where('ecourt_citizens.citizen_type_id', 1)   
                ->first();
    
            
            $officeInfo = DB::table('office')->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')->where('id', $user->office_id)->first();
            $success['user_id']      =  isset($user->id) ? $user->id : null;
            $success['name']         =  isset($user->name) ? $user->name : null;
            $success['email']        =  isset($user->email) ? $user->email : null;
            $success['profile_pic']  =  isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id']      =  isset($userAray->user_access_role_id) ? $userAray->user_access_role_id : null;
            $success['court_id']     =  isset($userAray->user_access_court_id) ? $userAray->user_access_court_id : null;
            $success['role_name']    =  isset($roleName) ? $roleName : null;
            $success['office_id']    =  isset($user->office_id) ? $user->office_id : null;
            $success['office_name']  =  isset($officeInfo->office_name_bn) ? $officeInfo->office_name_bn : null;
            $success['division_id']  =  isset($officeInfo->division_id) ? $officeInfo->division_id : null;
            $success['district_id']  =  isset($officeInfo->district_id) ? $officeInfo->district_id : null;
            $success['upazila_id']   =  isset($officeInfo->upazila_id) ? $officeInfo->upazila_id : null;
            $success['user']         =Auth::user();
            $success['token'] =  $user->createToken('GCC-CLIENT')->accessToken;
        
            return $this->sendResponse($success, 'User login successfully.');
          
            }
        }



        return response()->json([
            'error' => 'Please Enter Valid Credential!',
            'nothi_msg' => 'সঠিক ইমেইল, মোবাইল নং অথবা পাসওয়ার্ড প্রদান করুন ',

        ]);
    }

    public function citizen_login(Request $request)
    {
     
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        // dd($request->all());
        if ($request->citizen_type_id == 4) {
            if (Auth::guard('parent_office')->attempt(['org_email' => $request->email, 'password' => $request->password])) {
                Session::put('court_type_id', $request->citizen_type_id);
                return response()->json(['success' => 'Successfully logged in!']);
            }
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'citizen_type_id' => $request->citizen_type_id]) || Auth::attempt(['username' => $request->email, 'password' => $request->password, 'citizen_type_id' => $request->citizen_type_id])) {
                $user = Auth::user();
                $citizen_info= globalUserInfo();
                $officeInfo= user_office_info();
                if (!empty($request->citizen_type_id)) {
                    if ($request->citizen_type_id==1) {
                        $RoleID=36;
                    }elseif ($request->citizen_type_id==2) {
                        $RoleID=35;
                    }elseif ($request->citizen_type_id==3) {
                        $RoleID=20;
                    } else {
                        $RoleID=null;
                    }
                    
                } else {
                    $RoleID=null;
                }
                
                // Results
                $success['user_id'] = isset($citizen_info->id) ? $citizen_info->id : null;
                $success['name'] = isset($citizen_info->name) ? $citizen_info->name : null;
                $success['email'] = isset($citizen_info->email) ? $citizen_info->email : null;
                $success['profile_pic'] = isset($citizen_info->profile_pic) ? $citizen_info->profile_pic : null;
                $success['role_id'] = $RoleID;
                $success['citizen_type_id'] = isset($citizen_info->citizen_type_id) ? $citizen_info->citizen_type_id : null;
                $success['court_id'] = isset($citizen_info->court_id) ? $citizen_info->court_id : null;
                $success['role_name'] =  null;
                $success['office_id'] =  null;
                $success['office_name'] = $officeInfo->office_name_bn;
                $success['division_id'] = $officeInfo->division_id;
                $success['district_id'] = $officeInfo->district_id;
                $success['upazila_id'] = $officeInfo->upazila_id;
                $success['token'] = $user->createToken('Login')->accessToken;
    
                return $this->sendResponse($success, 'User login successfully.');
            }
        }



        return response()->json([
            'error' => 'Please Enter Valid Credential!',
            'nothi_msg' => 'সঠিক ইমেইল, মোবাইল নং অথবা পাসওয়ার্ড প্রদান করুন ',

        ]);
    }


    public function test_login_fun($test_email, $test_password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => DOPTOR_ENDPOINT() . '/api/user/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['username' => $test_email, 'password' => $test_password],
            CURLOPT_HTTPHEADER => ['api-version: 1'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $response2 = json_decode($response, true);
        $response = json_decode($response);

        if ($response->status == 'success') {

            $username = DB::table('users')
                ->where('username', $response->data->user->username)
                ->first();

            if (empty($username)) {
                if (empty($response2['data']['office_info'])) {
                    return 0;
                }
                $ref_origin_unit_org_id = $response2['data']['organogram_info'][array_key_first($response2['data']['organogram_info'])]['ref_origin_unit_org_id'];

                $office_info = $response->data->office_info[0];

                if ($ref_origin_unit_org_id == 533) {
                    NDoptorRepository::Divisional_Commissioner_create($response, $office_info, $ref_origin_unit_org_id);
                }

                if ($ref_origin_unit_org_id == 51) {
                    NDoptorRepository::DC_create($response, $office_info, $ref_origin_unit_org_id);
                }
            } else {
                return 1;
            }
        }
    }
    
}
