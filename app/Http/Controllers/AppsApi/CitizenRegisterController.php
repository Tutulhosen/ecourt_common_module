<?php

namespace App\Http\Controllers\AppsApi;

use App\Models\User;
use App\Rules\IsEnglish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;


class CitizenRegisterController extends BaseController
{
    //citizen registration process

    public function citizen_registration(Request $request){
   
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];

        $validator = Validator::make(
            $data,
            [
                'input_name' => 'required',
                'mobile_no' => 'required|size:11|regex:/(01)[0-9]{9}/',
            ],
            [
                'input_name.required' => 'পুরো নাম লিখুন',
                'mobile_no.required' => 'মোবাইল নং দিতে হবে',
                'mobile_no.size' => '১১ সংখ্যার ইংরেজিতে মোবাইল নং দিতে হবে',
                'mobile_no.regex' => '১১ সংখ্যার ইংরেজিতে মোবাইল নং দিতে হবে',
            ]

        );

        if ($validator->fails()) {

            return  $this->sendError($validator->errors()->first(), ['error' => $validator->errors()->first()], 200);
        }
        
        $if_not_varified_accout=DB::table('users')->where('username',$data['mobile_no'])->where('is_verified_account', 0)->first();
       
        if (!empty($if_not_varified_accout)) {
            DB::table('users')->where('username',$data['mobile_no'])->where('is_verified_account', 0)->delete();
        }
        $if_has_already_have_same_type_accout=DB::table('users')->where('username',$data['mobile_no'])->where('is_citizen',1)->where('citizen_type_id',$data['citizen_type_id'])->where('is_verified_account', 1)->first();
        
        // dd($data['email']);
        
        if (!empty($if_has_already_have_same_type_accout)) {

            $already_registered_message = 'আপনার মোবাইল নং দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে';
 
            return  $this->sendError($already_registered_message, ['error' => $already_registered_message], 200);
        } 

        if ($data['email']) {
            $if_has_already_use_email__same_type_accout=DB::table('users')->where('email',$data['email'])->where('is_citizen',1)->where('citizen_type_id',$data['citizen_type_id'])->where('is_verified_account', 1)->first();
            // dd($if_has_already_use_email__same_type_accout);
            if (!empty($if_has_already_use_email__same_type_accout)) {
                $already_registered_by_email = 'আপনার ইমেইল নং দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে';
                return  $this->sendError($already_registered_by_email, ['error' => $already_registered_by_email], 200);
               
            }
        }
        
        $FourDigitRandomNumber = rand(1111, 9999);
    
        // return $request;
        $result = DB::table('users')->insertGetId([
            'name' => $data['input_name'],
            'username' => $data['mobile_no'],
            'mobile_no' => $data['mobile_no'],
            'email' => $data['email'],
            'is_citizen' => 1,
            'citizen_type_id' => $data['citizen_type_id'],
            'is_verified_account' => 0,
            'otp' => $FourDigitRandomNumber,
            'password' => Hash::make('google_sso_login_password_14789_gcc_ourt_otp_based'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        if ($result) {
            
            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $FourDigitRandomNumber . ' ধন্যবাদ।';
      
            $mobile = $data['mobile_no'];
            send_sms($mobile, $message);
            $user_id = ['user_id' => $result];
            
            return $this->sendResponse($user_id, 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য ওটিপি ব্যবহার করুন');
        }
        
    }

    //resent otp
    public function registration_otp_resend(Request $request){
        
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];
        $user_id= $data['user_id'];
        $otp = rand(1111, 9999);

        $update_otp = DB::table('users')
            ->where('id', '=', $user_id)
            ->update([
                'otp' => $otp,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($update_otp) {
            $user = User::where('id', $user_id)->first();

            $mobile = $user->mobile_no;

            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . ' ধন্যবাদ।';
            // $m = str_replace(' ', '%20', $message);

            send_sms($mobile, $message);

            $user_id = ['user_id' => $user_id];
            
            return $this->sendResponse($user_id, 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য ওটিপি ব্যবহার করুন');

        }
    }

    //citizen registration otp verify
    public function citizen_registration_opt_verify(Request $request){
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];
        $otp = $data['otp_1'] . $data['otp_2']  . $data['otp_3']  . $data['otp_4'] ;

      
        $result = User::where('otp', $otp)
            ->where('id', $data['user_id'])
            ->first();
       
        // return $result;
        if (empty($result)) {
            return  $this->sendError('সঠিক ওটিপি প্রদান করুন', ['error' => 'সঠিক ওটিপি প্রদান করুন'], 200);
        } else {
            User::where('id', $data['user_id'])->update(['password' => Hash::make('google_sso_login_password_14789_gcc_ourtm#P52s@ap$V')]);
            return $this->sendResponse('', 'সিস্টেমে নিবন্ধন সম্পন্ন হয়েছে');
        }
    }

    // password_set_for_citizen
    public function password_set_for_citizen(Request $request){
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];

        $validator = Validator::make(
            $data,
            [
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6',
            ],
            [
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.same' => 'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
            ],

        );
        if ($validator->fails()) {

            return  $this->sendError($validator->errors()->first(), ['error' => $validator->errors()->first()], 200);
        }
        User::where('id', $data['user_id'])->update([
            'password' => Hash::make($data['password']),
            'is_verified_account' => 2,
        ]);
        return $this->sendResponse(null, 'পাসওয়ার্ড হালনাগাদ হয়েছে');

    }

    // password_set_for_org
    public function password_set_for_org(Request $request){
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];

   
        $validator = Validator::make(
            $data,
            [
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'organization_id' => ['required', new IsEnglish()],
                'confirm_password' => 'min:6',
                'office_id' => 'required',
                'division_id' => 'required',
                'district_id' => 'required',
                'upazila_id' => 'required',
                'organization_type' => 'required',
                'office_name_bn' => 'required',
                'office_name_en' => ['required', new IsEnglish()],
                'organization_physical_address' => 'required',
                'organization_employee_id' => 'required',
                'designation' => 'required',
            ],
            [
                'division_id.required' => 'বিভাগ নির্বাচন করুন',
                'district_id.required' => 'জেলা নির্বাচন করুন',
                'upazila_id.required' => 'উপজেলা নির্বাচন করুন',
                'organization_type.required' => 'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required' => 'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required' => 'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required' => 'প্রতিষ্ঠানের ঠিকানা দিন',
                'office_id.required' => 'অফিস নির্বাচন করুন',
                'organization_id.required' => 'রাউটিং নং দিতে হবে',
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
                'password.same' => 'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'organization_employee_id.required' => 'প্রতিনিধির EmployeeID দিতে হবে',
                'designation.required' => 'পদবী দিতে হবে',
            ],

        );
        if ($validator->fails()) {

            return  $this->sendError($validator->errors()->first(), ['error' => $validator->errors()->first()], 200);
        }

        if ($data['office_id'] == 'OTHERS') {
            $office['office_name_bn'] = $data['office_name_bn'];
            $office['office_name_en'] = $data['office_name_en'];
            $office['division_id'] = $data['division_id'];
            $office['district_id'] = $data['district_id'];
            $office['upazila_id'] = $data['upazila_id'];
            $office['organization_type'] = $data['organization_type'];
            $office['organization_physical_address'] = $data['organization_physical_address'];
            $office['organization_routing_id'] = $data['organization_id'];
            $office['is_organization'] = 1;
            $office['level'] = 4;
           
            $office_id = DB::table('office')->insertGetId($office);
        } else {
            $office_id = $data['office_id'];
        }

        $organization_deligate = [
            'designation' => $data['designation'],
            'password' => Hash::make($data['password']),
            'is_verified_account' => 2,
            'office_id' => $office_id,
            'organization_id' => $data['organization_id'],
            'organization_employee_id' => $data['organization_employee_id'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        User::where('id', $data['user_id'])->update($organization_deligate);

        return $this->sendResponse(null, 'পাসওয়ার্ড ও প্রাতিষ্ঠানিক হালনাগাদ হয়েছে');

    }

    // get dependent organization
    public function getDependentOrganization(Request $request){
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];

        $office_information = DB::table("office")
        ->where("division_id",$data['division_id'])
        ->where("district_id",$data['district_id'])
        ->where("upazila_id",$data['upazila_id'])
        ->where('organization_type',$data['organization_type'])
        ->where('status',1)
        ->where('is_organization',1)
        ->select('*')
        ->get();
      
        return $this->sendResponse($office_information, 'তথ্য পাওয়া গেছে');

   
        

    }

    //delete citizen
    public function deleteCitizen(Request $request){
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];

        $user=DB::table('users')->where('username', $data['phone'])->first();
  
        if ($user) {
            if (!empty($user->citizen_id)) {
                $citizen = DB::table('ecourt_citizens')
                    ->where('id', $user->citizen_id)
                    ->where('citizen_type_id', $data['citizen_type_id'])
                    ->first();
                if ($citizen) {
                    DB::table('ecourt_citizens')->where('id', $citizen->id)->delete(); 
                }
            }
            DB::table('users')->where('id', $user->id)->delete(); 
            return $this->sendResponse(null, 'তথ্য ডিলিট হয়েছে');
        }else {
            return $this->sendResponse(null, 'তথ্য খুঁজে পাওয়া যায়নি');
        }
      

   
        

    }

    //citizen dashboard data
    public function citizen_dashboard(Request $request){
        if (Auth::user()->doptor_user_active == 0 && Auth::user()->is_citizen == 1 && Auth::user()->citizen_type_id == 1) {
            $user = Auth::user();
            // dd($user);
            $citizen_info = DB::table('users')
                ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
                ->select('ecourt_citizens.citizen_NID','ecourt_citizens.citizen_phone_no')
                ->where('users.id', $user->id)
                ->where('ecourt_citizens.citizen_type_id', 1)
                ->first();
            $auth_user = [
                'citizen_nid' => $citizen_info->citizen_NID,
                'citizen_phone_no' => $citizen_info->citizen_phone_no,
                'user_id' => $user->id,
                'username' => $user->username,

            ];

            $jsonData = json_encode($auth_user);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getEmcBaseUrl() . '/api/emc-citizen-dashboard-data',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'user_data' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            )); 

            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
            if (!empty($res)) {
                $data['pending_case'] = $res->total_pending_case_count_applicant->total_count;
                $data['total_case'] = $res->total_case_count_applicant->total_count;
                $data['running_case'] = $res->total_running_case_count_applicant->total_count;
                $data['completed_case'] = $res->total_completed_case_count_applicant->total_count;

                $data['pending_appeal_case'] = $res->total_pending_appeal_case_count_applicant->total_count;
                $data['total_appeal_case'] = $res->total_appeal_case_count_applicant->total_count;
                $data['running_appeal_case'] = $res->total_running_appeal_case_count_applicant->total_count;
                $data['completed_appeal_case'] = $res->total_completed_appeal_case_count_applicant->total_count;
                $data['appeal'] = null;

            } else {
                $data['total_case'] = 'server error';
                $data['running_case'] = 'server error';
                $data['pending_case'] = 'server error';
                $data['completed_case'] = 'server error';
                
                $data['total_appeal_case'] = 'server error';
                $data['running_appeal_case'] = 'server error';
                $data['pending_appeal_case'] = 'server error';
                $data['completed_appeal_case'] = 'server error';
                $data['appeal'] = null;
            }

            return $this->sendResponse($data, 'Citizen dashboard data for emc court');
        }elseif (Auth::user()->doptor_user_active == 0 && Auth::user()->is_citizen == 1 && Auth::user()->citizen_type_id == 2) {
            $user = Auth::user();
            $citizen_info = DB::table('users')
                ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
                ->select('ecourt_citizens.citizen_NID', 'ecourt_citizens.organization_id')
                ->where('users.id', $user->id)
                ->where('ecourt_citizens.citizen_type_id', 2)
                ->first();
            // dd($citizen_info);
            $auth_user = [
                'citizen_nid' => $citizen_info->citizen_NID,
                'organization_id' => $citizen_info->organization_id,
                'user_id' => $user->id,
                'username' => $user->username,
            ];


            $jsonData = json_encode($auth_user);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getGccBaseUrl() . '/api/count-org-rep-dashboard-data',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'jss' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
            // dd($res);
            if (!empty($res)) {
                $data['pending_case'] = $res->total_pending_case_count_applicant->total_count;
                $data['total_case'] = $res->total_case_count_applicant->total_count;
                $data['running_case'] = $res->total_running_case_count_applicant->total_count;
                $data['completed_case'] = $res->total_completed_case_count_applicant->total_count;

                $data['pending_appeal_case'] = $res->total_pending_appeal_case_count_applicant->total_count;
                $data['total_appeal_case'] = $res->total_appeal_case_count_applicant->total_count;
                $data['running_appeal_case'] = $res->total_running_appeal_case_count_applicant->total_count;
                $data['completed_appeal_case'] = $res->total_completed_appeal_case_count_applicant->total_count;
                $data['appeal'] = null;
            } else {
                $data['total_case'] = 'server error';
                $data['running_case'] = 'server error';
                $data['pending_case'] = 'server error';
                $data['completed_case'] = 'server error';
                $data['total_appeal_case'] = 'server error';
                $data['running_appeal_case'] = 'server error';
                $data['pending_appeal_case'] = 'server error';
                $data['completed_appeal_case'] = 'server error';
                $data['appeal'] = null;
            }
            return $this->sendResponse($data, 'Organization Representative dashboard data for gcc court');
        }
        
    }

    //citizen dashboard data for gcc
    public function citizen_dashboard_data_for_gcc(Request $request){
        if (Auth::user()->doptor_user_active == 0 && Auth::user()->is_citizen == 1 && Auth::user()->citizen_type_id == 1) {
            $user = Auth::user();
            // dd($user);
            $citizen_info = DB::table('users')
                ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
                ->select('ecourt_citizens.citizen_NID','ecourt_citizens.citizen_phone_no')
                ->where('users.id', $user->id)
                ->where('ecourt_citizens.citizen_type_id', 1)
                ->first();
            $auth_user = [
                'citizen_nid' => $citizen_info->citizen_NID,
                'citizen_phone_no' => $citizen_info->citizen_phone_no,
                'user_id' => $user->id,
                'username' => $user->username,

            ];

            $jsonData = json_encode($auth_user);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getGccBaseUrl() . '/api/count-gcc-citizen-dashboard-data',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'jss' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));

            $gcc_response = curl_exec($curl);
            curl_close($curl);
            $gcc_res = json_decode($gcc_response);
            // dd($gcc_res);
            if (!empty($gcc_res)) {
                $data['pending_case'] = $gcc_res->total_pending_case_count_gcc_citizen->total_count;
                $data['total_case'] = $gcc_res->total_case_count_gcc_citizen->total_count;
                $data['running_case'] = $gcc_res->total_running_case_count_gcc_citizen->total_count;
                $data['completed_case'] = $gcc_res->total_completed_case_count_gcc_citizen->total_count;

                $data['pending_appeal_case'] = $gcc_res->total_pending_appeal_case_count_gcc_citizen->total_count;
                $data['total_appeal_case'] = $gcc_res->total_appeal_case_count_gcc_citizen->total_count;
                $data['running_appeal_case'] = $gcc_res->total_running_appeal_case_count_gcc_citizen->total_count;
                $data['completed_appeal_case'] = $gcc_res->total_completed_appeal_case_count_gcc_citizen->total_count;
                $data['appeal'] = null;
            } else {
                $data['total_case'] = 'server error';
                $data['running_case'] = 'server error';
                $data['pending_case'] = 'server error';
                $data['completed_case'] = 'server error';
                
                $data['total_appeal_case'] = 'server error';
                $data['running_appeal_case'] = 'server error';
                $data['pending_appeal_case'] = 'server error';
                $data['completed_appeal_case'] = 'server error';
                $data['appeal'] = null;
            }

            return $this->sendResponse($data, 'Citizen dashboard data for gcc court');
        }
    }




}
