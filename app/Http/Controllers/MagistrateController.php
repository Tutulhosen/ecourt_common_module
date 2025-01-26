<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\TokenVerificationTrait;


class MagistrateController extends Controller
{
    use TokenVerificationTrait;
    public function check_user_permission(Request $request){


        $data['username']=$request->username;
        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {
            $jsonData = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/v1/mc/check/user/permission';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            if ($res['success']==true) {
                $is_already_has=$res['data'];
                return response()->json([
                    'upa_id_arr' => $is_already_has ? json_decode($is_already_has['upa_id_arr']) : []
                ]);
            }
        }

        
    }
    


    public function jurisdiction(){
        $user=globalUserInfo();
        $officeInfo = globalUserOfficeInfo($user->office_id);
        
        $division = DB::table('division')->get();
        $upazila = DB::table('upazila')->get();
    
        
        $data['division'] = $division;
        $data['upzillas'] = $upazila;
        // $data['user'] = $user;
        $data['page_title'] = 'অধিক্ষেত্র নির্ধারণ';
        // dd($data);
        return view('jurisdiction.jurisdiction')->with($data);
    }


    public function jurisdiction_store(Request $request) {
        $d['div_id']=$request->division;
        $d['dis_id']=$request->district;
    
        // Encode the selected upazila mapping to JSON
        $d['upa'] = json_encode($request->input('upzilla_mapping'));

        $data['username']=$request->user_select;
        $token = $this->verifySiModuleToken('WEB');
     
        if ($token) {
      
            $d['user_id']=$request->user_select;
            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/v1/mc/jurisdiction/store';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            if ($res['success']==true) {
                return response()->json(['success' => true]);
            }else {
                return response()->json(['error' => true]);
            }
            
        }
        
    }

    public function getDistricts($div_id) {
        $districts =DB::table('district')->where('division_id', $div_id)->get();
        return response()->json($districts);
    }

    public function getUser($dis_id) {
        $office=DB::table('office')->where('district_id', $dis_id)->where('level', 3)->where('upazila_id', null)->get();
        $office_id_arr=[];
        foreach ($office as $key => $value) {
            array_push($office_id_arr, $value->id);
        }
    
        $all_user= DB::table('users')
            ->join('doptor_user_access_info','users.id', 'doptor_user_access_info.user_id')
            ->where('doptor_user_access_info.court_type_id', 1)
            ->where('doptor_user_access_info.court_id','!=', 0)
            ->whereIn('office_id', $office_id_arr)
            ->whereIn('doptor_user_access_info.role_id', [25,26])
            ->get();
        $all_user = $all_user->map(function($user) {
            $user->role_name = McRoleName($user->role_id);  
            return $user;
        });
        // dd($all_user);
        return response()->json($all_user);
    }

    public function getUpazilas($dis_id) {
        $upazilas = DB::table('upazila')
            ->where('district_id', $dis_id)
            ->get();
    
        return response()->json($upazilas);
    }

    //mamla cance;
    public function mamla_cancel(){
        return view('mobile_court.mamla_cancel');
    }

    public function mamla_cancel_from_admin(Request $request) {

    
      
        // Encode the selected upazila mapping to JSON
        $d['case_no'] = $request->case_no;
        $d['name'] = globalUserInfo()->name;
        $token = $this->verifySiModuleToken('WEB');
   
        if ($token) {
            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/v1/cancel/mamla/from/admin';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            if ($res['status']==false) {
                return response()->json([
                    'status' => false,
                    'message' => $res['message']

                ]);
            }
            if ($res['status']==true) {
                return response()->json([
                    'status' => true,
                    'message' => $res['message']

                ]);
            }
            
        }
        
    }
    
    
}



