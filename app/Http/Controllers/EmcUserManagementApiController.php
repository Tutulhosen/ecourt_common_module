<?php

namespace App\Http\Controllers;

use App\Repositories\NDoptorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EmcUserManagementApiController extends Controller
{
    public function get_adm_user_list(Request $request)
    {
        $requestData = $request->all();
        $bodydata = $requestData['body_data'];
        $username = $bodydata['username'];
        $office_id =  $bodydata['office_id'];
        // return ['fds'=>$office_id];
        $get_token_response = NDoptorRepository::getToken($username);
        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];
            $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, $office_id);
            if ($response_after_decode['status'] == 'success') {
                $everything = NDoptorRepository::emc_all_user_list_from_doptor_segmented($response_after_decode['data']);
                $list_of_all = json_decode($everything, true)['list_of_all'];
            }
        }
        return ['success' => true, "data" => $list_of_all];
    }
    public function store_em_dc(Request $request)
    {
        $requestData = $request->all();
        $request = $requestData['body_data'];
        $get_current_desk = NDoptorRepository::current_desk($request['username']);
        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request['username'])
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],
                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepository::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $updated = NDoptorRepository::emc_em_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request['court_id'] == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();

                                $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request['court_id']) {
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
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],
                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepository::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $created = NDoptorRepository::emc_em_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();


                            $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request['court_id']) {
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
    public function store_em_paskar_dc(Request $request)
    {
        $requestData = $request->all();
        $request = $requestData['body_data'];
        $get_current_desk = NDoptorRepository::current_desk($request['username']);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request['username'])
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],
                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepository::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $updated = NDoptorRepository::emc_em_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request['court_id'] == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();

                                $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request['court_id']) {
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
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],
                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepository::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $created = NDoptorRepository::emc_em_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();
                            $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request['court_id']) {
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
    public function store_em_adm_dc(Request $request)
    {
        $requestData = $request->all();
        $request = $requestData['body_data'];
        $get_current_desk = NDoptorRepository::current_desk($request['username']);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request['username'])
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],
                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepository::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $updated = NDoptorRepository::emc_adm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request['court_id'] == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();

                                $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request['court_id']) {
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
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],

                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepository::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $created = NDoptorRepository::emc_adm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();


                            $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request['court_id']) {
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
    public function store_em_adm_paskar_dc(Request $request)
    {
        $requestData = $request->all();
        $request = $requestData['body_data'];
        $get_current_desk = NDoptorRepository::current_desk($request['username']);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request['username'])
                ->first();

            if (!empty($username)) {

                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],
                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepository::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $updated = NDoptorRepository::emc_adm_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request['court_id'] == 0) {
                                $court_name = 'No_court';
                            } else {

                                $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();

                                $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);



                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request['court_id']) {
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
                        'office_name_bn' => $request['office_name_bn'],
                        'office_name_en' => $request['office_name_en'],
                        'unit_name_bn' => $request['unit_name_bn'],
                        'unit_name_en' => $request['unit_name_en'],
                        'office_id' => $request['office_id'],
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request['designation_bng'],
                        'username' => $request['username'],
                        'employee_name_bng' => $request['employee_name_bng'],
                        'court_id' => $request['court_id'],
                        'court_type_id' => $request['court_type_id'],
                    ];

                    if ($request['userInfo']['doptor_user_flag'] == 1) {
                        $username = $request['userInfo']['username'];
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepository::getToken($username);


                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepository::get_office_basic_info($token, $request['office_id']);

                        $created = NDoptorRepository::emc_adm_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {

                            $request_court_details = DB::table('emc_court')->where('id', '=', $request['court_id'])->first();


                            $court = NDoptorRepository::emc_courtlist_distrcit_all($request_court_details->district_id, $request_court_details->division_id);

                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request['court_id']) {
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
