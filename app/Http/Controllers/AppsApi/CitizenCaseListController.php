<?php

namespace App\Http\Controllers\AppsApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;

class CitizenCaseListController extends BaseController
{
    public function fecthDashboradData_emc_citizen($data)
    {
        $user = Auth::user();
        $citizen_info = DB::table('users')
            ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
            ->select('ecourt_citizens.citizen_NID', 'ecourt_citizens.organization_id','ecourt_citizens.citizen_phone_no')
            ->where('users.id', $user->id)
            ->where('ecourt_citizens.citizen_type_id', 1)
            ->first();
        //  return [$user, $citizen_info];  
        $all_data['auth_user'] = [
            'citizen_nid' => $citizen_info->citizen_NID,
            'citizen_phone_no' => $citizen_info->citizen_phone_no,
            'user_id' => $user->id,
            'username' => $user->username, 
        ];

        $all_data['request_data']=$data;



        $jsonData = json_encode($all_data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getEmcBaseUrl() . '/api/emc-citizen-dashboard-data-apps',
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
        // if (!empty($res)) {

        return $res;
    }

    public function fecthDashboradData_gcc_org($data)
    {
        $user = Auth::user();
        $citizen_info = DB::table('users')
            ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
            ->select('ecourt_citizens.citizen_NID', 'ecourt_citizens.organization_id','ecourt_citizens.citizen_phone_no')
            ->where('users.id', $user->id)
            ->where('ecourt_citizens.citizen_type_id', 2)
            ->first();

        $all_data['auth_user'] = [
            'citizen_nid' => $citizen_info->citizen_NID,
            'organization_id' => $citizen_info->organization_id,
            'citizen_phone_no' => $citizen_info->citizen_phone_no,
            'user_id' => $user->id,
            'username' => $user->username,
        ];

        $all_data['request_data']=$data;

        $jsonData = json_encode($all_data);
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getGccBaseUrl() . '/api/count-org-rep-dashboard-data-app',
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
        // if (!empty($res)) {

        return $res;
    }

    public function fecthDashboradData_gcc_citizen($data)
    {
        $user = Auth::user();
        $citizen_info = DB::table('users')
            ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
            ->select('ecourt_citizens.citizen_NID','ecourt_citizens.citizen_phone_no')
            ->where('users.id', $user->id)
            ->where('ecourt_citizens.citizen_type_id', 1)
            ->first();

        $all_data['auth_user'] = [
            'citizen_nid' => $citizen_info->citizen_NID,
            'citizen_phone_no' => $citizen_info->citizen_phone_no,
            'user_id' => $user->id,
            'username' => $user->username,
        ];

        $all_data['request_data']=$data;

        $jsonData = json_encode($all_data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getGccBaseUrl() . '/api/count-gcc-citizen-dashboard-data-app',
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
      

        return $gcc_res;
    }

    
    // case  for emc citizen
    public function case_for_emc_citizen(Request $request){
   
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];
        if (!empty($data['case_type'])) {
            $data_type=['closed', 'running', 'pending', 'total'];
            if (!in_array($data['case_type'], $data_type)) {
                return  $this->sendError('মামলার টাইপ সঠিক নয় ', ['error' => 'মামলার টাইপ সঠিক নয় '], 200);
            }
        } else {
            return  $this->sendError('মামলার টাইপ দিন ', ['error' => 'মামলার টাইপ দিন'], 200);
        }
        
        if (globalUserInfo()->citizen_type_id==1) {
             $res = $this->fecthDashboradData_emc_citizen($data);
            if ($data['case_type']=='pending') {
                $all_appeals = $res->total_pending_case_count_applicant->all_appeals;
                $totalCount = $res->total_pending_case_count_applicant->total_count;
            }
            if ($data['case_type']=='total') {
                 $all_appeals = $res->total_case_count_applicant->all_appeals;
                 $totalCount = $res->total_case_count_applicant->total_count;
             }
             if ($data['case_type']=='running') {
                 $all_appeals = $res->total_running_case_count_applicant->all_appeals;
                 $totalCount = $res->total_running_case_count_applicant->total_count;
             }
             if ($data['case_type']=='closed') {
                 $all_appeals = $res->total_completed_case_count_applicant->all_appeals;
                 $totalCount = $res->total_completed_case_count_applicant->total_count;
             }

             return $this->sendResponseMobileApp('Citizen dashboard data for emc court', $totalCount, $all_appeals);
        }else {
            return  $this->sendError('ইউজার এর তথ্য সঠিক নয়', ['error' => 'ইউজার এর তথ্য সঠিক নয়'], 200);
        }

        
    }

    // case  for gcc citizen
    public function case_for_gcc_citizen(Request $request){
   
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];
        if (!empty($data['case_type'])) {
            $data_type=['closed', 'running', 'pending', 'total'];
            if (!in_array($data['case_type'], $data_type)) {
                return  $this->sendError('মামলার টাইপ সঠিক নয় ', ['error' => 'মামলার টাইপ সঠিক নয় '], 200);
            }
        } else {
            return  $this->sendError('মামলার টাইপ দিন ', ['error' => 'মামলার টাইপ দিন'], 200);
        }
        
        if (globalUserInfo()->citizen_type_id==1) {
             $res = $this->fecthDashboradData_gcc_citizen($data);
            if ($data['case_type']=='pending') {
                $all_appeals = $res->total_pending_case_count_gcc_citizen->all_appeals;
                $totalCount = $res->total_pending_case_count_gcc_citizen->total_count;
            }
            if ($data['case_type']=='total') {
                 $all_appeals = $res->total_case_count_gcc_citizen->all_appeals;
                 $totalCount = $res->total_case_count_gcc_citizen->total_count;
             }
             if ($data['case_type']=='running') {
                 $all_appeals = $res->total_running_case_count_gcc_citizen->all_appeals;
                 $totalCount = $res->total_running_case_count_gcc_citizen->total_count;
             }
             if ($data['case_type']=='closed') {
                 $all_appeals = $res->total_completed_case_count_gcc_citizen->all_appeals;
                 $totalCount = $res->total_completed_case_count_gcc_citizen->total_count;
             }
             
             return $this->sendResponseMobileApp('Citizen dashboard data for gcc court', $totalCount, $all_appeals);
        }else {
            return  $this->sendError('ইউজার এর তথ্য সঠিক নয়', ['error' => 'ইউজার এর তথ্য সঠিক নয়'], 200);
        }

    }

    // case  for gcc org rep
    public function case_for_gcc_org_rep(Request $request){
   
        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];
        if (!empty($data['case_type'])) {
            $data_type=['closed', 'running', 'pending', 'total'];
            if (!in_array($data['case_type'], $data_type)) {
                return  $this->sendError('মামলার টাইপ সঠিক নয় ', ['error' => 'মামলার টাইপ সঠিক নয় '], 200);
            }
        } else {
            return  $this->sendError('মামলার টাইপ দিন ', ['error' => 'মামলার টাইপ দিন'], 200);
        }
        
        if (globalUserInfo()->citizen_type_id==2) {
             $res = $this->fecthDashboradData_gcc_org($data);
            if ($data['case_type']=='pending') {
                $all_appeals = $res->total_pending_case_count_applicant->all_appeals;
                $totalCount = $res->total_pending_case_count_applicant->total_count;
            }
            if ($data['case_type']=='total') {
                 $all_appeals = $res->total_case_count_applicant->all_appeals;
                 $totalCount = $res->total_case_count_applicant->total_count;
             }
             if ($data['case_type']=='running') {
                 $all_appeals = $res->total_running_case_count_applicant->all_appeals;
                 $totalCount = $res->total_running_case_count_applicant->total_count;
             }
             if ($data['case_type']=='closed') {
                 $all_appeals = $res->total_completed_case_count_applicant->all_appeals;
                 $totalCount = $res->total_completed_case_count_applicant->total_count;
             }
             return $this->sendResponseMobileApp('Org Rep dashboard data for gcc court', $totalCount, $all_appeals);
        
        }else {
            return  $this->sendError('ইউজার এর তথ্য সঠিক নয়', ['error' => 'ইউজার এর তথ্য সঠিক নয়'], 200);
        }

    }

    // case details for emc citizen
    public function case_details_for_emc_citizen(Request $request){
   
        $dataPayload = [];
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();

        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];


        $dataPayload['id'] = $data['appeal_id'];
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;

        if (empty($data['appeal_id'])) {
            return  $this->sendError('Missing Appeal Id', ['error' => 'Missing Appeal Id'], 200);
        } 
        
        if (globalUserInfo()->citizen_type_id==1) {
            
            $jsonData = json_encode($data['appeal_id']);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getEmcBaseUrl().'/api/appeal/case/details/apps',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'body_data' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
            if ($res->status==true) {
                $get_data=$res->data;
                // return $get_data;
                
                $manage_data['appeal']=[
                   'appeal_id' =>$get_data->appeal->id,
                   'case_no' =>$get_data->appeal->case_no,
                   'case_date' =>$get_data->appeal->case_date,
                   'appeal_status' =>$get_data->appeal->appeal_status,
                   'next_date_trial_time' =>$get_data->appeal->next_date_trial_time ?? null,
                   'next_date' =>$get_data->appeal->next_date ?? null,
                   'created_at' =>$get_data->appeal->created_at ?? null,
                   'case_details' =>$get_data->appeal->case_details ?? null,
                   'hearing_key' =>$get_data->appeal->hearing_key ?? null,
                   'zoom_join_meeting_id' =>$get_data->appeal->zoom_join_meeting_id ?? null,
                   'zoom_join_meeting_password' =>$get_data->appeal->zoom_join_meeting_password ?? null,
                   'is_hearing_host_active' =>$get_data->appeal->is_hearing_host_active ?? null,
                   'created_user_id' =>$get_data->appeal->created_user_id ?? null,
                   'created_by' =>$get_data->appeal->created_by ?? null,
                   'role_id' =>$get_data->appeal->role_id ?? null,
                   'role_name' =>$get_data->appeal->role_name ?? null,
                   'division_name' =>convert_div_id_to_name($get_data->appeal->division_id) ?? null,
                   'district_name' =>convert_dis_id_to_name($get_data->appeal->district_id) ?? null,
                   'upazila_name' =>convert_upa_id_to_name($get_data->appeal->upazila_id) ?? null,
                ];

               if (date('a', strtotime($get_data->appeal->created_at)) == 'pm') {
                   $time = 'বিকাল';
               } else {
                   $time = 'সকাল';
               };
                $manage_data['placeTime']='বিগত ইং' . en2bn($get_data->appeal->case_date) . ' তারিখ মোতাবেক বাংলা ' . BnSal($get_data->appeal->case_date, 'Asia/Dhaka', 'j F Y') . '। সময়: ' . $time . ' ' . en2bn(date('h:i:s', strtotime($get_data->appeal->created_at))) . '। ' . $get_data->appeal->division_name  . ' বিভাগের ' . $get_data->appeal->district_name . ' জেলার ' . $get_data->appeal->upazila_name . ' থানা/উপজেলায়।';

                $applicantCitizen=[];
                foreach ($get_data->applicantCitizen as $key => $value) {
                   $applicantCitizen=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];
                }
                $manage_data['applicantCitizen']=$applicantCitizen;


                $defaulterCitizen=[];
                foreach ($get_data->defaulterCitizen as $key => $value) {
                   $data_b=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];

                   array_push($defaulterCitizen, $data_b);
                }
                $manage_data['defaulterCitizen']=$defaulterCitizen;


                $guarantorCitizen=[];
                foreach ($get_data->guarantorCitizen as $key => $value) {
                   $data_c=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];

                   array_push($guarantorCitizen, $data_c);
                }
                $manage_data['guarantorCitizen']=$guarantorCitizen;

                $lawerCitizen=[];
                foreach ($get_data->lawerCitizen as $key => $value) {
                   $lawerCitizen=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];
                }
                $manage_data['lawerCitizen']=$lawerCitizen;


                $witnessCitizen=[];
                foreach ($get_data->witnessCitizen as $key => $value) {
                   $data_f=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];

                   array_push($witnessCitizen, $data_f);
                }
                $manage_data['witnessCitizen']=$witnessCitizen;

                $victimCitizen=[];
                foreach ($get_data->victimCitizen as $key => $value) {
                   $data_g=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];

                   array_push($victimCitizen, $data_g);
                }
                $manage_data['victimCitizen']=$victimCitizen;


                $attachmentList=[];
           
                foreach ($get_data->attachmentList as $key => $value) {
                   $attachment=[
                       'id' =>$value->id ?? null,
                       'appeal_id' =>$value->appeal_id ?? null,
                       'cause_list_id' =>$value->cause_list_id ?? null,
                       'conduct_date' =>en2bn($value->created_at) ?? null,
                       'file_type' =>$value->file_type ?? null,
                       'file_category' =>$value->file_category ?? null,
                       'file_name' =>$value->file_name ?? null,
                       'file_path' =>$value->file_path ?? null,
                       'url' => getEmcBaseUrl(). '/'. $value->file_path . $value->file_name,
                   ];

                   array_push($attachmentList, $attachment);
                }
                
                $manage_data['attachmentList']=$attachmentList;
               

                return $this->sendResponseMobileApp('সার্টিফিকেট রিকুইজিশান এর  বিস্তারিত তথ্য', ' ', $manage_data);
            } else {
                return  $this->sendErrorApps('তথ্য পাওয়া যায়নি');
            }
        }else {

            return  $this->sendErrorApps('ইউজার এর তথ্য সঠিক নয়');
        }

    }

    // case details for gcc citizen
    public function case_details_for_gcc_citizen(Request $request){
   
        $dataPayload = [];
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();

        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];


        $dataPayload['id'] = $data['appeal_id'];
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;

        if (empty($data['appeal_id'])) {
            return  $this->sendError('Missing Appeal Id', ['error' => 'Missing Appeal Id'], 200);
        } 
        
        if (globalUserInfo()->citizen_type_id==1) {
            
            $jsonData = json_encode($dataPayload);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getGccBaseUrl() . '/api/gcc/citizen/appeal/case/details/apps',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'body_data' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);

            if ($res->status==true) {
                $get_data=$res->data;
                // return $get_data;
                
                $manage_data['appeal']=[
                   'appeal_id' =>$get_data->appeal->id,
                   'case_no' =>$get_data->appeal->case_no,
                   'case_date' =>$get_data->appeal->case_date,
                   'appeal_status' =>$get_data->appeal->appeal_status,
                   'next_date_trial_time' =>$get_data->appeal->next_date_trial_time ?? null,
                   'next_date' =>$get_data->appeal->next_date ?? null,
                   'created_at' =>$get_data->appeal->created_at ?? null,
                   'case_details' =>$get_data->appeal->case_details ?? null,
                   'hearing_key' =>$get_data->appeal->hearing_key ?? null,
                   'zoom_join_meeting_id' =>$get_data->appeal->zoom_join_meeting_id ?? null,
                   'zoom_join_meeting_password' =>$get_data->appeal->zoom_join_meeting_password ?? null,
                   'is_hearing_host_active' =>$get_data->appeal->is_hearing_host_active ?? null,
                   'created_user_id' =>$get_data->appeal->created_user_id ?? null,
                   'created_by' =>$get_data->appeal->created_by ?? null,
                   'role_id' =>$get_data->appeal->role_id ?? null,
                   'role_name' =>$get_data->appeal->role_name ?? null,
                   'division_name' =>$get_data->appeal->division_name ?? null,
                   'district_name' =>$get_data->appeal->district_name ?? null,
                   'upazila_name' =>$get_data->appeal->upazila_name ?? null,
                ];

               if (date('a', strtotime($get_data->appeal->created_at)) == 'pm') {
                   $time = 'বিকাল';
               } else {
                   $time = 'সকাল';
               };
                $manage_data['placeTime']='বিগত ইং' . en2bn($get_data->appeal->case_date) . ' তারিখ মোতাবেক বাংলা ' . BnSal($get_data->appeal->case_date, 'Asia/Dhaka', 'j F Y') . '। সময়: ' . $time . ' ' . en2bn(date('h:i:s', strtotime($get_data->appeal->created_at))) . '। ' . $get_data->appeal->division_name  . ' বিভাগের ' . $get_data->appeal->district_name . ' জেলার ' . $get_data->appeal->upazila_name . ' থানা/উপজেলায়।';

                $applicantCitizen=[];
                foreach ($get_data->applicantCitizen as $key => $value) {
                   $applicantCitizen=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];
                }
                $manage_data['applicantCitizen']=$applicantCitizen;


                $defaulterCitizen=[];
                foreach ($get_data->defaulterCitizen as $key => $value) {
                   $data_b=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];

                   array_push($defaulterCitizen, $data_b);
                }
                $manage_data['defaulterCitizen']=$defaulterCitizen;


                $guarantorCitizen=[];
                foreach ($get_data->guarantorCitizen as $key => $value) {
                   $data_c=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];

                   array_push($guarantorCitizen, $data_c);
                }
                $manage_data['guarantorCitizen']=$guarantorCitizen;

                $lawerCitizen=[];
                foreach ($get_data->lawerCitizen as $key => $value) {
                   $lawerCitizen=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];
                }
                $manage_data['lawerCitizen']=$lawerCitizen;


                $witnessCitizen=[];
                foreach ($get_data->nomineeCitizen as $key => $value) {
                   $data_f=[
                       'citizen_id' =>$value->id ?? null,
                       'citizen_name' =>$value->citizen_name ?? null,
                       'father' =>$value->father ?? null,
                       'mother' =>$value->mother ?? null,
                       'citizen_gender' =>$value->citizen_gender ?? null,
                       'designation' =>$value->designation ?? null,
                       'present_address' =>$value->present_address ?? null,
                       'email' =>$value->email ?? null,
                   ];

                   array_push($witnessCitizen, $data_f);
                }
                $manage_data['witnessCitizen']=$witnessCitizen;


                $manage_data['victimCitizen']=[];

                $attachmentList=[];
           
                foreach ($get_data->attachmentList as $key => $value) {
                   $attachment=[
                       'id' =>$value->id ?? null,
                       'appeal_id' =>$value->appeal_id ?? null,
                       'cause_list_id' =>$value->cause_list_id ?? null,
                       'conduct_date' =>en2bn($value->created_at) ?? null,
                       'file_type' =>$value->file_type ?? null,
                       'file_category' =>$value->file_category ?? null,
                       'file_name' =>$value->file_name ?? null,
                       'file_path' =>$value->file_path ?? null,
                       'url' => getGccBaseUrl(). '/'. $value->file_path . $value->file_name,
                   ];

                   array_push($attachmentList, $attachment);
                }
                
                $manage_data['attachmentList']=$attachmentList;
               

                return $this->sendResponseMobileApp('সার্টিফিকেট রিকুইজিশান এর  বিস্তারিত তথ্য', ' ', $manage_data);
            } else {
                return  $this->sendErrorApps('তথ্য পাওয়া যায়নি');
            }

        }else {
            return  $this->sendErrorApps('ইউজার এর তথ্য সঠিক নয়');
        }

    }

    // case details for gcc org rep
    public function case_details_for_gcc_org_rep(Request $request){
   
        $dataPayload = [];
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();

        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];


        $dataPayload['id'] = $data['appeal_id'];
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;

        if (empty($data['appeal_id'])) {
            return  $this->sendError('Missing Appeal Id', ['error' => 'Missing Appeal Id'], 200);
        } 
        
        if (globalUserInfo()->citizen_type_id==2) {
            
            $jsonData = json_encode($dataPayload);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getGccBaseUrl() . '/api/gcc/appeal/case/details/apps',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'body_data' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
            
            if ($res->status==true) {
                 $get_data=$res->data;
                //  return $get_data;
                 
                 $manage_data['appeal']=[
                    'appeal_id' =>$get_data->appeal->id,
                    'case_no' =>$get_data->appeal->case_no,
                    'case_date' =>$get_data->appeal->case_date,
                    'appeal_status' =>$get_data->appeal->appeal_status,
                    'next_date_trial_time' =>$get_data->appeal->next_date_trial_time ?? null,
                    'next_date' =>$get_data->appeal->next_date ?? null,
                    'created_at' =>$get_data->appeal->created_at ?? null,
                    'case_details' =>$get_data->appeal->case_details ?? null,
                    'hearing_key' =>$get_data->appeal->hearing_key ?? null,
                    'zoom_join_meeting_id' =>$get_data->appeal->zoom_join_meeting_id ?? null,
                    'zoom_join_meeting_password' =>$get_data->appeal->zoom_join_meeting_password ?? null,
                    'is_hearing_host_active' =>$get_data->appeal->is_hearing_host_active ?? null,
                    'created_user_id' =>$get_data->appeal->created_user_id ?? null,
                    'created_by' =>$get_data->appeal->created_by ?? null,
                    'role_id' =>$get_data->appeal->role_id ?? null,
                    'role_name' =>$get_data->appeal->role_name ?? null,
                    'division_name' =>$get_data->appeal->division_name ?? null,
                    'district_name' =>$get_data->appeal->district_name ?? null,
                    'upazila_name' =>$get_data->appeal->upazila_name ?? null,
                 ];

                if (date('a', strtotime($get_data->appeal->created_at)) == 'pm') {
                    $time = 'বিকাল';
                } else {
                    $time = 'সকাল';
                };
                 $manage_data['placeTime']='বিগত ইং' . en2bn($get_data->appeal->case_date) . ' তারিখ মোতাবেক বাংলা ' . BnSal($get_data->appeal->case_date, 'Asia/Dhaka', 'j F Y') . '। সময়: ' . $time . ' ' . en2bn(date('h:i:s', strtotime($get_data->appeal->created_at))) . '। ' . $get_data->appeal->division_name  . ' বিভাগের ' . $get_data->appeal->district_name . ' জেলার ' . $get_data->appeal->upazila_name . ' থানা/উপজেলায়।';

                 $applicantCitizen=[];
                 foreach ($get_data->applicantCitizen as $key => $value) {
                    $applicantCitizen=[
                        'citizen_id' =>$value->id ?? null,
                        'citizen_name' =>$value->citizen_name ?? null,
                        'father' =>$value->father ?? null,
                        'mother' =>$value->mother ?? null,
                        'citizen_gender' =>$value->citizen_gender ?? null,
                        'designation' =>$value->designation ?? null,
                        'present_address' =>$value->present_address ?? null,
                        'email' =>$value->email ?? null,
                    ];
                 }
                 $manage_data['applicantCitizen']=$applicantCitizen;


                 $defaulterCitizen=[];
                 foreach ($get_data->defaulterCitizen as $key => $value) {
                    $data_b=[
                        'citizen_id' =>$value->id ?? null,
                        'citizen_name' =>$value->citizen_name ?? null,
                        'father' =>$value->father ?? null,
                        'mother' =>$value->mother ?? null,
                        'citizen_gender' =>$value->citizen_gender ?? null,
                        'designation' =>$value->designation ?? null,
                        'present_address' =>$value->present_address ?? null,
                        'email' =>$value->email ?? null,
                    ];

                    array_push($defaulterCitizen, $data_b);
                 }
                 $manage_data['defaulterCitizen']=$defaulterCitizen;


                 $guarantorCitizen=[];
                 foreach ($get_data->guarantorCitizen as $key => $value) {
                    $data_c=[
                        'citizen_id' =>$value->id ?? null,
                        'citizen_name' =>$value->citizen_name ?? null,
                        'father' =>$value->father ?? null,
                        'mother' =>$value->mother ?? null,
                        'citizen_gender' =>$value->citizen_gender ?? null,
                        'designation' =>$value->designation ?? null,
                        'present_address' =>$value->present_address ?? null,
                        'email' =>$value->email ?? null,
                    ];

                    array_push($guarantorCitizen, $data_c);
                 }
                 $manage_data['guarantorCitizen']=$guarantorCitizen;

                 $lawerCitizen=[];
                 foreach ($get_data->lawerCitizen as $key => $value) {
                    $lawerCitizen=[
                        'citizen_id' =>$value->id ?? null,
                        'citizen_name' =>$value->citizen_name ?? null,
                        'father' =>$value->father ?? null,
                        'mother' =>$value->mother ?? null,
                        'citizen_gender' =>$value->citizen_gender ?? null,
                        'designation' =>$value->designation ?? null,
                        'present_address' =>$value->present_address ?? null,
                        'email' =>$value->email ?? null,
                    ];
                 }
                 $manage_data['lawerCitizen']=$lawerCitizen;


                 $witnessCitizen=[];
                 foreach ($get_data->nomineeCitizen as $key => $value) {
                    $data_f=[
                        'citizen_id' =>$value->id ?? null,
                        'citizen_name' =>$value->citizen_name ?? null,
                        'father' =>$value->father ?? null,
                        'mother' =>$value->mother ?? null,
                        'citizen_gender' =>$value->citizen_gender ?? null,
                        'designation' =>$value->designation ?? null,
                        'present_address' =>$value->present_address ?? null,
                        'email' =>$value->email ?? null,
                    ];

                    array_push($witnessCitizen, $data_f);
                 }
                 $manage_data['witnessCitizen']=$witnessCitizen;


                 $manage_data['victimCitizen']=[];

                 $attachmentList=[];
            
                 foreach ($get_data->attachmentList as $key => $value) {
                    $attachment=[
                        'id' =>$value->id ?? null,
                        'appeal_id' =>$value->appeal_id ?? null,
                        'cause_list_id' =>$value->cause_list_id ?? null,
                        'conduct_date' =>en2bn($value->created_at) ?? null,
                        'file_type' =>$value->file_type ?? null,
                        'file_category' =>$value->file_category ?? null,
                        'file_name' =>$value->file_name ?? null,
                        'file_path' =>$value->file_path ?? null,
                        'url' => getGccBaseUrl(). '/'. $value->file_path . $value->file_name,
                    ];

                    array_push($attachmentList, $attachment);
                 }
                 
                 $manage_data['attachmentList']=$attachmentList;
                

                 return $this->sendResponseMobileApp('সার্টিফিকেট রিকুইজিশান এর  বিস্তারিত তথ্য', ' ', $manage_data);
            } else {

                return  $this->sendErrorApps('তথ্য পাওয়া যায়নি');
            }
            

        }else {

            return  $this->sendErrorApps('ইউজার এর তথ্য সঠিক নয়');
        }

    }

    // case tracking for emc citizen
    public function case_tracking_for_emc_citizen(Request $request){
   
        $dataPayload = [];
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();

        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];


        $dataPayload['id'] = $data['appeal_id'];
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;

        if (empty($data['appeal_id'])) {
            return  $this->sendError('Missing Appeal Id', ['error' => 'Missing Appeal Id'], 200);
        } 
        
        if (globalUserInfo()->citizen_type_id==1) {
            
            $jsonData = json_encode($data['appeal_id']);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getEmcBaseUrl().'/api/traking/apps',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'body_data' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
          
            if ($res->status==true) {
             
                $get_data  = $res->data;

                $manage_data['appeal']=[
                    'appeal_id' =>$get_data->appeal->id,
                    'case_no' =>$get_data->appeal->case_no,
                    'case_date' =>$get_data->appeal->case_date,
                    'appeal_status' =>$get_data->appeal->appeal_status,
                    'next_date_trial_time' =>$get_data->appeal->next_date_trial_time ?? null,
                    'next_date' =>$get_data->appeal->next_date ?? null,
                    'created_at' =>$get_data->appeal->created_at ?? null,
                    'case_details' =>$get_data->appeal->case_details ?? null,
                    'hearing_key' =>$get_data->appeal->hearing_key ?? null,
                    'zoom_join_meeting_id' =>$get_data->appeal->zoom_join_meeting_id ?? null,
                    'zoom_join_meeting_password' =>$get_data->appeal->zoom_join_meeting_password ?? null,
                    'is_hearing_host_active' =>$get_data->appeal->is_hearing_host_active ?? null,
                    'created_user_id' =>$get_data->appeal->created_user_id ?? null,
                    'created_by' =>$get_data->appeal->created_by ?? null,
                    'role_id' =>$get_data->appeal->role_id ?? null,
                    'role_name' =>$get_data->appeal->role_name ?? null,
                    'division_name' =>convert_div_id_to_name($get_data->appeal->division_id) ?? null,
                    'district_name' =>convert_dis_id_to_name($get_data->appeal->district_id) ?? null,
                    'upazila_name' =>convert_upa_id_to_name($get_data->appeal->upazila_id) ?? null,
                ];
                $CaseTracking=[];

                foreach ($get_data->shortOrderNameList as $key => $value) {
                    $data_f=[
                        'conduct_date' =>$value->conduct_date ?? null,
                        'case_short_decision' =>$value->short_order_name ?? null,
                    ];

                    array_push($CaseTracking, $data_f);
                 }

                $manage_data['CaseTracking']=$CaseTracking;

                return $this->sendResponseMobileApp('মামলা ট্র্যাকিং', ' ', $manage_data);
            } else {

                return  $this->sendErrorApps('তথ্য পাওয়া যায়নি');
            }
            
        
        }else {

            return  $this->sendErrorApps('ইউজার এর তথ্য সঠিক নয়');
        }

    }

    // case tracking for gcc citizen
    public function case_tracking_for_gcc_citizen(Request $request){
   
        $dataPayload = [];
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();

        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];


        $dataPayload['id'] = $data['appeal_id'];
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;

        if (empty($data['appeal_id'])) {
            return  $this->sendError('Missing Appeal Id', ['error' => 'Missing Appeal Id'], 200);
        } 
        
        if (globalUserInfo()->citizen_type_id==1) {
            
            $jsonData = json_encode($dataPayload);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getGccBaseUrl() . '/api/gcc/appeal/case/tracking/apps',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'body_data' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
            if ($res->status==true) {
             
                $get_data  = $res->data;

                $manage_data['appeal']=[
                    'appeal_id' =>$get_data->appeal->id,
                    'case_no' =>$get_data->appeal->case_no,
                    'case_date' =>$get_data->appeal->case_date,
                    'appeal_status' =>$get_data->appeal->appeal_status,
                    'next_date_trial_time' =>$get_data->appeal->next_date_trial_time ?? null,
                    'next_date' =>$get_data->appeal->next_date ?? null,
                    'created_at' =>$get_data->appeal->created_at ?? null,
                    'case_details' =>$get_data->appeal->case_details ?? null,
                    'hearing_key' =>$get_data->appeal->hearing_key ?? null,
                    'zoom_join_meeting_id' =>$get_data->appeal->zoom_join_meeting_id ?? null,
                    'zoom_join_meeting_password' =>$get_data->appeal->zoom_join_meeting_password ?? null,
                    'is_hearing_host_active' =>$get_data->appeal->is_hearing_host_active ?? null,
                    'created_user_id' =>$get_data->appeal->created_user_id ?? null,
                    'created_by' =>$get_data->appeal->created_by ?? null,
                    'role_id' =>$get_data->appeal->role_id ?? null,
                    'role_name' =>$get_data->appeal->role_name ?? null,
                    'division_name' =>$get_data->appeal->division_name ?? null,
                    'district_name' =>$get_data->appeal->district_name ?? null,
                    'upazila_name' =>$get_data->appeal->upazila_name ?? null,
                ];
                $CaseTracking=[];

                foreach ($get_data->shortOrderTemplateList as $key => $value) {
                    $data_f=[
                        'conduct_date' =>$value->conduct_date ?? null,
                        'case_short_decision' =>$value->case_short_decision ?? null,
                    ];

                    array_push($CaseTracking, $data_f);
                 }

                $manage_data['CaseTracking']=$CaseTracking;

                return $this->sendResponseMobileApp('মামলা ট্র্যাকিং', ' ', $manage_data);
            } else {

                return  $this->sendErrorApps('তথ্য পাওয়া যায়নি');
            }
        
        }else {
            return  $this->sendErrorApps('ইউজার এর তথ্য সঠিক নয়');
        }

    }

    // case tracking for gcc org rep
    public function case_tracking_for_gcc_org_rep(Request $request){
   
        $dataPayload = [];
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();

        $jsonString = $request->getContent();
        $datas = json_decode($jsonString, true);
        $data = $datas['body_data'];


        $dataPayload['id'] = $data['appeal_id'];
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;

        if (empty($data['appeal_id'])) {
            return  $this->sendError('Missing Appeal Id', ['error' => 'Missing Appeal Id'], 200);
        } 
        
        if (globalUserInfo()->citizen_type_id==2) {
            
            $jsonData = json_encode($dataPayload);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getGccBaseUrl() . '/api/gcc/appeal/case/tracking/apps',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'body_data' => $jsonData
                ),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:common-court",

                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response);
            
            if ($res->status==true) {
             
                $get_data  = $res->data;

                $manage_data['appeal']=[
                    'appeal_id' =>$get_data->appeal->id,
                    'case_no' =>$get_data->appeal->case_no,
                    'case_date' =>$get_data->appeal->case_date,
                    'appeal_status' =>$get_data->appeal->appeal_status,
                    'next_date_trial_time' =>$get_data->appeal->next_date_trial_time ?? null,
                    'next_date' =>$get_data->appeal->next_date ?? null,
                    'created_at' =>$get_data->appeal->created_at ?? null,
                    'case_details' =>$get_data->appeal->case_details ?? null,
                    'hearing_key' =>$get_data->appeal->hearing_key ?? null,
                    'zoom_join_meeting_id' =>$get_data->appeal->zoom_join_meeting_id ?? null,
                    'zoom_join_meeting_password' =>$get_data->appeal->zoom_join_meeting_password ?? null,
                    'is_hearing_host_active' =>$get_data->appeal->is_hearing_host_active ?? null,
                    'created_user_id' =>$get_data->appeal->created_user_id ?? null,
                    'created_by' =>$get_data->appeal->created_by ?? null,
                    'role_id' =>$get_data->appeal->role_id ?? null,
                    'role_name' =>$get_data->appeal->role_name ?? null,
                    'division_name' =>$get_data->appeal->division_name ?? null,
                    'district_name' =>$get_data->appeal->district_name ?? null,
                    'upazila_name' =>$get_data->appeal->upazila_name ?? null,
                ];
                $CaseTracking=[];

                foreach ($get_data->shortOrderTemplateList as $key => $value) {
                    $data_f=[
                        'conduct_date' =>$value->conduct_date ?? null,
                        'case_short_decision' =>$value->case_short_decision ?? null,
                    ];

                    array_push($CaseTracking, $data_f);
                 }

                $manage_data['CaseTracking']=$CaseTracking;

                return $this->sendResponseMobileApp('মামলা ট্র্যাকিং', ' ', $manage_data);
            } else {

                return  $this->sendErrorApps('তথ্য পাওয়া যায়নি');
            }
            
        
        }else {
            return  $this->sendErrorApps('ইউজার এর তথ্য সঠিক নয়');
        }

    }
}
