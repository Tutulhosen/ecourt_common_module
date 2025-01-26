<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\IsEnglish;










class RegistrationController extends Controller
{
    public function forget_password($id)

    {

        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'নাগরিক পাসওয়ার্ড রিসেট ফর্ম';
        $data['citizen_type_id'] = $id;

        return view('citizen.password_reset_form')->with($data);
    }


    public function user_check_forget_password(Request $request)
    {

        // dd($request->citizen_type_id);

        $request->validate(
            [
                'mobile_number' => 'required',
            ],
            [
                'mobile_number.required' => 'মোবাইল নং লিখুন',
            ],
        );

        $user = DB::table('users')
            ->where('mobile_no', '=', $request->mobile_number)
            ->where('citizen_type_id', '=', $request->citizen_type_id)
            ->first();
        // dd($user);
        if (!empty($user)) {
            $otp = rand(1111, 9999);

            $update_otp = DB::table('users')
                ->where('id', '=', $user->id)
                ->update([
                    'otp' => $otp,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            if ($update_otp) {

                $mobile = $user->mobile_no;

                $message = 'পাসওয়ার্ড রিসেট করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . ' ধন্যবাদ।';
                // $m = str_replace(' ', '%20', $message);

                $this->send_sms($mobile,$message);
                return redirect()
                    ->route('registration.citizen.mobile.check', ['user_id' => encrypt($user->id)])
                    ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
            }
        } else {
            return redirect()
                ->back()
                ->with('Errormessage', 'আপনার তথ্য পাওয়া যায়নি');
        }
    }

    public function registration_otp_check(Request $request, $user_id)
    {

        $cookieData = $request->cookie('Gmail_info');
        if (!empty($cookieData) && isset($cookieData)) {
            $data['gmail'] = $cookieData;
        }

        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'নাগরিক মোবাইল নম্বর ভেরিফিকেশন';
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();
        $data['updated_at_otp'] = $user->updated_at;
        $data['mobile'] = $user->mobile_no;
        return view('mobile_first_registration.mobile_check')->with($data);
    }

    public function registration_otp_resend($user_id)
    {
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

            $this->send_sms($mobile, $message);

            return redirect()
                ->route('registration.citizen.mobile.check', ['user_id' => encrypt($user->id)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
    }

    public function registration_otp_verify(Request $request)
    {
        $otp = $request->otp_1 . $request->otp_2 . $request->otp_3 . $request->otp_4;
        // dd($otp);
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
            return redirect()->route('reset.password.after.otp', ['user_id' => encrypt($request->user_id)]);
        }
    }

    public function reset_password_after_otp(Request $request, $user_id)
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();
        $cookieData = $request->cookie('Gmail_info');

       
        if (!empty($cookieData) && isset($cookieData)) {
            if ($user->citizen_type_id == 1 || $user->citizen_type_id == 3) {
                User::where('id', $request->user_id)->update(['password' => 'google_sso_login_password_14789_gcc_ourtm#P52s@ap$V']);
                if (Auth::loginUsingId($request->user_id)) {
                    return redirect('/dashboard');
                }
            } else {
                $data['gmail'] = $cookieData;
                $data['division'] = DB::table('division')->get();
                $data['page_title'] = 'প্রতিষ্ঠান নির্বাচন';
                return view('mobile_first_registration._registration_event_password_with_office')->with($data);
            }
        }

        if ($user->citizen_type_id == 1 || $user->citizen_type_id == 3) {
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ';
           
            return view('mobile_first_registration._registration_event_password')->with($data);
        } elseif ($user->citizen_type_id == 2 && !empty($user->office_id)) {
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ';
          
            return view('mobile_first_registration._registration_event_password')->with($data);
        } elseif ($user->citizen_type_id == 2) {
          
            $data['division'] = DB::table('division')->get();
            $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ এবং প্রতিষ্ঠান নির্বাচন';
            return view('mobile_first_registration._registration_event_password_with_office')->with($data);
        }
    }

    public function mobile_first_password_match(Request $request)
    {
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

        User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
        return redirect()
            ->route('applicant.login.registration')
            ->with('success', 'পাসওয়ার্ড হালনাগাদ হয়েছে');
    }

    public function mobile_first_password_match_organization(Request $request)
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
            ->route('applicant.login.registration')
            ->with('success', 'পাসওয়ার্ড ও প্রাতিষ্ঠানিক হালনাগাদ হয়েছে');
    }
    public function send_sms($to, $message)
    {
        $curl = curl_init();
        $new_message = curl_escape($curl, $message);
        $newto='88'.$to;
        $url = 'http://103.69.149.50/api/v2/SendSMS?SenderId=8809617612638&Is_Unicode=true&ClientId=ec63aede-1c7e-4a5a-a1ad-36b72ab30817&ApiKey=AeHZPUEZXIILtxg0VEaGjsK%2BuPNlzhCDW0VuFRmcchs%3D&Message=' . $new_message . '&MobileNumbers=' . $newto;
        // dd($url);
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
    }

    public function get_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://si.mysoftheaven.com/api/v1/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => 'a2i@gmail.com', 'password' => 'mhl!a2i@2041', 'api_secret' => '2qwertyudfcvgbhn'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}