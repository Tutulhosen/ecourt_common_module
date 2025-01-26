<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class GccParentOfficeController extends Controller
{
    use TokenVerificationTrait;
    
    public function all_case_for_parent($status)
    {
        $user = Auth::guard('parent_office')->user();
        $auth_user = ['parent_id' => $user->id];
        $token = $this->verifySiModuleToken('WEB');
        // dd($token);
        if ($token) {
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/dashboard/parent/office';
            $method = 'POST';
            $bodyData = json_encode($auth_user);
            // dd($bodyData);
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            if ($res['success']) {
                $result = $res['data'];

                $results = [];
                if ($status == 'total_case') {
                    $results = $result['total_case']['total_data'];
                }
                if ($status == 'running_case') {
                    $results = $result['running_case']['total_data'];
                }
                if ($status == 'panding_case') {
                    $results = $result['pending_case']['total_data'];
                }
                if ($status == 'close_case') {
                    $results = $result['completed_case']['total_data'];
                }

                

                // Paginate results with 10 items per page
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 10;
                $currentItems = array_slice($results, ($currentPage - 1) * $perPage, $perPage);
                $paginatedResults = new LengthAwarePaginator($currentItems, count($results), $perPage);
                $paginatedResults->setPath(request()->url());

                $page_title = 'সকল মামলার তালিকা';
                return view('parent_office.caseWiseAppealList', compact('paginatedResults', 'page_title'));
            }
        }
    }

    public function case_traking($id){
        // dd('hi');
        // $id = decrypt($id);
        $id = ['parent_id' => decrypt($id)];
        $token = $this->verifySiModuleToken('WEB');
        // dd($token);
        if ($token) {
            $jsonData = json_encode($id);
            $url=getapiManagerBaseUrl().'/api/v1/parent/office/traking';
            $method = 'POST';
            $bodyData = $jsonData;
            // dd($bodyData);
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            if ($res['success']==true) {

                // dd($res['data']);
         
                $data['shortOrderTemplateList']=$res['data']['shortOrderNameList'];
                $data['appeal']=$res['data']['appeal'];

                $data['page_title'] = 'মামলা ট্র্যাকিং';
                // return $data["notes"];
                return view('appealView.gccAppealCaseTraking')->with($data);
            } else {
                
            }
            
           
        }
    }

    public function showAppealViewPage($id){
        // dd('hi');
        // $id = decrypt($id);
        $id = ['parent_id' => decrypt($id)];
        $token = $this->verifySiModuleToken('WEB');
        // dd($token);
        if ($token) {
            $jsonData = json_encode($id);
            $url=getapiManagerBaseUrl().'/api/v1/parent/office/appeal/details';
            $method = 'POST';
            $bodyData = $jsonData;
            // dd($bodyData);
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            if ($res['success']==true) {

                // dd($res['data']);
                $data['appeal']  = $res['data']['appeal'];
                $data["applicantCitizen"] = $res['data']['applicantCitizen'];
                $data["defaulterCitizen"] = $res['data']['defaulterCitizen'];
                $data["nomineeCitizen"] = $res['data']['nomineeCitizen'];
                $data["notes"] = $res['data']['notes'];
                $data["attachmentList"] = $res['data']['attachmentList'];
                $data['page_title'] = $res['data']['page_title'];
                // return $data["notes"];
                // dd($data);
                return view('appealView.gccParentAppealView')->with($data);
            } else {
                
            }
            
           
        }
    }
}
