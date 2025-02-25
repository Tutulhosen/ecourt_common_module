<?php

namespace App\Http\Controllers\citizen;

use App\Models\User;
use App\Rules\IsEnglish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\NIDVerificationRepository;
use App\Repositories\CitizenNIDVerifyRepository;

class CitizenRegistrationController extends Controller
{
    //show registration part page
    public function register(){
        // $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        // $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        return view('mobile_first_registration.registration');
    }

    //registration form by type
    public function register_by_type($type_id){
    
        if (decrypt($type_id) == 1) {
            $data['role_id'] = 36;
            $data['page_title'] = 'নাগরিকের নাম এবং মোবাইল নাম্বার যাচাইকরণ';
            $data['name_field_label'] = 'নাগরিকের নাম';
            $data['mobile_field_label'] = 'মোবাইল নং';
            $data['email_field_label'] = 'ইমেইল';
            $data['type_id'] = $type_id;
        } elseif (decrypt($type_id) == 2) {
            $data['role_id'] = 35;
            $data['page_title'] = ' প্রাতিষ্ঠানিক প্রতিনিধির নাম এবং মোবাইল নাম্বার যাচাইকরণ';
            $data['name_field_label'] = 'প্রাতিষ্ঠানিক প্রতিনিধির নাম';
            $data['mobile_field_label'] = 'মোবাইল নং';
            $data['email_field_label'] = 'ইমেইল';
            $data['type_id'] = $type_id;
        } elseif (decrypt($type_id) == 3) {
            $data['role_id'] = 35;
            $data['page_title'] = ' আইনজীবীর নাম এবং মোবাইল নাম্বার যাচাইকরণ';
            $data['name_field_label'] = 'আইনজীবীর নাম';
            $data['mobile_field_label'] = 'মোবাইল নং';
            $data['email_field_label'] = 'ইমেইল';
            $data['type_id'] = $type_id;
        } else {
            return redirect()->route('/');
        }
        // return $data;
        // dd($data);
        return view('mobile_first_registration.mobile_number_form')->with($data);
    }

    //registration otp verify
    public function register_opt_send(Request $request){
        
        $request->validate(
            [
                'input_name' => 'required',
                'mobile_no' => 'required|size:11|regex:/(01)[0-9]{9}/',
            ],
            [
                'input_name.required' => 'পুরো নাম লিখুন',
                'mobile_no.required' => 'মোবাইল নং দিতে হবে',
                'mobile_no.size' => 'মোবাইল নং দিতে হবে ১১ সংখ্যার ইংরেজিতে',
            ],
        );
        $if_not_varified_accout=DB::table('users')->where('username',$request->mobile_no)->where('is_verified_account', 0)->first();
       
        if (!empty($if_not_varified_accout)) {
            DB::table('users')->where('username',$request->mobile_no)->where('is_verified_account', 0)->delete();
        }
        $if_has_already_have_same_type_accout=DB::table('users')->where('username',$request->mobile_no)->where('is_citizen',1)->where('citizen_type_id',decrypt($request->type_id))->where('is_verified_account', 1)->first();
        $if_has_already_use_email__same_type_accout=DB::table('users')->where('email',$request->email)->where('is_citizen',1)->where('citizen_type_id',decrypt($request->type_id))->where('is_verified_account', 1)->first();
        
        
        if (!empty($if_has_already_have_same_type_accout)) {
            $already_registered_message = 'আপনার মোবাইল নং দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে';
            
            return back()->with('already_registered_message', $already_registered_message);
        } 
        if (!empty($if_has_already_use_email__same_type_accout)) {
            $already_registered_by_email = 'আপনার মোবাইল নং দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে';
            
            return back()->with('already_registered_by_email', $already_registered_by_email);
        }
        $FourDigitRandomNumber = rand(1111, 9999);
    
        // return $request;
        $result = DB::table('users')->insertGetId([
            'name' => $request->input_name,
            'username' => $request->mobile_no,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'is_citizen' => 1,
            'citizen_type_id' => decrypt($request->type_id),
            'is_verified_account' => 0,
            'otp' => $FourDigitRandomNumber,
            'password' => Hash::make('google_sso_login_password_14789_gcc_ourt_otp_based'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($result) {

            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $FourDigitRandomNumber . ' ধন্যবাদ।';
            // $m = str_replace(' ', '%20', $message);
            $mobile = $request->mobile_no;
            send_sms($mobile, $message);

            return redirect()
                ->route('registration.citizen.mobile.check', ['user_id' => encrypt($result)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
        
    }

    //registration phone check form by otp
    public function registration_otp_check($user_id){
        $data['page_title'] = 'নাগরিক মোবাইল নম্বর ভেরিফিকেশন';
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();
        $data['updated_at_otp'] = $user->updated_at;
        $data['mobile'] = $user->mobile_no;
        return view('mobile_first_registration.mobile_check')->with($data);
    }

    //resent otp
    public function registration_otp_resend($user_id){
        $otp = rand(1111, 9999);

        $update_otp = DB::table('users')
            ->where('id', '=', decrypt($user_id))
            ->update([
                'otp' => $otp,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($update_otp) {
            $user = User::where('id', decrypt($user_id))->first();

            $mobile = $user->mobile_no;

            $message = 'সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . ' ধন্যবাদ।';
            // $m = str_replace(' ', '%20', $message);

            send_sms($mobile, $message);

            return redirect()
                ->route('registration.citizen.mobile.check', ['user_id' => encrypt($user->id)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
    }

    //otp verify
    public function registration_otp_verify(Request $request)
    {
        $otp = $request->otp_1 . $request->otp_2 . $request->otp_3 . $request->otp_4;
        // return $otp;
   
        $result = User::where('otp', $otp)
            ->where('id', $request->user_id)
            ->first();
            
        // return $result;
        if (empty($result)) {
            return redirect()
                ->back()
                ->withErrors(['ওটিপি ভুল হয়েছে']);
        } else {
            return redirect()->route('reset.password.after.otp.verify', ['user_id' => encrypt($request->user_id)]);
        }
    }

    //reset password after otp verify
    public function reset_password_after_otp_verify($user_id){
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();
        

        if ($user->citizen_type_id == 1 || $user->citizen_type_id == 3) {
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ';
          
            return view('mobile_first_registration._registration_event_password')->with($data);
        } elseif ($user->citizen_type_id == 2) {
          
            $data['division'] = DB::table('division')->get();
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ এবং প্রতিষ্ঠান নির্বাচন';
            return view('mobile_first_registration._registration_event_password_with_office')->with($data);
        }
        
    }

    //password match for citizen
    public function password_match(Request $request){
        
        $request->validate(
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

        User::where('id', $request->user_id)->update([
            'password' => Hash::make($request->password),
            'is_verified_account' => 2,
        ]);
        return redirect()
            ->route('show_log_in_page', encrypt(1))
            ->with('success', 'পাসওয়ার্ড হালনাগাদ হয়েছে');
    }

    public function new_nid_verify_mobile_reg_first(Request $request, NIDVerificationRepository $nidVerificationRepository)
    {
        $fields_message = [
            'nid_number' => 'জাতীয় পরিচয় পত্র দিতে হবে',
            'dob_number' => 'জাতীয় পরিচয় পত্র অনুযায়ী জন্ম তারিখ দিতে হবে',
        ];

        $message = '';
        foreach ($fields_message as $key => $value) {
            if (empty($request->$key)) {
                $message .= $value . ' ,';
            }
        }
        if ($message != '') {
            return response()->json([
                'success' => 'error',
                'message' => $message,
            ]);
        }

        $dob_in_db = str_replace('/', '-', $request->dob_number);
        return $nidVerificationRepository->new_nid_verify_mobile_reg_first_api_call($request);
        
    }
    public function verify_account_mobile_reg_first(Request $request)
    {
        $fields_message = [
            'citizen_nid' => 'জাতীয় পরিচয় পত্র দিতে হবে',
            'name' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে নাম দিতে হবে',
            'father' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে পিতার নাম দিতে হবে',
            'mother' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে মাতার নাম দিতে হবে',
            'dob' => 'জাতীয় পরিচয় পত্র অনুযায়ী জন্ম তারিখ দিতে হবে',
            'citizen_gender' => 'লিঙ্গ দিতে হবে',
            'permanentAddress' => 'জাতীয় পরিচয় পত্র অনুযায়ী স্থায়ী ঠিকানা দিতে হবে',
            'presentAddress' => 'জাতীয় পরিচয় পত্র অনুযায়ী বর্তমান ঠিকানা দিতে হবে',
        ];
        $message = '';
        foreach ($fields_message as $key => $value) {
            if (empty($request->$key)) {
                $message .= $value . ' ,';
            }
        }

        $exits_user_by_nid = DB::table('users')
            ->where('citizen_nid', $request->citizen_nid)
            ->where('citizen_type_id', Auth::user()->citizen_type_id)
            ->first();
           
        if (!empty($exits_user_by_nid)) {
            $message .= 'জাতীয় পরিচয় পত্র ' . $request->citizen_nid . ' দিয়ে ইতিমধ্যে ' . $exits_user_by_nid->mobile_no . ' এর সাথে নিবন্ধিত করা হয়েছে';
        }

        if ($message != '') {
            return response()->json([
                'success' => 'error',
                'message' => $message,
            ]);
        }

        CitizenNIDVerifyRepository::verify_citizen_by_nid($request, Auth::user()->citizen_type_id);

        return response()->json([
            'success' => 'success',
            'message' => 'সফলভাবে আপনার প্রোফাইল সত্যায়িত হয়েছে',
        ]);
    }

    // password match for organization
    public function password_match_organization(Request $request)
    {
        
       
        $request->validate(
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
       
        
        if ($request->office_id == 'OTHERS') {
            $office['office_name_bn'] = $request->office_name_bn;
            $office['office_name_en'] = $request->office_name_en;
            $office['division_id'] = $request->division_id;
            $office['district_id'] = $request->district_id;
            $office['upazila_id'] = $request->upazila_id;
            $office['organization_type'] = $request->organization_type;
            $office['organization_physical_address'] = $request->organization_physical_address;
            $office['organization_routing_id'] = $request->organization_id;
            $office['is_organization'] = 1;
            $office['level'] = 4;
           
            $office_id = DB::table('office')->insertGetId($office);
        } else {
            $office_id = $request->office_id;
        }
    
        $cookieData = $request->cookie('Gmail_info');
        if (!empty($cookieData) && isset($cookieData)) {
            $password = 'google_sso_login_password_14789_gcc_ourtm#P52s@ap$V';
        } else {
            $password = $request->password;
        }
       
        $organization_deligate = [
            'designation' => $request->designation,
            'password' => Hash::make($password),
            'is_verified_account' => 2,
            'office_id' => $office_id,
            'organization_id' => $request->organization_id,
            'organization_employee_id' => $request->organization_employee_id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        User::where('id', $request->user_id)->update($organization_deligate);

        if (!empty($cookieData) && isset($cookieData)) {
            if (Auth::loginUsingId($request->user_id)) {
                return redirect('/dashboard');
            }
        }
       
        return redirect()
            ->route('show_log_in_page', encrypt(2))
            ->with('success', 'পাসওয়ার্ড ও প্রাতিষ্ঠানিক হালনাগাদ হয়েছে');
    }

}
