<?php

namespace App\Http\Controllers\doptor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\NDoptorRepositoryAdmin;

class NDoptorUserManagementAdmin extends Controller
{
    public function all_user_list_from_doptor_segmented($office_id)
    {
        // dd($_GET['court_type_id']);

        $office_id = decrypt($office_id);
   
      
        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
        } else {
            $username = 100000006515;
        }

        $get_token_response = NDoptorRepositoryAdmin::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];
            $response_after_decode = NDoptorRepositoryAdmin::get_employee_list_by_office($token, $office_id);
         
            // dd($response_after_decode);
            if ($response_after_decode['status'] == 'success') {
                $everything_for_dc = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented_for_dc($response_after_decode['data']);
                $list_of_all_for_dc = json_decode($everything_for_dc, true)['list_of_all'];
                $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);
                
                $list_of_all = json_decode($everything, true)['list_of_all'];
                
                
                $doptor_office_status_from_db = DB::table('doptor_offices')
                ->where('office_id', '=', $office_id)
                ->first();
                // dd($doptor_office_status_from_db->office_name_bng);
                // dd($doptor_office_status_from_db->office_layer_id, $doptor_office_status_from_db->office_origin_id);
                // dd($doptor_office_status_from_db);
                if ($doptor_office_status_from_db->office_layer_id == 21 && $doptor_office_status_from_db->office_origin_id == 15) {
                    $division_details = DB::table('geo_divisions')
                        ->where('id', '=', $doptor_office_status_from_db->geo_division_id)
                        ->first();

                    if (empty($division_details)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }

                    $data['page_title'] = ' ইউজার ম্যানেজমেন্ট,  ' . $doptor_office_status_from_db->office_name_bng ;

                    $data['list_of_all'] = $list_of_all_for_dc;
                    $data['office_id'] = $office_id;
                    $data['available_role'] = NDoptorRepositoryAdmin::rolelist_division();

                    // dd($data['list_of_all']);
                    return view('user_doptor_admin.div_com_office')->with($data);
                } elseif ($doptor_office_status_from_db->office_layer_id == 22 && $doptor_office_status_from_db->office_origin_id == 16) {


                    $get_district_from_geo_distcrict_with_district = NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);

                    $get_division_from_geo_division_with_division = NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                    if (empty($get_district_from_geo_distcrict_with_district)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }
                    if (empty($get_division_from_geo_division_with_division)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }

                    $district_id = $get_district_from_geo_distcrict_with_district->id;
                    $division_id = $get_division_from_geo_division_with_division->id;

                    $district_name_bng = $get_district_from_geo_distcrict_with_district->district_name_bng;

                    $data['page_title'] = ' ইউজার ম্যানেজমেন্ট,  ' . $doptor_office_status_from_db->office_name_bng ;
                    $data['list_of_all'] = $list_of_all;
                    $data['office_id'] = $office_id;
                    $data['available_emc_court'] = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($district_id, $division_id);
                    $data['available_gcc_court'] = NDoptorRepositoryAdmin::gcc_courtlist_district_all($district_id, $division_id);
                    $data['available_mc_court'] = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($district_id, $division_id);
                    $data['available_gcc_role'] = NDoptorRepositoryAdmin::rolelist_district();
                    $data['available_emc_role'] = NDoptorRepositoryAdmin::emc_rolelist_district();
                    $data['available_mc_role'] = NDoptorRepositoryAdmin::mc_rolelist_district();
                   
                    return view('user_doptor_admin.dis_com_office')->with($data);
                } elseif (($doptor_office_status_from_db->office_layer_id == 23 && $doptor_office_status_from_db->office_origin_id == 17) || ($doptor_office_status_from_db->office_layer_id == 40 && $doptor_office_status_from_db->office_origin_id == 39)) {

                    $get_district_from_geo_distcrict_with_district = NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);

                    $get_division_from_geo_division_with_division = NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                    $get_upazila_from_geo_upazila_with_upazila = NDoptorRepositoryAdmin::get_upazila_from_geo_upazila_with_upazila($doptor_office_status_from_db->geo_upazila_id);

                    if (empty($get_upazila_from_geo_upazila_with_upazila)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }
                    if (empty($get_district_from_geo_distcrict_with_district)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }
                    if (empty($get_division_from_geo_division_with_division)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }


                    $district_id = $get_district_from_geo_distcrict_with_district->id;
                    $division_id = $get_division_from_geo_division_with_division->id;
                    $upazila_id = $get_upazila_from_geo_upazila_with_upazila->id;
                    
                    $upazila_name_bn = $get_upazila_from_geo_upazila_with_upazila->upazila_name_bn;

                    // dd($doptor_office_status_from_db->office_name_bng);
                    $data['page_title'] = ' ইউজার ম্যানেজমেন্ট,  ' . $doptor_office_status_from_db->office_name_bng ;
                    $data['list_of_all'] = $list_of_all;
                    $data['office_id'] = $office_id;
                    $data['available_emc_court'] = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($district_id, $division_id);
                    $data['available_gcc_court'] = NDoptorRepositoryAdmin::gcc_courtlist_district_all($district_id, $division_id);
                    $data['available_mc_court'] = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($district_id, $division_id);
                    $data['available_gcc_role'] = NDoptorRepositoryAdmin::gcc_rolelist_upa();
                    $data['available_emc_role'] = NDoptorRepositoryAdmin::emc_rolelist_upa();
                    $data['available_mc_role'] = NDoptorRepositoryAdmin::mc_rolelist_upa();
                    // dd($data);
                    return view('user_doptor_admin.dis_com_office')->with($data);
                }else {
                    $get_district_from_geo_distcrict_with_district = NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);

                    $get_division_from_geo_division_with_division = NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                    if (empty($get_district_from_geo_distcrict_with_district)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }
                    if (empty($get_division_from_geo_division_with_division)) {
                        return Redirect::back()->with('withError', 'তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }

                    $district_id = $get_district_from_geo_distcrict_with_district->id;
                    $division_id = $get_division_from_geo_division_with_division->id;

                    $district_name_bng = $get_district_from_geo_distcrict_with_district->district_name_bng;

                    $data['page_title'] = ' ইউজার ম্যানেজমেন্ট,  ' . $doptor_office_status_from_db->office_name_bng ;
                    $data['list_of_all'] = $list_of_all;
                    $data['office_id'] = $office_id;
                    $data['available_emc_court'] = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($district_id, $division_id);
                    $data['available_gcc_court'] = NDoptorRepositoryAdmin::gcc_courtlist_district_all($district_id, $division_id);
                    $data['available_mc_court'] = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($district_id, $division_id);
                    $data['available_gcc_role'] = NDoptorRepositoryAdmin::rolelist_district();
                    $data['available_emc_role'] = NDoptorRepositoryAdmin::emc_rolelist_district();
                    $data['available_mc_role'] = NDoptorRepositoryAdmin::mc_rolelist_district();
                   
                    return view('user_doptor_admin.dis_com_office')->with($data);
                }
            }
        }
    }

    //create doptor office tabel
    public function create_doptor_office_tabel(){
        
        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
        } else {
            $username = 100000006515;
        }

        $get_token_response = NDoptorRepositoryAdmin::getToken($username);
  
        dd($get_token_response);


        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];
            $response_after_decode = NDoptorRepositoryAdmin::get_list_of_office($token, null);
            // dd($response_after_decode);
            //officelayer table
            foreach ($response_after_decode['data'] as  $value) {
                // dd($value);
                $data=[
                    'custom_id' => $value['id'],
                    'office_name_bng' => $value['office_name_bng'],
                    'office_name_eng' => $value['office_name_eng'],
                    'office_ministry_id' => $value['office_ministry_id'],
                    'office_layer_id' => $value['office_layer_id'],
                    'parent_office_id' => $value['parent_office_id'],
                    'office_level' => $value['office_level'],
                    'office_sequence' => $value['office_sequence'],
                    'layer_level' => $value['office_layer']['layer_level'],
                    
                ];
                // dd($data);

                $asa = DB::table('officeorigin_new')->insert($data);
            }

            dd('ok');
            //doptor office create

            $firstArray = NDoptorRepositoryAdmin::get_list_of_office($token, null);

            $secondArray = DB::table('doptor_offices')->get()->toArray(); 

            $firstOfficeIds = array_column($firstArray['data'], 'id'); 
            $secondOfficeIds = array_column($secondArray, 'office_id'); 
            
            $uniqueOfficeIds = array_diff($firstOfficeIds, $secondOfficeIds);
 
            
            $newArray = array_filter($firstArray['data'], function ($item) use ($uniqueOfficeIds) {
                return in_array($item['id'], $uniqueOfficeIds);
            });

  
            $newArray = array_values($newArray);

            // dd($newArray);


            // dd(($response_after_decode));
            foreach ($newArray as  $value) {
                // dd($value);
                $data=[
                    'office_id' => $value['id'],
                    'office_name_bng' => $value['office_name_bng'],
                    'office_name_eng' => $value['office_name_eng'],
                    'geo_division_id' => $value['geo_division_id'],
                    'geo_district_id' => $value['geo_district_id'],
                    'geo_upazila_id' => $value['geo_upazila_id'],
                    'digital_nothi_code' => $value['digital_nothi_code'],
                    'office_phone' => $value['office_phone'],
                    'office_mobile' => $value['office_mobile'],
                    'office_fax' => $value['office_fax'],
                    'office_email' => $value['office_email'],
                    'office_web' => $value['office_web'],
                    'office_ministry_id' => $value['office_ministry_id'],
                    'office_layer_id' => $value['office_layer_id'],
                    'office_origin_id' => $value['office_origin_id'],
                    'custom_layer_id' => $value['custom_layer_id'],
                    'parent_office_id' => $value['parent_office_id'],
                    'layer_level' => $value['office_layer']['layer_level'],
                    
                ];
                // dd($data);

                $asa = DB::table('doptor_offices')->insert($data);
               
            }

            dd('ok');
        }
       
    }

    public function all_user_list_from_doptor_segmented_search($office_id, Request $request)
    {
        // dd($request->search_key);


        // dd($_GET['court_type_id']);

        $office_id = decrypt($office_id);
        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
        } else {
            $username = 100000006515;
        }

        $get_token_response = NDoptorRepositoryAdmin::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepositoryAdmin::get_employee_list_by_office($token, $office_id);
            $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);
            // dd($everything);

            $list_of_all = json_decode($everything, true)['list_of_all'];

            $doptor_office_status_from_db = DB::table('doptor_offices')
                ->where('office_id', '=', $office_id)
                ->first();
            if ($doptor_office_status_from_db->office_layer_id == 21 && $doptor_office_status_from_db->office_origin_id == 15) {

                $list_of_others_fianl = [];

                $division_details = DB::table('geo_divisions')
                    ->where('id', '=', $doptor_office_status_from_db->geo_division_id)
                    ->first();

                $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  ' . $division_details->division_name_bng . ' বিভাগীয় ম্যাজিস্ট্রেসি';
                $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];


                $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);

                $list_of_all = json_decode($everything, true)['list_of_all'];



                foreach ($search_keys as $value) {

                    $search_by_key = NDoptorRepositoryAdmin::search_revisions($list_of_all, $request->search_key, $value);

                    if (!empty($search_by_key)) {

                        $list_of_others = [];

                        foreach ($search_by_key  as $list) {
                            array_push($list_of_others, $list_of_all[$list]);
                        }
                        $list_of_others_fianl = $list_of_others;
                        break;
                    }
                }


                $data['list_of_all'] = $list_of_others_fianl;
                $data['office_id'] = $office_id;
                $data['available_role'] = NDoptorRepositoryAdmin::rolelist_division();

                return view('user_doptor_admin.div_com_office')->with($data);
            } elseif ($doptor_office_status_from_db->office_layer_id == 22 && $doptor_office_status_from_db->office_origin_id == 16) {

                $list_of_others_fianl = [];

                $get_district_from_geo_distcrict_with_district = NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);
                $get_division_from_geo_division_with_division = NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                $district_id = $get_district_from_geo_distcrict_with_district->id;
                $division_id = $get_division_from_geo_division_with_division->id;

                $district_name_bng = $get_district_from_geo_distcrict_with_district->district_name_bng;


                $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  ' . $district_name_bng . ' জেলা ম্যাজিস্ট্রেসি';

                $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);
                $list_of_all = json_decode($everything, true)['list_of_all'];

                $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];

                foreach ($search_keys as $value) {

                    $search_by_key = NDoptorRepositoryAdmin::search_revisions($list_of_all, $request->search_key, $value);

                    if (!empty($search_by_key)) {

                        $list_of_others = [];

                        foreach ($search_by_key  as $list) {
                            array_push($list_of_others, $list_of_all[$list]);
                        }
                        $list_of_others_fianl = $list_of_others;
                        break;
                    }
                }

                // dd($search_by_key);

                $data['list_of_all'] = $list_of_others_fianl;
                $data['office_id'] = $office_id;
                $data['available_emc_court'] = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($district_id, $division_id);
                $data['available_gcc_court'] = NDoptorRepositoryAdmin::gcc_courtlist_district_all($district_id, $division_id);
                $data['available_mc_court'] = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($district_id, $division_id);
                $data['available_gcc_role'] = NDoptorRepositoryAdmin::rolelist_district();
                $data['available_emc_role'] = NDoptorRepositoryAdmin::emc_rolelist_district();
                $data['available_mc_role'] = NDoptorRepositoryAdmin::mc_rolelist_district();

                return view('user_doptor_admin.dis_com_office')->with($data);
            } elseif ($doptor_office_status_from_db->office_layer_id == 23 && $doptor_office_status_from_db->office_origin_id == 17) {
                $list_of_others_fianl = [];

                $get_district_from_geo_distcrict_with_district = NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);

                $get_division_from_geo_division_with_division = NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                $get_upazila_from_geo_upazila_with_upazila = NDoptorRepositoryAdmin::get_upazila_from_geo_upazila_with_upazila($doptor_office_status_from_db->geo_upazila_id);


                $district_id = $get_district_from_geo_distcrict_with_district->id;
                $division_id = $get_division_from_geo_division_with_division->id;
                $upazila_id = $get_upazila_from_geo_upazila_with_upazila->id;

                $upazila_name_bn = $get_upazila_from_geo_upazila_with_upazila->upazila_name_bn;


                $data['page_title'] = 'জেনারেল সার্টিফিকেট আদালতের ইউজার ম্যানেজমেন্ট,  ' . $upazila_name_bn . ' উপজেলা ম্যাজিস্ট্রেসি';

                $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);

                $list_of_all = json_decode($everything, true)['list_of_all'];



                $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];

                foreach ($search_keys as $value) {

                    $search_by_key = NDoptorRepositoryAdmin::search_revisions($list_of_all, $request->search_key, $value);


                    if (!empty($search_by_key)) {

                        $list_of_others = [];

                        foreach ($search_by_key  as $list) {
                            array_push($list_of_others, $list_of_all[$list]);
                        }
                        $list_of_others_fianl = $list_of_others;
                        break;
                    }
                }



                $data['list_of_all'] = $list_of_others_fianl;
                $data['office_id'] = $office_id;
                $data['available_court'] = NDoptorRepositoryAdmin::courtlist_upazila($district_id, $division_id);
                $data['available_role'] = NDoptorRepositoryAdmin::rolelist_upazila();

                return view('user_doptor_admin.uno_office')->with($data);
            }
        }
    }

    public function divisional_commissioner_create_by_admin(Request $request)
    {

        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'role_id' => $request->role_id,
                    ];


                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);



                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::Div_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->role_id == 0) {
                                $role_name = 'No_role';
                            } else {
                                $role = NDoptorRepositoryAdmin::rolelist_division();
                                foreach ($role as $rolelist) {
                                    if ($rolelist->id == $request->role_id) {
                                        $role_name = $rolelist->role_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'role_name' => $role_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'role_id' => $request->role_id,
                    ];


                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::Div_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            $role = NDoptorRepositoryAdmin::rolelist_division();
                            foreach ($role as $rolelist) {
                                if ($rolelist->id == $request->role_id) {
                                    $role_name = $rolelist->role_name;
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'role_name' => $role_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    //for gcc court
    public function district_commissioner_create_by_admin(Request $request)
    {

        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::Gcc_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::Gcc_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function pasker_district_commissioner_create_by_admin(Request $request)
    {
        
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::Gcc_pasker_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::Gcc_pasker_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function aditional_district_commissioner_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::Ad_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::Ad_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function aditional_district_commissioner_pasker_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::Ad_Dis_Commissioner_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::Ad_Dis_Commissioner_pasker_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function deputy_collector_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();
    
            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::deputy_collector_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);
            
                        $created = NDoptorRepositoryAdmin::deputy_collector_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function record_keeper_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();
    
            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::record_keeper_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);
            
                        $created = NDoptorRepositoryAdmin::record_keeper_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }


    public function gco_dc_create_by_admin(Request $request)
    {

        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::GCO_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);


                        if ($updated) {

                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();
                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }

                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::GCO_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function store_certificate_asst_dc_by_admin(Request $request)
    {

        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::certificate_assistent_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);


                        if ($updated) {

                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();
                                $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }

                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::certificate_assistent_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('gcc_court')->where('id', '=', $request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::gcc_courtlist_district_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }


    public function gco_uno_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::GCO_UNO_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id, $request_court_details->division_id);

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::GCO_UNO_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('court')->where('id', '=', $request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }
    public function store_certificate_asst_uno_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::certificate_assistent_UNO_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                $request_court_details = DB::table('court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id, $request_court_details->division_id);

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];


                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::certificate_assistent_UNO_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('court')->where('id', '=', $request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }

                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    //for emc court
    public function dm_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::emc_dm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::emc_dm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function adm_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::emc_adm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::emc_adm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function adm_pasker_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::emc_adm_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::emc_adm_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function em_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::emc_em_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::emc_em_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function em_pasker_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::emc_em_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::emc_em_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    //for mc court
    public function mc_dm_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::mc_dm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                                // dd($court);

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::mc_dm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function mc_adm_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::mc_adm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                                // dd($court);

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::mc_adm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($created) {

                            $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function mc_acgm_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::mc_acgm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                                // dd($court);

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::mc_acgm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($created) {

                            $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function mc_em_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);
        // dd($get_current_desk);
        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();
            // dd($username);
            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::mc_em_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                                // dd($court);

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    // dd($get_token_response);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);
                        // dd($get_office_basic_info);
                        $created = NDoptorRepositoryAdmin::mc_em_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($created) {

                            $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function mc_pasker_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::mc_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                                // dd($court);

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                        'court_type_id' => $request->court_type_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::mc_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($created) {

                            $request_court_details = DB::table('mobile_court')->where('id', '=', $request->court_id)->first();


                            $court = NDoptorRepositoryAdmin::mc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            }


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }
}