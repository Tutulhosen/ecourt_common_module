<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    use TokenVerificationTrait;
    //show common dashboard page
    public function index(Request $request)
    {

        // dd(Auth::user());
        $court_type_id=Session::get('court_type_id');
        if ($court_type_id==4) {
            $user=Auth::guard('parent_office')->user();
            $auth_user = [
                'parent_id' => $user->id,

            ];

            $token = $this->verifySiModuleToken('WEB');

            if ($token) {
                $url = getapiManagerBaseUrl() . '/api/v1/gcc/dashboard/parent/office';
                $method = 'POST';
                $bodyData = json_encode($auth_user);
                $token = $token;
                $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
                $res = json_decode($response, true);

                // dd($response);
                if ($res['success']) {
                    $result = $res['data'];

                    $data['pending_case'] = $result['pending_case']['total_count'];;
                    $data['total_case'] = $result['total_case']['total_count'];
                    $data['running_case'] = $result['running_case']['total_count'];;
                    $data['completed_case'] = $result['completed_case']['total_count'];;
                }
            }

            $data['page_title'] = 'কেন্দ্রীয় শাখার ড্যাশবোর্ড';
            return view('dashboard.parent_organization')->with($data);
        } else {
            $roleID = Auth::user()->role_id;
            // dd($roleID);
            $id = $request->route('id');

            $user_court_info = DB::table('doptor_user_access_info')->where('user_id', Auth::user()->id)->where('court_type_id', $id)->select('court_type_id', 'role_id')->first();

            // dd($data['court_type_id']);
            if (!empty($roleID)) {

                if ($roleID == 2) {
                    // Superadmin dashboard

                    // Counter
                    $data['total_case'] = 50;
                    $data['running_case'] = 40;
                    $data['completed_case'] = 5;
                    $data['pending_case'] = 5;
                    $data['rejected_case'] = 2;
                    $data['postpond_case'] = 2;
                    $data['draft_case'] = 1;

                    $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
                    $data['total_user'] = DB::table('users')->count();
                    $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
                    // Drildown Statistics
                    $division_list = DB::table('division')
                        ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
                        ->get();


                    $divisiondata = array();
                    $districtdata = array();
                    // $dis_data=array();
                    $upazilatdata = array();

                    // for gcc dashboard
                    $get_drildown_case_count = $this->get_drildown_case_count();
                    $data['divisiondata'] = $get_drildown_case_count['divisiondata'];
                    $data['dis_upa_data'] = $get_drildown_case_count['dis_upa_data'];

                    //for emc dashboard
                    $get_drildown_case_count_emc = $this->get_drildown_case_count_emc();
                    $data['emcdivisiondata'] = $get_drildown_case_count_emc['divisiondata'];
                    $data['emc_dis_upa_data'] = $get_drildown_case_count_emc['dis_upa_data'];
                    // dd($data);
                    $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
                    //  dd($data['divisions']);


                    #----------------------------------  
                    #mobile court dashboard information 
                    #-----------------------------------

                    $userinfo = globalUserInfo();
                    $office_id = $userinfo->office_id;
                    $officeinfo = DB::table('office')->where('id', $office_id)->first();
                    $data['roleID']=$roleID;
                    $division_id = $officeinfo->division_id;
                    $district_id = $officeinfo->district_id;
                    $data["zillaId"] =$district_id;
                    
                    $data["upazila"] =[]; 
                    $data['zilla']=[];
                    $data['division'] = DB::table('division')->get();
                    
                 
                    $data['page_title'] = 'সুপার অ্যাডমিন ড্যাশবোর্ড';
                    return view('dashboard.monitoring_admin')->with($data);
                } elseif ($roleID == 8) {

                    // Counter
                    $data['total_case'] = 50;
                    $data['running_case'] = 40;
                    $data['completed_case'] = 5;
                    $data['pending_case'] = 5;
                    $data['rejected_case'] = 2;
                    $data['postpond_case'] = 2;
                    $data['draft_case'] = 1;

                    $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
                    $data['total_user'] = DB::table('users')->count();
                    $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
                    // Drildown Statistics
                    $division_list = DB::table('division')
                        ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
                        ->get();


                    $divisiondata = array();
                    $districtdata = array();
                    // $dis_data=array();
                    $upazilatdata = array();

                    // for gcc dashboard
                    $get_drildown_case_count = $this->get_drildown_case_count();
                    $data['divisiondata'] = $get_drildown_case_count['divisiondata'];
                    $data['dis_upa_data'] = $get_drildown_case_count['dis_upa_data'];

                    //for emc dashboard
                    $get_drildown_case_count_emc = $this->get_drildown_case_count_emc();
                    $data['emcdivisiondata'] = $get_drildown_case_count_emc['divisiondata'];
                    $data['emc_dis_upa_data'] = $get_drildown_case_count_emc['dis_upa_data'];

                    $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
                    
                    // mobile court 
                    $userinfo = globalUserInfo();
                    $office_id = $userinfo->office_id;
                    $officeinfo = DB::table('office')->where('id', $office_id)->first();
                    $data['roleID']=$roleID;
                    $division_id = $officeinfo->division_id;
                    $district_id = $officeinfo->district_id;
                    $data["zillaId"] =$district_id;
                    
                    $data['zilla']=[];
                    $data["upazila"] =[]; 
                    $data['division'] = DB::table('division')->get();

                    // View
                    $data['page_title'] = 'সুপার অ্যাডমিন ড্যাশবোর্ড';
                    return view('dashboard.monitoring_admin')->with($data);
                } elseif ($roleID == 25) {

                    // Counter
                    $data['total_case'] = 50;
                    $data['running_case'] = 40;
                    $data['completed_case'] = 5;
                    $data['pending_case'] = 5;
                    $data['rejected_case'] = 2;
                    $data['postpond_case'] = 2;
                    $data['draft_case'] = 1;

                    $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
                    $data['total_user'] = DB::table('users')->count();
                    $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
                    // Drildown Statistics
                    $division_list = DB::table('division')
                        ->select('division.id', 'division.division_name_bn', 'division.division_name_en', 'division.division_bbs_code')
                        ->get();


                    $divisiondata = array();
                    $districtdata = array();
                    // $dis_data=array();
                    $upazilatdata = array();

                    // for gcc dashboard
                    $get_drildown_case_count = $this->get_drildown_case_count();
                    $data['divisiondata'] = $get_drildown_case_count['divisiondata'];
                    $data['dis_upa_data'] = $get_drildown_case_count['dis_upa_data'];

                    //for emc dashboard
                    $get_drildown_case_count_emc = $this->get_drildown_case_count_emc();
                    $data['emcdivisiondata'] = $get_drildown_case_count_emc['divisiondata'];
                    $data['emc_dis_upa_data'] = $get_drildown_case_count_emc['dis_upa_data'];

                    // dd($result);
                    // $data['divisiondata'] = $divisiondata;
                    // dd($data['division_arr']);
                    //  echo 'Hello'; exit;
                    $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
                    //  dd($data['divisions']);

                    // View
                    $data['page_title'] = 'সুপার অ্যাডমিন ড্যাশবোর্ড';
                    return view('dashboard.monitoring_admin')->with($data);
                } elseif ($roleID == 34) {
                    $user = globalUserInfo();
                    
                    $data['total_case'] = 0;

                    $data['pending_case'] = 0;

                    $data['running_case'] = 0;

                    $data['completed_case'] = 0;

                    $data['rejected_case'] = 0;

                    $data['postpond_case'] = 0;

                    $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
                    $data['total_user'] = DB::table('users')->count();
                    $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
                    $data['total_mouja'] = 0;
                    $data['total_ct'] = 0;
                    $data['total_sf_count'] = 0;
                    $data['pending_case_list'] = 0;

                    $data['trial_date_list'] = 0;

                    $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

                    // $data['cases'] = DB::table('case_register')
                    //     ->select('case_register.*')
                    //     ->get();

                    // Drildown Statistics
                    $division_list = DB::table('division')
                        ->select('division.id', 'division.division_name_bn', 'division.division_name_en')
                        ->get();
                    $divisiondata = array();
                    $districtdata = array();
                    // $dis_data=array();
                    $upazilatdata = array();

                    // Division List
                    // dd($division_list);
                    $get_drildown_case_count = $this->get_drildown_case_count();
                    $data['divisiondata'] = $get_drildown_case_count['divisiondata'];
                    $data['dis_upa_data'] = $get_drildown_case_count['dis_upa_data'];

                    //for emc dashboard
                    $get_drildown_case_count_emc = $this->get_drildown_case_count_emc();
                    $data['emcdivisiondata'] = $get_drildown_case_count_emc['divisiondata'];
                    $data['emc_dis_upa_data'] = $get_drildown_case_count_emc['dis_upa_data'];


                    $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', user_office_info()->division_id)->get();



                    // mobile court 
                    $userinfo = globalUserInfo();
                    $office_id = $userinfo->office_id;
                    $officeinfo = DB::table('office')->where('id', $office_id)->first();
                    $data['roleID']=$roleID;
                    $division_id = $officeinfo->division_id;
                    $district_id = $officeinfo->district_id;
                    $data["zillaId"] =$district_id;
                    
                    $data["upazila"] =[]; 
                    $data['zilla']=DB::table('district')->where('division_id',$division_id)->get();
                    // dd($data['zilla']);

                    $data['page_title'] = 'আদালত';
                    // dd($data);
                    return view('dashboard.main_div_com')->with($data);
                }
            } else {
                if (Auth::user()->doptor_user_active == 1) {

                    if ($user_court_info->court_type_id == 3) {
                        // dd($user_court_info);
                        if ($user_court_info->role_id == 27) {

                            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট';
                            return view('dashboard.inc.emc.pages.admin_em')->with($data);
                        }
                        if ($user_court_info->role_id == 28) {

                            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট';
                            return view('dashboard.inc.emc.pages.admin_em_pasker')->with($data);
                        }
                        if ($user_court_info->role_id == 37) {

                            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট';
                            return view('dashboard.inc.emc.pages.admin_dm')->with($data);
                        }
                        if ($user_court_info->role_id == 38) {

                            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট';
                            return view('dashboard.inc.emc.pages.admin_adm_pasker')->with($data);
                        }
                        if ($user_court_info->role_id == 39) {

                            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট';
                            return view('dashboard.inc.emc.pages.admin_adm_pasker')->with($data);
                        }
                    }

                    if ($user_court_info->court_type_id == 2) {
                        // dd($user_court_info);
                        // $callbackurl =  'getLogin' . $id;
                        // $zoom_join_url = 'http://127.0.0.1:7878/getLogin/?'. 'referer=' . $user_court_info->court_type_id ;
                        // dd($zoom_join_url);

                        // return redirect()->away($zoom_join_url);
                        if ($user_court_info->role_id == 6) {

                            $data['page_title'] = 'জেনারেল সার্টিফিকেট কোর্ট';
                            return view('dashboard.inc.gcc.pages.admin_dm')->with($data);
                        }
                        if ($user_court_info->role_id == 7) {

                            $data['page_title'] = 'জেনারেল সার্টিফিকেট কোর্ট';
                            return view('dashboard.inc.gcc.pages.admin_adm')->with($data);
                        }
                        if ($user_court_info->role_id == 27) {

                            $data['page_title'] = 'জেনারেল সার্টিফিকেট কোর্ট';
                            return view('dashboard.inc.gcc.pages.admin_gco')->with($data);
                        }
                        if ($user_court_info->role_id == 28) {

                            $data['page_title'] = 'জেনারেল সার্টিফিকেট কোর্ট';
                            return view('dashboard.inc.gcc.pages.admin_asst_gco')->with($data);
                        }
                    }

                    if ($user_court_info->court_type_id == 1) {

                        Session::put('court_type_id', 1);

                        if ($user_court_info->role_id == 27) {

                            $data['page_title'] = 'মোবাইল কোর্ট';
                            return view('dashboard.inc.mc.pages.admin_acgm')->with($data);
                        }
                        if ($user_court_info->role_id == 26) {

                            $data['page_title'] = 'মোবাইল কোর্ট';
                            return view('dashboard.inc.mc.pages.admin_em')->with($data);
                        }
                        if ($user_court_info->role_id == 25) {

                            $data['page_title'] = 'মোবাইল কোর্ট';
                            return view('dashboard.inc.mc.pages.admin_prosecutor')->with($data);
                        }


                        if ($user_court_info->role_id == 37) {

                            $data['page_title'] = 'মোবাইল কোর্ট';
                            return view('dashboard.inc.mc.pages.admin_dm')->with($data);
                        }
                        if ($user_court_info->role_id == 38) {

                            $data['page_title'] = 'মোবাইল কোর্ট';
                            return view('dashboard.inc.mc.pages.admin_adm')->with($data);
                        }
                    }
                } elseif (Auth::user()->doptor_user_active == 0 && Auth::user()->is_citizen == 1 && Auth::user()->citizen_type_id == 1) {

                    if (globalUserInfo()->is_verified_account == 2) {
                        $data['page_title'] = 'নাগরিকের ড্যাশবোর্ড';
                        return view('mobile_first_registration.non_verified_account')->with($data);
                    }
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

                    //get data from emc court 
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


                    //get data from gcc court
                    $jsonData = json_encode($auth_user);
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => getapiManagerBaseUrl() . '/api/gcc-citizen-dashboard-data',
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
                        $data['pending_case_gcc_citizen'] = $gcc_res->total_pending_case_count_gcc_citizen->total_count;
                        $data['total_case_gcc_citizen'] = $gcc_res->total_case_count_gcc_citizen->total_count;
                        $data['running_case_gcc_citizen'] = $gcc_res->total_running_case_count_gcc_citizen->total_count;
                        $data['completed_case_gcc_citizen'] = $gcc_res->total_completed_case_count_gcc_citizen->total_count;
                        $data['certify_copy_fee_count_gcc_citizen'] = $gcc_res->certify_copy_fee_count_gcc_citizen->total_count;
                        $data['hearing_count_gcc_citizen'] = $gcc_res->hearing_count_gcc_citizen->total_count;
                        $data['cancel_certify_copy'] = $gcc_res->cancel_certify_copy->total_count;
                        // dd($data['cancel_certify_copy']);
                        $data['pending_appeal_case_gcc_citizen'] = $gcc_res->total_pending_appeal_case_count_gcc_citizen->total_count;
                        $data['total_appeal_case_gcc_citizen'] = $gcc_res->total_appeal_case_count_gcc_citizen->total_count;
                        $data['running_appeal_case_gcc_citizen'] = $gcc_res->total_running_appeal_case_count_gcc_citizen->total_count;
                        $data['completed_appeal_case_gcc_citizen'] = $gcc_res->total_completed_appeal_case_count_gcc_citizen->total_count;

                        // $data['payment_notice'] = (!empty($res->payment_notice)?$res->payment_notice:"");
                        $data['appeal'] = (!empty($gcc_res->appeal)?$gcc_res->appeal:"");
                        // $data['appeal'] = null;
                    } else {
                        $data['total_case_gcc_citizen'] = 'server error';
                        $data['running_case_gcc_citizen'] = 'server error';
                        $data['pending_case_gcc_citizen'] = 'server error';
                        $data['completed_case_gcc_citizen'] = 'server error';
                        // $data['total_appeal_case'] = 'server error';
                        // $data['running_appeal_case'] = 'server error';
                        // $data['pending_appeal_case'] = 'server error';
                        // $data['completed_appeal_case'] = 'server error';
                        $data['appeal'] = null;
                    }

                    $data['page_title'] = 'নাগরিকের ড্যাশবোর্ড';

                    // dd($data['certify_copy_fee_count_gcc_citizen']);
                    return view('dashboard.citizen')->with($data);
                } elseif (Auth::user()->doptor_user_active == 0 && Auth::user()->is_citizen == 1 && Auth::user()->citizen_type_id == 2) {


                    if (globalUserInfo()->is_verified_account == 2) {
                        $data['page_title'] = 'প্রাতিষ্ঠানিক প্রতিনিধি ড্যাশবোর্ড';
                        return view('mobile_first_registration.non_verified_account')->with($data);
                    }
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
                        CURLOPT_URL => getapiManagerBaseUrl() . '/api/common-module-login',
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

                        $data['payment_notice'] = (!empty($res->payment_notice)?$res->payment_notice:"");
                        $data['appeal'] = (!empty($res->appeal)?$res->appeal:"");
                        // $data['appeal'] = null;
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
                    // dd($data);
                    $data['page_title'] = 'প্রাতিষ্ঠানিক প্রতিনিধি ড্যাশবোর্ড';
                    return view('dashboard.org_rep')->with($data);
                } elseif (Auth::user()->doptor_user_active == 0 && Auth::user()->is_citizen == 1 && Auth::user()->citizen_type_id == 3) {

                    if (globalUserInfo()->is_verified_account == 2) {
                        $data['page_title'] = 'আইনজীবী ড্যাশবোর্ড';
                        return view('mobile_first_registration.non_verified_account')->with($data);
                    }

                    // $total_running_case_count_defaulter = $this->total_running_case_count_defaulter();
                    // $total_case_count_defaulter = $this->total_case_count_defaulter();
                    // $total_pending_case_count_defaulter = $this->total_pending_case_count_defaulter();
                    // $total_completed_case_count_defaulter = $this->total_completed_case_count_defaulter();

                    // $data['total_case'] = $total_case_count_defaulter['total_count'];
                    // $data['running_case'] = $total_running_case_count_defaulter['total_count'];
                    // $data['pending_case'] = $total_pending_case_count_defaulter['total_count'];
                    // $data['completed_case'] = $total_completed_case_count_defaulter['total_count'];

                    // $appeal = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case_count_defaulter['appeal_id_array'])->limit(10)->get();

                    // if ($appeal != null || $appeal != '') {
                    //     foreach ($appeal as $key => $value) {
                    //         $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                    //         $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
                    //         if (isset($citizen_info) && !empty($citizen_info)) {
                    //             $citizen_info = $citizen_info;
                    //         } else {
                    //             $citizen_info = null;
                    //         }
                    //         if (isset($notes) && !empty($notes)) {
                    //             $notes = $notes;
                    //         } else {
                    //             $notes = null;
                    //         }

                    //         $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    //         $data['appeal'][$key]['notes'] = $notes;
                    //         // $data["notes"] = $value->appealNotes;
                    //     }
                    // } else {

                    //     $data['appeal'][$key]['citizen_info'] = '';
                    //     $data['appeal'][$key]['notes'] = '';
                    // }

                    // $data['running_case_paginate'] = GccAppeal::WhereIn('ID', $total_case_count_defaulter['appeal_id_array'])->count();
                    $data['page_title'] = 'আইনজীবী ড্যাশবোর্ড';
                    return view('dashboard.lower')->with($data);
                }
            }
        }
    }

    public function get_drildown_case_count()
    {
        // return $type;

        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/dashboard/heigh/chart';
            $method = 'POST';
            $bodyData = null;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);

            // dd($res);
            if ($res['success']) {
                $result = $res['data'];
                return $result;
            }
        }
    }
    //for emc dashboard
    public function get_drildown_case_count_emc()
    {
        // return $type;

        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $url = getapiManagerBaseUrl() . '/api/v1/emc/dashboard/heigh/chart';
            $method = 'POST';
            $bodyData = null;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);


            if ($res['success']) {
                $result = $res['data'];
                return $result;
            }
        }
    }

    //for gcc dashboard statisticts
    public function ajaxCaseStatus(Request $request)
    {

        // Get Data
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;
        $data['role_id'] = $roleID;
        $data['division_id'] = user_office_info()->division_id;

        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/dashboard/statistics';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd('dd from cm vno w', $res);
            if ($res['success']) {
                if ($roleID == 2 || $roleID == 25 || $roleID == 8) { // Superadmin

                    if ($data['division']) {
                        $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $data['division'])->first()->division_name_bn;
                        $str = $divisionName . ' বিভাগের ';
                    }
                    if ($data['district']) {
                        $districtName = DB::table('district')->select('district_name_bn')->where('id', $data['district'])->first()->district_name_bn;
                        $str .= $districtName . ' জেলার ';
                    }
                    if ($data['upazila']) {
                        $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $data['upazila'])->first()->upazila_name_bn;
                        $str .= $upazilaName . ' উপজেলা/থানার ';
                    }

                    if ($request->division) {

                        $str .= 'তথ্য';
                    }
                } elseif ($roleID == 34) { // Divitional Comm.
                    if ($request->district) {
                        $divisionName = DB::table('division')->select('division_name_bn')->where('id', user_office_info()->division_id)->first()->division_name_bn;
                        $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                        $str = $divisionName . ' বিভাগের ' . $districtName . ' জেলার ';
                    }
                    if ($data['upazila']) {
                        $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $data['upazila'])->first()->upazila_name_bn;
                        $str .= $upazilaName . ' উপজেলা/থানার ';
                    }  
                    if($request->district) {
                        $str .= 'তথ্য';
                    }           
                  }
                $result = $res['data'];

                return response()->json(['msg' => $str, 'data' => $result]);
            }
        }
    }

    public function ajaxPaymentReport(Request $request)
    {

        // Get Data
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;
        $data['role_id'] = $roleID;
        if ($roleID == 34) {
            $data['division'] = user_office_info()->division_id;
        }


        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/dashboard/payment/statistics';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd('py memtn fo a oreer' , $res);
            if ($res['success']) {
                $result = $res['data'];

                $str = $res['message'];
                return response()->json(['msg' => $str, 'data' => $result]);
            }
        }


        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function ajaxPieChart(Request $request)
    {
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        $totalClaimed = 0;
        $totalReceived = 0;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;
        $data['role_id'] = $roleID;
        if ($roleID == 34) {
            $data['division'] = user_office_info()->division_id;
        }
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/dashboard/pie/chart';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);

            if ($res['success']) {
                $result = $res['data'];
                $str = $res['message'];
                return response()->json(['msg' => $str, 'data' => $result]);
            }
        }
    }

    //for emc dashboard statisticts
    public function emc_ajaxCrpc(Request $request)
    {
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;
        $data['role_id'] = $roleID;
        if ($roleID == 34) {
            $data['division'] = user_office_info()->division_id;
        }

        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/v1/emc/dashboard/crpc/statistics';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            // dd($response);
            $res = json_decode($response, true);
            // dd('em c csalosta', $res);
            if ($res['success']) {
                if ($roleID == 2 || $roleID == 25 || $roleID == 8) { // Superadmin
                    if ($request->division) {
                        $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                        $str = $divisionName . ' বিভাগের ';
                    }
                    if ($request->district) {
                        $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                        $str .= $districtName . ' জেলার ';
                    }
                    if ($request->upazila) {
                        $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                        $str .= $upazilaName . ' উপজেলা/থানার ';
                    }

                    if ($request->division) {

                        $str .= 'তথ্য';
                    }
                } elseif ($roleID == 34) { // Divitional Comm.
                    if ($request->district) {
                        $divisionName =  DB::table('division')->select('division_name_bn')->where('id', $data['division'])->first()->division_name_bn;
                        $str = $divisionName . ' বিভাগের ';
                        $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                        $str =$str = $divisionName . ' বিভাগের '. $districtName . ' জেলার ' ;
                    }
                    if ($request->upazila) {
                        $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                        $str .= $upazilaName . ' উপজেলা/থানার ';
                    }
                    if ($request->district) {

                        $str .= 'তথ্য';
                    }
                }

                $result = $res['data'];

                return response()->json(['msg' => $str, 'data' => $result]);
            }
        }

        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function emc_ajaxCaseStatus(Request $request)
    {

        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;
        $data['role_id'] = $roleID;
        if ($roleID == 34) {
            $data['division'] = user_office_info()->division_id;
        }
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/v1/emc/dashboard/case/adalot';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            // dd($response);
            $res = json_decode($response, true);
            // dd($res);
            if ($res['success']) {
                if ($roleID == 2 || $roleID == 25 || $roleID == 8) { // Superadmin
                    if ($request->division) {
                        $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                        $str = $divisionName . ' বিভাগের ';
                    }
                    if ($request->district) {
                        $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                        $str .= $districtName . ' জেলার ';
                    }
                    if ($request->upazila) {
                        $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                        $str .= $upazilaName . ' উপজেলা/থানার ';
                    }

                    if ($request->division) {

                        $str .= 'তথ্য';
                    }
                } elseif ($roleID == 34) { // Divitional Comm.
                    if ($request->district) {
                        $divisionName =  DB::table('division')->select('division_name_bn')->where('id', $data['division'])->first()->division_name_bn;
                        $str = $divisionName . ' বিভাগের ';
                        $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                        $str =$str = $divisionName . ' বিভাগের '. $districtName . ' জেলার ' ;
                    }
                    if ($request->upazila) {
                        $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                        $str .= $upazilaName . ' উপজেলা/থানার ';
                    }
                    if ($request->district) {

                        $str .= 'তথ্য';
                    }
                }

                $result = $res['data'];

                return response()->json(['msg' => $str, 'data' => $result]);
            }
        }
    }

    public function emc_ajaxPieChart(Request $request)
    {
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;
        $data['role_id'] = $roleID;
        if ($roleID == 34) {
            $data['division'] = user_office_info()->division_id;
        }
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/v1/emc/dashboard/pie/chart';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);

            if ($res['success']) {
                if ($roleID == 2 || $roleID == 25 || $roleID == 8) { // Superadmin
                    if ($request->division) {
                        $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                        $str = $divisionName . ' বিভাগের তথ্য';
                    }
                } elseif ($roleID == 34) { // Divitional Comm.
                    if ($request->district) {
                        $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                        $str = $districtName . ' জেলার তথ্য';
                    }
                }

                $result = $res['data'];

                return response()->json(['msg' => $str, 'data' => $result]);
            }
        }
    }






    public function statistics_case_status($status, $data = null)
    {
        $query = DB::table('gcc_appeals')->where('appeal_status', $status);
        if (globalUserInfo()->role_id == 6) {
            $data['district'] = user_district()->id;
        }

        if (globalUserInfo()->role_id == 34) {
            $data['division'] = user_office_info()->division_id;
        }

        if ($data['division']) {
            $query->where('division_id', '=', $data['division']);
        }
        if ($data['district']) {
            $query->where('district_id', '=', $data['district']);
        }
        if ($data['upazila']) {
            $query->where('upazila_id', '=', $data['upazila']);
        }
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            $query->whereBetween('case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        return $query->count();
        // return $query;
    }


    public function ajaxDataFineVSCase(Request $request){
      
        if (globalUserInfo()->role_id==34) {
            $d['divisionid']=user_office_info()->division_id;
        } else {
            $d['divisionid']=$request->divisionid;
        }
        $d['zillaid']=$request->zillaid;
        $d['upozilaid']=$request->upozilaid;
        $d['GeoCityCorporations']=$request->GeoCityCorporations;
        $d['GeoMetropolitan']=$request->GeoMetropolitan;
        $d['GeoThanas']=$request->GeoThanas;
        $d['start_date']=$request->start_date;
        $d['end_date']=$request->end_date;
        $d['role_id']=globalUserInfo()->role_id;
        $d['office_id']=globalUserInfo()->office_id;

        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {

            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/mc/dashboard/ajaxDataFineVSCase';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            
            return response()->json($res);
            
        }


         
    }
    public function ajaxDashboardCriminalInformation(Request $request){
        if (globalUserInfo()->role_id==34) {
            $d['divisionid']=user_office_info()->division_id;
        } else {
            $d['divisionid']=$request->divisionid;
        }
        $d['zillaid']=$request->zillaid;
        $d['upozilaid']=$request->upozilaid;
        $d['GeoCityCorporations']=$request->GeoCityCorporations;
        $d['GeoMetropolitan']=$request->GeoMetropolitan;
        $d['GeoThanas']=$request->GeoThanas;
        $d['start_date']=$request->start_date;
        $d['end_date']=$request->end_date;
        $d['role_id']=globalUserInfo()->role_id;
        $d['office_id']=globalUserInfo()->office_id;

        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {

            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/mc/dashboard/ajaxDashboardCriminalInformation';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
   
            return response()->json($res);
            
        }
    }
    public function ajaxdashboardCaseStatistics(Request $request){
       
        if (globalUserInfo()->role_id==34) {
            $d['divisionid']=user_office_info()->division_id;
        } else {
            $d['divisionid']=$request->divisionid;
        }
        
        
        $d['zillaid']=$request->zillaid;
        $d['upozilaid']=$request->upozilaid;
        $d['GeoCityCorporations']=$request->GeoCityCorporations;
        $d['GeoMetropolitan']=$request->GeoMetropolitan;
        $d['GeoThanas']=$request->GeoThanas;
        $d['start_date']=$request->start_date;
        $d['end_date']=$request->end_date;
        $d['role_id']=globalUserInfo()->role_id;
        $d['office_id']=globalUserInfo()->office_id;

        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {

            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/mc/dashboard/ajaxdashboardCaseStatistics';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            return response()->json($res);
            
        }
    }
    public function ajaxCitizen(Request $request){
        if (globalUserInfo()->role_id==34) {
            $d['divisionid']=user_office_info()->division_id;
        } else {
            $d['divisionid']=$request->divisionid;
        }
        $d['zillaid']=$request->zillaid;
        $d['upozilaid']=$request->upozilaid;
        $d['GeoCityCorporations']=$request->GeoCityCorporations;
        $d['GeoMetropolitan']=$request->GeoMetropolitan;
        $d['GeoThanas']=$request->GeoThanas;
        $d['start_date']=$request->start_date;
        $d['end_date']=$request->end_date;
        $d['role_id']=globalUserInfo()->role_id;
        $d['office_id']=globalUserInfo()->office_id;

        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {

            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/mc/dashboard/ajaxCitizen';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            return response()->json($res);
            
        }
    }
    public function ajaxDataLocationVSCase(Request $request){
        if (globalUserInfo()->role_id==34) {
            $d['divisionid']=user_office_info()->division_id;
        } else {
            $d['divisionid']=$request->divisionid;
        }
        $d['zillaid']=$request->zillaid;
        $d['upozilaid']=$request->upozilaid;
        $d['GeoCityCorporations']=$request->GeoCityCorporations;
        $d['GeoMetropolitan']=$request->GeoMetropolitan;
        $d['GeoThanas']=$request->GeoThanas;
        $d['start_date']=$request->start_date;
        $d['end_date']=$request->end_date;
        $d['role_id']=globalUserInfo()->role_id;
        $d['office_id']=globalUserInfo()->office_id;

        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {

            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/mc/dashboard/ajaxDataLocationVSCase';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            return response()->json($res);
            
        }
    }
    public function ajaxDataLawVSCase(Request $request){
        if (globalUserInfo()->role_id==34) {
            $d['divisionid']=user_office_info()->division_id;
        } else {
            $d['divisionid']=$request->divisionid;
        }
        $d['zillaid']=$request->zillaid;
        $d['upozilaid']=$request->upozilaid;
        $d['GeoCityCorporations']=$request->GeoCityCorporations;
        $d['GeoMetropolitan']=$request->GeoMetropolitan;
        $d['GeoThanas']=$request->GeoThanas;
        $d['start_date']=$request->start_date;
        $d['end_date']=$request->end_date;
        $d['role_id']=globalUserInfo()->role_id;
        $d['office_id']=globalUserInfo()->office_id;

        $token = $this->verifySiModuleToken('WEB');

        if ($token) {

            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/mc/dashboard/ajaxDataLawVSCase';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            return response()->json($res);
            
        }
    }
    
    public function monthlyReport(Request $request)
    {
      
        $year = $request->query('year');
        $currentMonth = $request->query('currentMonth');
        $previousMonth = $request->query('previousMonth');
        // Validate the inputs if necessary
        $validated = $request->validate([
            'year' => 'required|integer',
            'currentMonth' => 'required|integer|between:1,12',
            'previousMonth' => 'required|integer|between:1,12',
        ]);

        // Add logic to process the report based on the parameters
        // Example: Fetch data from the database
        $reportData = []; // Replace with actual data retrieval logic

        return view('dashboard.monthlyReport', compact('reportData', 'year', 'currentMonth', 'previousMonth'));
    }
     


}