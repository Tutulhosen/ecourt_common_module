<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\TokenVerificationTrait;
use Illuminate\Support\Facades\Session;

class LandingPageController extends Controller
{
    use TokenVerificationTrait;


    // ! add data geo thanas table
    public function addData()
    {
        $allThanas = [];
        $fromTo = [];
        for ($districtId = 61; $districtId <= 64; $districtId++) {
            $url = "https://apigw-stage.doptor.gov.bd/api/v1/thana?division=7&district={$districtId}";
            $res = makeDemoGetCurlRequest($url);
            $allThanas = $res;
            $districtUrl  = "https://apigw-stage.doptor.gov.bd/api/v1/district?id={$districtId}";
            $disRes = makeDemoGetCurlRequest($districtUrl);
            $disResName = $disRes[0]->name;
            $mainDistrictInfo = DB::table('district')->where('district_name_en', '=', $disResName)->first();
            foreach ($allThanas as  $thana) {
                $transformedData = [
                    'geo_division_id' => $mainDistrictInfo->division_id,
                    'geo_district_id' => $mainDistrictInfo->id,
                    'division_bbs_code' => $mainDistrictInfo->division_bbs_code,
                    'district_bbs_code' => $mainDistrictInfo->district_bbs_code,
                    'thana_name_eng' => $thana->name,
                    'thana_name_bng' => $thana->nameBn,
                ];
                DB::table('geo_thanas')->insert($transformedData);
            }
        }

        dd('all thana inserted for division ');
    }

    public function index()
    {
        // $auth_data= DB::table('oauth_clients')->get();
        // dd($auth_data);
        $data['divisions'] = DB::table('division')->get();
        $data['mc_total_cases'] = $this->total_case_count('mc_case');
        $data['gcc_total_cases'] = $this->total_case_count('gcc_case');
        $data['emc_total_cases'] = $this->total_case_count('emc_case');
        // dd($data);

        //golpos

        $data['sottogolpos'] = DB::table('sottogolpo')->get();
        return view('landing.index')->with($data);
    }
    public function allGolpos()
    {
        $data['sottogolpos'] = DB::table('sottogolpo')->get();
        return view('landing.allGolpos')->with($data);
    }
    public function singleGolpo($id)
    {
        $data['golpo'] = DB::table('sottogolpo')->where('id', $id)->first();
        return view('landing.singleGolpo')->with($data);
    }

    public function total_case_count($court)
    {
        
        $token = $this->verifySiModuleToken('WEB');
        $data['court'] = $court;
        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/case/count/for/all/court';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);

            if (!empty($res)) {
                if ($res['success']==true) {
                    if ($court=='mc_case') {
                        $result = $res['data'];
                        return $result;
                    }
    
                    if ($court=='gcc_case') {
                        $result = $res['data'];
                        return $result;
                    }
                    if ($court=='emc_case') {
                        $result = $res['data'];
                        return $result;
                    }
                    
           
                    
                }
            } else {
                $result = 0;
                return $result;
            }
            
            
        }
    }


    // !TEMPORARY
    // public function getDependentDistrictForDoptor($id)
    // {
    //     $subcategories = DB::table("district")->where("division_id", $id)->pluck("district_name_bn", "id");
    //     return json_encode($subcategories);
    // }

    // public function getDependentUpazilaForDoptor($id)
    // {
    //     $subcategories = DB::table("geo_upazilas")->where("geo_district_id", $id)->pluck("upazila_name_bng", "id");
    //     return json_encode($subcategories);
    // }
    //!TEMPORARY

    //doptor court select page show
    public function doptor_court_select()
    {
        return view('gcc_login_templete');
    }
    // 3 type of citizen 
    public function show_log_in_page($type_id)
    {
        $data['type_id'] = decrypt($type_id);

        return view('loginPage')->with($data);
    }

    //citizen login User
    public function logined_in(Request $request)
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

                if ($user->role_id == 2) {
                    $id = $request->route('id');

                    $user_court_info = DB::table('doptor_user_access_info')
                        ->where('user_id', Auth::user()->id)
                        ->where('court_type_id', $id)
                        ->select('court_type_id', 'role_id')
                        ->first();
                    if (!empty($user_court_info)) {
                        $user_court_info = $user_court_info->court_type_id;
                    } else {
                        $user_court_info = null;
                    }


                    // Store court_type_id in session
                    Session::put('court_type_id', $user_court_info);
                    return response()->json(['success' => 'Successfully logged in!']);
                } else {

                    return response()->json(['success' => 'Successfully logged in!']);
                }
            }
        }



        return response()->json([
            'error' => 'Please Enter Valid Credential!',
            'nothi_msg' => 'সঠিক ইমেইল, মোবাইল নং অথবা পাসওয়ার্ড প্রদান করুন ',

        ]);
    }

    // admin 
    public function show_admin_log_in_page()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('adminLogin');
    }

    //citizen login User
    public function admin_logined_in(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]) || Auth::attempt(['username' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            if ($user->role_id == 2) {
                $id = $request->route('id');

                $user_court_info = DB::table('doptor_user_access_info')
                    ->where('user_id', Auth::user()->id)
                    ->where('court_type_id', $id)
                    ->select('court_type_id', 'role_id')
                    ->first();
                if (!empty($user_court_info)) {
                    $user_court_info = $user_court_info->court_type_id;
                } else {
                    $user_court_info = null;
                }


                // Store court_type_id in session
                Session::put('court_type_id', $user_court_info);
                return response()->json(['success' => 'Successfully logged in!']);
            } elseif ($user->role_id == 8) {
                $id = $request->route('id');

                $user_court_info = DB::table('doptor_user_access_info')
                    ->where('user_id', Auth::user()->id)
                    ->where('court_type_id', $id)
                    ->select('court_type_id', 'role_id')
                    ->first();

                if (!empty($user_court_info)) {
                    $user_court_info = $user_court_info->court_type_id;
                } else {
                    $user_court_info = null;
                }

                // dd($user_court_info );
                // Store court_type_id in session
                Session::put('court_type_id', $user_court_info);
                return response()->json(['success' => 'Successfully logged in!']);
            } elseif ($user->role_id == 25) {
                $id = $request->route('id');

                $user_court_info = DB::table('doptor_user_access_info')
                    ->where('user_id', Auth::user()->id)
                    ->where('court_type_id', $id)
                    ->select('court_type_id', 'role_id')
                    ->first();

                if (!empty($user_court_info)) {
                    $user_court_info = $user_court_info->court_type_id;
                } else {
                    $user_court_info = null;
                }

                // dd($user_court_info );
                // Store court_type_id in session
                Session::put('court_type_id', $user_court_info);
                return response()->json(['success' => 'Successfully logged in!']);
            } else {

                return response()->json([
                    'error' => 'Please Enter Valid Credential!',
                    'nothi_msg' => 'সঠিক ইমেইল, মোবাইল নং অথবা পাসওয়ার্ড প্রদান করুন ',

                ]);
            }
        } else {
            return response()->json([
                'error' => 'Please Enter Valid Credential!',
                'nothi_msg' => 'সঠিক ইমেইল, মোবাইল নং অথবা পাসওয়ার্ড প্রদান করুন ',

            ]);
        }
    }


    //logout user
    public function logout()
    {
        Session::forget('court_type_id');
        if (Auth::check()) {
            if (!empty(globalUserInfo()->is_cdap_user) &&  globalUserInfo()->is_cdap_user == 1) {

                CdapUserManagementController::logout();
            }
            if (!empty(globalUserInfo()->doptor_user_flag) &&  globalUserInfo()->doptor_user_flag == 1) {
                Session::forget('court_type_id');
                Auth::logout();
                $callbackurl = url('/');
                $zoom_join_url = DOPTOR_ENDPOINT() . '/logout?' . 'referer=' . base64_encode($callbackurl);
                return redirect()->away($zoom_join_url);
            }
            Auth::logout();
        } elseif (Auth::guard('parent_office')->check()) {
            Auth::guard('parent_office')->logout();
        }


        return redirect()->route('home.index');
    }


    //custom logout user
    public function custom_logout()
    {
        Session::forget('court_type_id');
        if (Auth::check()) {
            if (!empty(globalUserInfo()->is_cdap_user) &&  globalUserInfo()->is_cdap_user == 1) {

                CdapUserManagementController::logout();
            }
            if (!empty(globalUserInfo()->doptor_user_flag) &&  globalUserInfo()->doptor_user_flag == 1) {
                Session::forget('court_type_id');
                Auth::logout();
                $callbackurl = url('/');
                $zoom_join_url = DOPTOR_ENDPOINT() . '/logout?' . 'referer=' . base64_encode($callbackurl);
                return redirect()->away($zoom_join_url);
            }

            Auth::logout();
        } elseif (Auth::guard('parent_office')->check()) {
            Auth::guard('parent_office')->logout();
        }
        return redirect()->route('home.index');
    }


    //redirect to selected court
    public function redirect_select_court($id)
    {

        // Get the current session data
        $session = session()->all();

        // Check if 'url' is missing and session hasn't been regenerated yet
        // if (empty($session['url']) && !session()->has('session_regenerated')) {
        //     // Regenerate session to avoid logout and reset session state
        //     session()->invalidate();
        //     session()->regenerate();

        //     // Set a flag in the session to indicate that the session has been regenerated
        //     session()->put('session_regenerated', true);

        //     // Redirect back to the same function after regenerating the session
        //     return redirect()->route('redirect.select.court', ['id' => $id]);
        // }
        // dd($session);
        if ($id == 1) {
            $check_court = DB::table('doptor_user_access_info')
                ->where('user_id', globalUserInfo()->id)
                ->where('court_type_id', 1)
                ->first();

            if ($_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
                $redirect_uri= 'http://localhost:8888/callback';
            } else {
                $redirect_uri= 'http://mobile-ecourt.mysoftheaven.com/callback';
            }

            if (!empty($check_court)) {

                if ($check_court->court_id != 0) {
                    // $zoom_join_url = getMcBaseUrl() . '/getLogin?referer=' . $id;

                    // return redirect()->away($zoom_join_url);
                    $state = Str::random(40);
                    // $request->session()->put("state", $state);
            
                    // Build the query string with the correct state parameter
                    $query = http_build_query([
                        "client_id" => 18,
                        "redirect_uri" => $redirect_uri,
                        "response_type" => "code",
                        "scope" => "view-user",
                        "state" =>$state 
                    ]);
             
                    // Redirect to the OAuth authorization endpoint
                  return redirect("oauth/authorize?".$query);
                } else {
                    return redirect()->back()->with('error', 'দুঃখিত, মোবাইল কোর্ট পরিচালনায় আপনি কোনো রোলে নিযুক্ত নন ।');
                }
            } else {
                return redirect()->back()->with('error', 'দুঃখিত, মোবাইল কোর্ট পরিচালনায় আপনি কোনো রোলে নিযুক্ত নন ।');
            }
        }
        //gcc court
        if ($id == 2) {
            $check_court = DB::table('doptor_user_access_info')
                ->where('user_id', globalUserInfo()->id)
                ->where('court_type_id', 2)
                ->first();
            if ($_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
                $redirect_uri= 'http://localhost:7878/callback';
            } else {
                $redirect_uri= 'http://gcc-ecourt.mysoftheaven.com/callback';
            }
            if (!empty($check_court)) {
                if ($check_court->court_id != 0) {
                    // $zoom_join_url = getGccBaseUrl() . '/getLogin?referer=' . $id;
                    // return redirect()->away($zoom_join_url);
                    $state = Str::random(40);
                    // $request->session()->put("state", $state);
            
                    // Build the query string with the correct state parameter
                    $query = http_build_query([
                        "client_id" => 8,
                        "redirect_uri" => $redirect_uri,
                        "response_type" => "code",
                        "scope" => "view-user",
                        "state" =>$state 
                    ]);
                    // Redirect to the OAuth authorization endpoint
                    return redirect("oauth/authorize?".$query);

                } else {
                    return redirect()->back()->with('error', 'দুঃখিত, জেনারেল সার্টিফিকেট কোর্ট পরিচালনায় আপনি কোনো রোলে নিযুক্ত নন ।');
                }
            } else {
                return redirect()->back()->with('error', 'দুঃখিত, জেনারেল সার্টিফিকেট কোর্ট পরিচালনায় আপনি কোনো রোলে নিযুক্ত নন ।');
            }
        }

        //emc court
        if ($id == 3) {
            $check_court = DB::table('doptor_user_access_info')
                ->where('user_id', globalUserInfo()->id)
                ->where('court_type_id', 3)
                ->first();
            if ($_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
                $redirect_uri= 'http://localhost:8787/callback';
            } else {
                $redirect_uri= 'http://emc-ecourt.mysoftheaven.com/callback';
            }
            if (!empty($check_court)) {
                if ($check_court->court_id != 0) {
                    // $zoom_join_url = getEmcBaseUrl() . '/getLogin?referer=' . $id;
                    // return redirect()->away($zoom_join_url);
                    $state = Str::random(40);
                    // $request->session()->put("state", $state);
            
                    // Build the query string with the correct state parameter
                    $query = http_build_query([
                        "client_id" => 17,
                        "redirect_uri" => $redirect_uri,
                        "response_type" => "code",
                        "scope" => "view-user",
                        "state" =>$state 
                    ]);

                    // Redirect to the OAuth authorization endpoint
                    return redirect("oauth/authorize?".$query);
                } else {
                    return redirect()->back()->with('error', 'দুঃখিত, এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট পরিচালনায় আপনি কোনো রোলে নিযুক্ত নন ।');
                }
            } else {
                return redirect()->back()->with('error', 'দুঃখিত, এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট পরিচালনায় আপনি কোনো রোলে নিযুক্ত নন ।');
            }
        }
    }
}
