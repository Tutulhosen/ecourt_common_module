<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\TokenVerificationTrait;
class CauseListController extends Controller
{
    //
    use TokenVerificationTrait;

    public function index(Request $request)
    {

        // return $request->all();
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $data['divisions'] = DB::table('division')
            ->select('id', 'division_name_bn')
            ->get();
        $division_name = null;
        $district_name = null;
        $court_name = null;


            $emc_allinfo=array(
                'division'=>(!empty($_GET['emc_division'])?$_GET['emc_division']:null),
                'district'=> (!empty($_GET['emc_district'])?$_GET['emc_district']:null),
                'court'   =>(!empty($_GET['emc_court'])?$_GET['emc_court']:null),
                'case_no' =>(!empty($_GET['emc_case_no'])?$_GET['emc_case_no']:null),
                'date_start'=>(!empty($_GET['emc_date_start'])?$_GET['emc_date_start']:null),
                'date_end' =>(!empty($_GET['emc_date_end'])?$_GET['emc_date_end']:null),
                'offset' =>(!empty($_GET['emc_offset'])?$_GET['emc_offset']:null),
                'court_type_id' =>3,
            );
   
            $allinfo=array(
                'division'=>(!empty($_GET['division'])?$_GET['division']:null),
                'district'=> (!empty($_GET['district'])?$_GET['district']:null),
                'court'   =>(!empty($_GET['court'])?$_GET['court']:null),
                'case_no' =>(!empty($_GET['case_no'])?$_GET['case_no']:null),
                'date_start'=>(!empty($_GET['date_start'])?$_GET['date_start']:null),
                'date_end' =>(!empty($_GET['date_end'])?$_GET['date_end']:null),
                'offset' =>(!empty($_GET['offset'])?$_GET['offset']:null),
                'court_type_id' =>2,
            );
        


   

        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {
        $method='POST';
        $token=$token;

        
        // gcc_cause_list
        $jsonData = json_encode($allinfo, true);
        $url=getapiManagerBaseUrl().'/api/v1/causelist';
        $bodyData=$jsonData;
        $response = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
        $causeList = json_decode($response, true);
        //   dd($causeList);
        $data['cose_list']=$causeList['data']['cose_list'];
         

        // emc_cause_list
         $emc_allinfo = json_encode($emc_allinfo, true);
         $url2=getapiManagerBaseUrl().'/api/v1/emc_causelist';
         $emc_response = makeCurlRequestWithToken_new($url2, $method,$emc_allinfo, $token);
         $emccauseList = json_decode($emc_response, true);
           // dd($emccauseList);
         $data['appeal']=$emccauseList['data']['appeal'];
        }



        $data['dateFrom'] = $dateFrom;
        $data['dateTo'] = $dateTo;
        $data['division_name'] = $division_name;
        $data['district_name'] = $district_name;
        $data['court_name'] = $court_name;
        $data['page_title'] = 'মামলার কার্যতালিকা';

       

        return view('causeList.appealCauseList')->with($data);
    }

    public function gccCauseList(){
        return 'ok';
    }
}
