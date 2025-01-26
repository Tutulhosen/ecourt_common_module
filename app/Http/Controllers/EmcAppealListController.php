<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;


class EmcAppealListController extends Controller
{
    use TokenVerificationTrait;

    public function closed_list(Request $request)
    {
         
        $url = getapiManagerBaseUrl() . '/api/emc/appeal/closed-list';
        $method = 'POST';
        $bodyData = null;

        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
        $page_title = 'Emc-নিষ্পত্তিকৃত মামলার তালিকা';
        $results = $res->data;
        // dd($results);
        return view('archiveList.emc.emcAppealCasewiseList', compact('page_title', 'results'));
    }

    public function closed_list_search(Request $request)
    {   
        $page_title = 'Emc-নিষ্পত্তিকৃত মামলার তালিকা';
        $datas['date_start']=$request->date_start;
        $datas['date_end']=$request->date_end;
        $datas['case_no']=$request->case_no;
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/emc/appeal/closed-list/search';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res);   

            if ($res['success']) {
                $results = $res['data'];
                // dd($results);
                return view('archiveList.emc.emcAppealCasewiseListSearch', compact('page_title', 'results'));
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }
    public function old_closed_list(Request $request)
    {  
        $url = getapiManagerBaseUrl() . '/api/emc/appeal/old-closed-list';
        $method = 'POST';
        $bodyData = null;
        $token = $this->verifySiModuleToken('WEB');
        // dd($token);
        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
        $results = $res->data;
        // dd($results);
        $page_title ='পুরাতন নিষ্পত্তিকৃত মামলা';

        return view('archiveList.emc.emcOldAppealCasewiseList', compact('results', 'page_title'));
    }
    public function old_closed_list_search(Request $request)
    {   
        $page_title = 'Emc-নিষ্পত্তিকৃত মামলার তালিকা';
        $datas['date_start']=$request->date_start;
        $datas['date_end']=$request->date_end;
        $datas['case_no']=$request->case_no;
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/emc/appeal/old-closed-list/search';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res);   

            if ($res['success']) {
                $results = $res['data'];
                // dd($results);
                return view('archiveList.emc.emcOldAppealCasewiseListSearch', compact('page_title', 'results'));
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }
    public function showAppealViewPage(Request $request, $ids='')
    {
        $id = decrypt($ids);
        $url = getapiManagerBaseUrl() . '/api/emc/appeal/old-closed-list/details/'. $id;
        $method = 'POST';
        $bodyData = $id;
        $token = $this->verifySiModuleToken('WEB');
        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
       
        $case_details  = $res->data->details;
        $crpc_name  = $res->data->crpc_name;
        $all_dis_div_upa  = $res->data->all_dis_div_upa;
        $url  = $res->data->url;
       
        $page_title ='পুরাতন নিষ্পত্তিকৃত মামলা';
        return view('archiveList.emc.archive_details', compact('case_details', 'page_title','crpc_name','all_dis_div_upa','url'));
        
    }

    public function generate_pdf($id){
    
        $id = decrypt($id);
        $url = getapiManagerBaseUrl() . '/api/emc/generate-pdf/'. $id;
        $method = 'POST';
        $bodyData = $id;
        $token = $this->verifySiModuleToken('WEB');
        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
        $data=[];
        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলার বিবরণ';
        $data['attachmentList']=$res->data->attachmentList;
        $data['url']=$res->data->url;
     
        return view('archiveList.emc.generate_pdf')->with($data);
    }


    public function showAppealDetails(Request $request, $id)
    {   
        $datas['case_id']=decrypt($id);
        $datas['auth_user_info']=Auth::user();
        $officeInfo = user_office_info();
        // dd($officeInfo);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/emc/appeal/closed-list/details';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res['data']['lawerCitizen']['citizen_name']);   

            if ($res['success']) {

                $data['appeal']  = $res['data']['appeal'];
                $data["notes"] = $res['data']['notes'];
                $data["districtId"]= $officeInfo->district_id;
                $data["divisionId"]=$officeInfo->division_id;
                $data["office_id"] = Auth::user()->office->id;
                $data['results'] = $res['data'];
                // dd($data);
                return view('appealView.emcAppealviewForAdmin')->with($data);
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    public function case_traking($id)
    {   
        $datas['case_id']=decrypt($id);
        $datas['auth_user_info']=Auth::user();
    
        // dd($datas);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/emc/appeal/closed-list/case-traking';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res['data']['shortOrderNameList']);   

            if ($res['success']) {

                $data['appeal']  = $res['data']['appeal'];
                $data['shortOrderNameList'] = $res['data']['shortOrderNameList'];
                $data['page_title'] = $res['data']['page_title'];
                // dd($data);
                return view('appealView.emcAppealCaseTraking')->with($data);
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    public function emc_close_case_nothiView($id)
    {   
        $datas['case_id']=decrypt($id);
        $datas['auth_user_info']=Auth::user();
        $officeInfo = user_office_info();
        // dd($datas);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/emc/appeal/closed-list/nothiView';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res['data']['citizenAttendanceList']);   

            if ($res['success']) {

                $caseNumber = $res['data']['caseNumber'];
                $appealId = $res['data']['appealId'];
                $nothiData = $res['data']['nothiData'];
                $citizenAttendanceList = $res['data']['citizenAttendanceList'];
                $shortOrderTemplateList = $res['data']['shortOrderTemplateList'];
                $page_title  = $res['data']['page_title'];
                // dd($data);
                return view('appealView.emcAppealnothiView', compact('nothiData', 'appealId', 'shortOrderTemplateList', 'citizenAttendanceList', 'page_title'));
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    public function emc_close_case_orderSheetDetails($id)
    {   
        $datas['case_id']=$id;
        $datas['auth_user_info']=Auth::user();
        $officeInfo = user_office_info();
        // dd($datas);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/emc/appeal/closed-list/orderSheetDetails';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res['data']['data_image_path']);   

            if ($res['success']) {

                $data['data_image_path']=$res['data']['data_image_path'];

                $data['appealOrderLists'] = $res['data']['appealOrderLists'];
                $data['nothi_id'] = $res['data']['nothi_id'];
                $data['page_title'] = $res['data']['page_title'];
                return view('appealView.emcAppealorderSheetDetails')->with($data);
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    public function emc_close_case_shortOrderSheets($id)
    {   
        $datas['case_id']=$id;

        // dd($datas);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/emc/appeal/closed-list/shortOrderSheets';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res);   

            if ($res['success']) {

                $data['data_image_path']=$res['data']['data_image_path'];

                $data['appealShortOrderLists'] = $res['data']['appealShortOrderLists'];
                $data['nothi_id'] = $res['data']['nothi_id'];
                $data['page_title'] = $res['data']['page_title'];

                return view('appealView.emcAppealshortOrderSheets')->with($data);
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }





}
