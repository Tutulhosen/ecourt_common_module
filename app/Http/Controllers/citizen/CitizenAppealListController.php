<?php

namespace App\Http\Controllers\citizen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;

class CitizenAppealListController extends Controller
{
    use TokenVerificationTrait;
    public function all_case()
    {
        $res = $this->fecthDashboradData();
        $all_appeals = $res->total_case_count_applicant->all_appeals;


        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd(/* $ct_info->citizen_name */ $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'সকল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function running_case()
    {

        $res = $this->fecthDashboradData();
        $all_appeals = $res->total_running_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            $ct_info = DB::table('ecourt_citizens')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        $page_title = 'চলমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function pending_case()
    {

        $res = $this->fecthDashboradData();

        $all_appeals = $res->total_pending_case_count_applicant->all_appeals;
        // dd($all_appeals);
        foreach ($all_appeals as $single_appeal) {

            $ct_info = DB::table('users')
                ->where('users.id', $single_appeal->created_by)
                ->join('ecourt_citizens', 'users.citizen_id', 'ecourt_citizens.id')
                ->select('ecourt_citizens.citizen_name')
                ->first();
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;



        $page_title = 'অপেক্ষমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function complete_case()
    {

        $res = $this->fecthDashboradData();
        $all_appeals = $res->total_completed_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            $ct_info = DB::table('ecourt_citizens')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        $page_title = 'নিস্পত্তি মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }

    public function case_for_all_appeal_case()
    {
        $res = $this->fecthDashboradData();
        $all_appeals = $res->total_appeal_case_count_applicant->all_appeals;


        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd(/* $ct_info->citizen_name */ $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'সকল আপিল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function case_for_running_appeal_case()
    {

        $res = $this->fecthDashboradData();
        $all_appeals = $res->total_running_appeal_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            $ct_info = DB::table('ecourt_citizens')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        $page_title = 'চলমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function case_for_pending_appeal_case()
    {

        $res = $this->fecthDashboradData();
        $all_appeals = $res->total_pending_appeal_case_count_applicant->all_appeals;
        // dd($res);

        foreach ($all_appeals as $single_appeal) {

            $ct_info = DB::table('users')
                ->where('users.id', $single_appeal->created_by)
                ->join('ecourt_citizens', 'users.citizen_id', 'ecourt_citizens.id')
                ->select('ecourt_citizens.citizen_name')
                ->first();
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;



        $page_title = 'অপেক্ষমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function case_for_complete_appeal_case()
    {

        $res = $this->fecthDashboradData();
        $all_appeals = $res->total_completed_appeal_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            $ct_info = DB::table('ecourt_citizens')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        $page_title = 'নিস্পত্তি মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }

    //fatch data from api manager for dashboard
    public function fecthDashboradData()
    {
        $user = Auth::user();
        $citizen_info = DB::table('users')
            ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
            ->select('ecourt_citizens.citizen_NID', 'ecourt_citizens.organization_id')
            ->where('users.id', $user->id)
            ->where('ecourt_citizens.citizen_type_id', 1)
            ->first();
        //  return [$user, $citizen_info];  
        $auth_user = [
            'citizen_nid' => $citizen_info->citizen_NID,
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
        // if (!empty($res)) {

        return $res;
    }

    //citizen case traking
    public function showAppealTrakingPage($id)
    {
        $id = decrypt($id);
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($id);
            $url = getapiManagerBaseUrl() . '/api/v1/traking';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);
            
            if ($result['success'] == true) {

                $data['appeal']  = $result['data']['appeal'];
                $user_id = $data['appeal']['created_by'];
             
                $data['applicant_name'] = DB::table('users')->where('id', $user_id)->first()->name ?? null;
                // dd($data['applicant_name']);
                $data['applicant_type'] = $data['appeal']['office_unit_name'];



                $data['shortOrderNameList'] = $result['data']['shortOrderNameList'];

                
                $data['page_title'] = 'মামলা ট্র্যাকিং';
                // return $data["notes"];
                return view('appealView.appealCaseTraking')->with($data);
            } else {
            }
        }
    }

    //citizen appeal case details
    public function showAppealCaseDetails($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();
        // dd($id);
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($id);
            $url = getapiManagerBaseUrl() . '/api/v1/appeal/case/details';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);
            // dd($result['data']);
            if ($result['success'] == true) {

                $data['appeal']  = $result['data']['appeal'];
                $data['appeal_all']  = $result['data']['all_data'];
                $data["notes"] = $result['data']['notes'];
                $data["districtId"] = $officeInfo->district_id;
                $data["divisionId"] = $officeInfo->division_id;
                $data["office_id"] = $office_id;
                $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();
                $data["appeal_id"] = $id;
                $data['page_title'] = 'মামলার বিস্তারিত তথ্য';
                // dd($data);
                return view('appealView.appealView')->with($data);
            } else {
            }
        }
    }

    //citizen appeal case details
    public function CaseAppeal($id)
    {
        $data['id'] = decrypt($id);
        // dd($id);
        $data['user'] = globalUserInfo();

        // dd($user);
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($data);
            $url = getapiManagerBaseUrl() . '/api/v1/case/for/appeal';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);
            // dd($result['data']['all_appeal_list']);
            if ($result['success'] == true) {

                $data['page_title'] = 'আপীল মামলার তালিকা';
                $data['results'] = $result['data']['all_appeal_list'];
                // dd($data);
                return view('gcc_citizenAppealList.caseForAppeal')->with($data);
            } else {
            }
        }
    }
}