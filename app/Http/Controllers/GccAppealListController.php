<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TokenVerificationTrait;
use Illuminate\Support\Facades\Auth;

class GccAppealListController extends Controller
{

    use TokenVerificationTrait;

    public function closed_list(Request $request)
    {   
        $url = getapiManagerBaseUrl() . '/api/gcc/appeal/closed-list';
        $method = 'POST';
        $bodyData = null;

        $token = $this->verifySiModuleToken('WEB');

        
        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
        $page_title = 'Gcc-নিষ্পত্তিকৃত মামলার তালিকা';
        $results = $res->data;
        // dd($results);
        return view('archiveList.gcc.gccAppealCasewiseList', compact('page_title', 'results'));
    }

    public function closed_list_search(Request $request)
    {   
        $page_title = 'Gcc-নিষ্পত্তিকৃত মামলার তালিকা';
        $datas['date_start']=$request->date_start;
        $datas['date_end']=$request->date_end;
        $datas['case_no']=$request->case_no;
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/gcc/appeal/closed-list/search';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res);   

            if ($res['success']) {
                $results = $res['data'];
                // dd($results);
                return view('archiveList.gcc.gccAppealCasewiseListSearch', compact('page_title', 'results'));
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    public function closed_list_details($id){
        $datas['case_id']=decrypt($id);
        $datas['auth_user_info']=Auth::user();
        $officeInfo = user_office_info();
        // dd($officeInfo);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/gcc/appeal/closed-list/details';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res);   

            if ($res['success']) {
                $data["districtId"]= $officeInfo->district_id;
                $data["divisionId"]=$officeInfo->division_id;
                $data["office_id"] = Auth::user()->office->id;
                $data['results'] = $res['data'];
                
                // dd($data);
                return view('appealView.appealViewFromAdmin')->with($data);
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    public function closed_list_nothi($id){
        $datas['case_id']=decrypt($id);
   
        // dd($datas);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/gcc/appeal/closed-list/nothi';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res['data']['caseInfo']);   

            if ($res['success']) {
                $caseNumber = $res['data']['caseNumber'];
                $caseInfo = $res['data']['caseInfo'];
                $nothiData = $res['data']['nothiData'];
                $citizenAttendanceList = $res['data']['citizenAttendanceList'];
                $shortOrderTemplateList=$res['data']['shortOrderTemplateList'];
                $paymentAttachment=$res['data']['paymentAttachment'];
                $page_title  = $res['data']['page_title'];

                return view('appealView.appealNothiAdmin', compact('nothiData','caseInfo','shortOrderTemplateList','paymentAttachment','citizenAttendanceList', 'page_title'));
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    public function old_closed_list(Request $request)
    {
        $url = getapiManagerBaseUrl() . '/api/gcc/appeal/old-closed-list';
        $method = 'POST';
        $bodyData = null;
        $token = $this->verifySiModuleToken('WEB');
        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
        $results = $res->data;
        $page_title = 'পুরাতন নিষ্পত্তিকৃত মামলা';

        return view('archiveList.gcc.gccOldAppealCasewiseList', compact('results', 'page_title'));
    }

    public function old_closed_list_search(Request $request)
    {   
        $page_title = 'gcc-নিষ্পত্তিকৃত মামলার তালিকা';
        $datas['date_start']=$request->date_start;
        $datas['date_end']=$request->date_end;
        $datas['case_no']=$request->case_no;
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/gcc/appeal/old-closed-list/search';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res);   

            if ($res['success']) {
                $results = $res['data'];
                // dd($results);
                return view('archiveList.gcc.gccOldAppealCasewiseListSearch', compact('page_title', 'results'));
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
        
    }

    

    public function showAppealViewPage(Request $request, $ids='')
    {
        $id = decrypt($ids);
        $url = getapiManagerBaseUrl() . '/api/gcc/appeal/old-closed-list/details/'. $id;
        $method = 'POST';
        $bodyData = $id;
        $token = $this->verifySiModuleToken('WEB');
        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
    //    dd($res);
        $case_details  = $res->data->details;
        // $crpc_name  = $res->data->crpc_name;
        $all_dis_div_upa  = $res->data->all_dis_div_upa;
        $url  = $res->data->url;
       
        $page_title ='পুরাতন নিষ্পত্তিকৃত মামলা';
        return view('archiveList.gcc.archive_details', compact('case_details', 'page_title','all_dis_div_upa','url'));
        
    }

    public function generate_pdf($id){
    
        $id = decrypt($id);
        $url = getapiManagerBaseUrl() . '/api/gcc/generate-pdf/'. $id;
        $method = 'POST';
        $bodyData = $id;
        $token = $this->verifySiModuleToken('WEB');
        $data = json_encode($bodyData);
        $res = makeCurlRequestWithToken($url, $method, $data, $token);
        // dd( $res);
        $data=[];
        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলার বিবরণ';
        $data['attachmentList']=$res->data->attachmentList;
        $data['url']=$res->data->url;
     
        return view('archiveList.gcc.generate_pdf')->with($data);
    }


    //appeal order sheet
    public function gcc_appeal_order_sheet(Request $request, $id){
        $datas['id']=decrypt($id);
   
        // dd($datas);
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/gcc/appeal/short/order';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res['data']['data_image_path']);

            if ($res['success']) {
                $data['data_image_path'] = $res['data']['data_image_path'];
                $data['appealOrderLists'] = $res['data']['appealOrderLists'];
                $data['nothi_id'] = $res['data']['nothi_id'];
                $data['page_title'] = $res['data']['page_title'];
                return view('nothiList.nothiOrderSheetDetails')->with($data);
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
    }

    //appeal order sheet
    public function gcc_appeal_short_order_sheet(Request $request, $id){
        $datas['id']=$id;
   
      
        $token = $this->verifySiModuleToken('WEB');

        if ($token) {
            $jsonData = json_encode($datas, true);

            $url = getapiManagerBaseUrl() . '/api/gcc/appeal/short/order/temp';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            $res = json_decode($response, true);
            // dd($res);

            if ($res['success']) {
                $data['data_image_path'] = $res['data']['data_image_path'];
                $data['appealShortOrderLists'] = $res['data']['appealShortOrderLists'];
                $data['nothi_id'] = $res['data']['nothi_id'];
                $data['page_title'] = $res['data']['page_title'];
                return view('nothiList.nothiOrderSheetTemp')->with($data);
                
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
    }

}