<?php

namespace App\Http\Controllers\citizen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AppealRepository;
use App\Traits\TokenVerificationTrait;
use App\Repositories\CitizenRepository;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\GccAppealRepository;
use App\Repositories\AttachmentRepository;

class CitizenAppealController extends Controller
{
    use TokenVerificationTrait;
    //Requisition form page
    public function create()
    {
        // return GccAppeal::all();
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();
        $available_court = DB::table('gcc_court')->where('district_id',$officeInfo->district_id)->where('level',1)->orderBy('id','desc')->get();
        // dd($officeInfo);

      
       $citizen_info=DB::table('ecourt_citizens')->where('id','=',$user->citizen_id)->first();

       //dd($officeInfo->organization_routing_id);
        switch($officeInfo->organization_type)
        {
            case "BANK":
            $organization_type_bn_name='ব্যাংক';
            break;
            case "GOVERNMENT":
            $organization_type_bn_name='সরকারি প্রতিষ্ঠান';
            break;
            case "OTHER_COMPANY":
            $organization_type_bn_name='স্বায়ত্তশাসিত প্রতিষ্ঠান';
            break;   
        }      
        $appealId = null;
        $data = [
            'districtId' => $officeInfo->district_id,
            'divisionId' => $officeInfo->division_id,
            'office_id' => $office_id,
            'appealId' => $appealId,
            'organization_routing_id'=>$officeInfo->organization_routing_id,
            'organization_physical_address'=>$officeInfo->organization_physical_address,
            'organization_type'=>$officeInfo->organization_type,
            'organization_type_bn_name'=>$organization_type_bn_name,
            'available_court' => $available_court,
            'office_name' => $officeInfo->office_name_bn,
            'citizen_gender'=>$citizen_info->citizen_gender,
            'father'=>$citizen_info->father,
            'mother'=>$citizen_info->mother,
            'present_address'=>$citizen_info->present_address,
            'organization_employee_id'=>Auth::user()->organization_employee_id
        ];
       
        //dd($data);

        $page_title = 'সার্টিফিকেট রিকুইজিশন নিবন্ধন';
        return view('gcc_court.citizenAppealInitiate.appealCreate')->with(['data' => $data, 'page_title' => $page_title]);
    }


    //store Requisition
   
    public function response_for_store_old(Request $request){
       
        $token = $this->verifySiModuleToken('WEB');

            if( $token){

                $data['appealinfo'] = GccAppealRepository::storeAppealBYCitizen($request);
        
                $data['citizeninfo']=CitizenRepository::storeCitizen($request);

                if ($request->file_type && $_FILES['file_name']['name']) {
                    
                    $data['log_file_data']=AttachmentRepository::storeAttachment('APPEAL',  $causeListId = date('Y-m-d'), $request->file_type,null);
                   
                }
                else
                {
                    $data['log_file_data']=null;
                }
                    
                
                $jsonData = json_encode($data);
               
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt_array($curl, array(
                    CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/get/requisition/data',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'jss'=>$jsonData
                        ) ,
                    CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        "secrate_key:common-court" ,
                        "Authorization: Bearer $token",
                    ),
                ));
        
                $response = curl_exec($curl);
                curl_close($curl);
                return redirect('gcc/pp/citizen/appeal/pending_case')->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
 
            }
        
    }

    public function response_for_store(Request $request){
        $request->session()->forget('key'); 
        $all_request_nids=[];
        
        foreach($request->applicant['nid'] as $value_nid_single)
        {
            if (!empty($value_nid_single)) {
              
                array_push($all_request_nids,$value_nid_single);
            }
        }

        foreach($request->defaulter['nid'] as $value_nid_single)
        {
            if (!empty($value_nid_single)) {
              
                array_push($all_request_nids,$value_nid_single);
            }
        }

        // dd($all_request_nids);
        if(count(array_unique($all_request_nids)) != count($all_request_nids))
        {
            
            return Redirect::back()->with('error', 'দুঃখিত, আপনি প্রাতিষ্ঠানিক প্রতিনিধি এবং ঋণগ্রহীতার ক্ষেত্রে একই জাতীয় পরিচয় পত্র ব্যবহার করেছেন');
        }

        $all_request_phn=[];
            
        foreach($request->applicant['phn'] as $value_phn_single)
        {
            array_push($all_request_phn,$value_phn_single);
        }

        foreach($request->defaulter['phn'] as $value_phn_single)
        {
            array_push($all_request_phn,$value_phn_single);
        }
        
        // array_push($all_request_phn,$request->defaulter['phn']);
            
        if(count(array_unique($all_request_phn)) != count($all_request_phn))
        {
            
            return Redirect::back()->with('error', 'দুঃখিত, আপনি প্রাতিষ্ঠানিক প্রতিনিধি এবং ঋণগ্রহীতার ক্ষেত্রে একই মোবাইল নম্বর ব্যবহার করেছেন');
        }
        

        
        $data['appealinfo'] = GccAppealRepository::storeAppealBYCitizen($request);
        
        $data['citizeninfo']=CitizenRepository::storeCitizen($request);

        if ($request->file_type && $_FILES['file_name']['name']) {
                    
            $data['log_file_data']=AttachmentRepository::storeAttachment('APPEAL',  $causeListId = date('Y-m-d'), $request->file_type,null);
           
        }
        else
        {
            $data['log_file_data']=null;
        }
       
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($data, true);

            $url=getapiManagerBaseUrl().'/api/v1/get/requisition/data';
            $method='POST';
            $bodyData=$jsonData;
            $token=$token;
            $response=makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res=json_decode($response, true);
            // dd($res);
            
            if (!empty($res)) {
                if ($res['success']) {
                    return redirect('gcc/pp/citizen/appeal/pending_case')->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
                    
                } else {
                    return redirect('gcc/pp/citizen/appeal/pending_case')->with('error', 'তথ্য  সংরক্ষণ হয়নি');
                }
            } else {
                return redirect('gcc/pp/citizen/appeal/pending_case')->with('error', 'তথ্য  সংরক্ষণ হয়নি');
            }
            
            
            
        }
    }





}