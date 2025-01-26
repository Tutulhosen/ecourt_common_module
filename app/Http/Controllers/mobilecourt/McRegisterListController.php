<?php

namespace App\Http\Controllers\mobilecourt;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;
class McRegisterListController extends Controller
{
    //
    use TokenVerificationTrait;
    public function register(){
   
        $userinfo=globalUserInfo();  // gobal user
        $office_id=globalUserInfo()->office_id;  
        $geoCityCorporations = [];
        $geoMetropolitan = [];
        $geoThanas = [];
        
        // Fetch session data
        $roleID = globalUserInfo()->role_id;
       
        
        if($roleID == 34){
        
            $officeinfo = DB::table('office')
            ->leftJoin('division as div', function ($join) {
               $join->on('office.division_id', '=', 'div.id');
           })->where('office.id',$office_id)->first();
           $division_id = $officeinfo->division_id;
           $divname_name = $officeinfo->div_name_bn;
         
            // Load views if user profile is Divisional Commissioner
             $data['divid'] = $division_id;
             $data['divname'] = $divname_name;
             
             $data['zilla'] = DB::table('district')->where('division_id',$division_id)->get();
             $data['upazila'] = [];
             $data['office_address'] = "বিভাগঃ &nbsp;" . $divname_name . "&nbsp;।";
             $data['reportlist'] =DB::table('register_lists')->whereIn('id',['1','3','7','8','10'])->get(); 
             $data['roleID']=$roleID;
             $data['profile']='Divisional Commissioner';

        }elseif($roleID == 2 || $roleID == 8 || $roleID == 25){
           
            $data['zilla'] = [];
            $data['upazila'] = [];
            $data['office_address'] = "";
            $data['division']= DB::table('division')
            ->select('id', 'division_name_bn as name') // Select specific columns
            ->orderBy('division_name_bn', 'asc') // Example sorting
            ->get();
    
            $data['roleID']=$roleID;
            $data['profile']='';
            $data['reportlist'] =DB::table('register_lists')->whereIn('id',['1','3','7','8','10'])->get(); 
            
        }

        $url = getapiManagerBaseUrl() . '/api/mc/law/get';
        $method = 'GET';
        $bodyData = null;
        $token = $this->verifySiModuleToken('WEB');
        
        // dd('setting crpc', $bodyData);
        if ($token) {
           $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
     
           if ($res->success == true) {
              $laws = $res->data;
              $data['lawlist'] = $laws;
          
           } else {
              return redirect()->back()->with('error', 'Something went wrong.');
           }
        }

      
        // Return view with data
        return view('mobile_court.register_list.register', $data);
    }

     /**
     * নাগরিক অভিযোগ রেজিস্টার
     */
    public function printcitizenregister(Request $request){
       
        $result = [];
        $reportName = "No data Found";
        $status = '';
        $registerLabelList = '';
        $groupingValue = 'divname';
        $complainStatus = '';
        $mag_name = "";
        $zilla_name = "";
        $roleID = globalUserInfo()->role_id;
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id',$office_id)->first();
        $session_divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;


        $url = getapiManagerBaseUrl() . '/api/mc/register_list/printcitizenregister';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['session_divid'] =$session_divid;// $divid;
        // $data['zillaId'] = $zillaId;
        // $data['zilla_name'] = $zilla_name;
       

        $method = 'POST';
        $bodyData = json_encode($data,true);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc',   $token);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $allinfo=json_decode($res,true);
           
            return response()->json([
                'result' => $allinfo['result'],
                'name' => $allinfo['name'],
                'registerLabelList' => $allinfo['registerLabelList'],
                'profileID' => $roleID,
                'mag_name' => $mag_name,
                'groupingValue' => $allinfo['groupingValue'],
                'zilla_name' => $allinfo['zilla_name'],
            ]);
            
        } else {
            dd('don have token');
        }
     


    

    }

    /**
     * কারাদণ্ড প্রদান রেজিস্টার
     */
    public function printPunishmentJailRegister(Request $request){
      
        $reportName = "No data Found";
        $status = '';
        $registerLabelList = '';
        $groupingValue= 'divname';
        $mag_name = "";
        $zilla_name = "";
        $result  = array();
        $profilesId = Auth::user()->id;
        $roleID = globalUserInfo()->role_id;
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id',$office_id)->first();
        $session_divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;


        $url = getapiManagerBaseUrl() . '/api/mc/register_list/printPunishmentJailRegister';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['session_divid'] =$session_divid;// $divid;
        // $data['zillaId'] = $zillaId;
        // $data['zilla_name'] = $zilla_name;
       

        $method = 'POST';
        $bodyData = json_encode($data,true);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc',   $token);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $allinfo=json_decode($res,true);
 
            return response()->json([
                'result' => $allinfo['result'],
                'name' => $allinfo['name'],
                'registerLabelList' => $allinfo['registerLabelList'],
                'profileID' => $roleID,
                'mag_name' => $allinfo['mag_name'],
                'groupingValue' => $allinfo['groupingValue'],
                'zilla_name' => $allinfo['zilla_name'],
            ]);
            
        } else {
            dd('don have token');
        }


        
    }
    public function printmonthlystatisticsregister(Request $request){
        $reportName = "No data Found";
        $mag_name = "";
        $registerLabelList = '';
        $result  = array();
        $zilla_name = "";
        $profilesId =Auth::user()->id;
        $roleID = globalUserInfo()->role_id;
        $groupingValue= 'divname';

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id',$office_id)->first();

        $session_divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;

        $url = getapiManagerBaseUrl() . '/api/mc/register_list/printmonthlystatisticsregister';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['session_divid'] =$session_divid;// $divid;


        $method = 'POST';
        $bodyData = json_encode($data,true);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc',   $token);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $allinfo=json_decode($res,true);
            
            return response()->json([
                'result' => $allinfo['result'],
                'name' => $allinfo['name'],
                'registerLabelList' => $allinfo['registerLabelList'],
                'profileID' => $roleID,
                'mag_name' => $allinfo['mag_name'],
                'groupingValue' =>$allinfo['groupingValue'],
                'zilla_name' =>$allinfo['zilla_name'],
            ]);
            
        } else {
            dd('don have token');
        }

             
    }
    public function printlawbasedReport(Request $request){
        $result = [];
        $childs = [];
        $reportName = "No data Found";
        $status = '';
        $registerLabelList = '';
        $getDropDownLawId = '';
        $mag_name = "";
        $zilla_name = "";

        $profilesId =Auth::user()->id;
        $roleID = globalUserInfo()->role_id;
        $groupingValue= 'divname';

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id',$office_id)->first();

        $session_divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;

        $url = getapiManagerBaseUrl() . '/api/mc/register_list/printlawbasedReport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['session_divid'] =$session_divid;// $divid;


        $method = 'POST';
        $bodyData = json_encode($data,true);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc',   $token);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $allinfo=json_decode($res,true);
          
            return response()->json([
                "result" => $allinfo['result'],
                "name" => $allinfo['name'],
                "profileID" =>$roleID,
                "registerLabelList" => $allinfo['registerLabelList'],
                "zilla_name" => $allinfo['zilla_name']
            ]);
            
        } else {
            dd('don have token');
        }

    }
    public function printPunishmentFineRegister(Request $request){
        $reportName = "No data Found";
        $status = '';
        $registerLabelList = '';
        $groupingValue = 'divname';
        $mag_name = "";
        $zilla_name = "";
        $result = [];
        $profilesId = auth()->user()->id;

        $roleID = globalUserInfo()->role_id;
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id',$office_id)->first();
        $division_id = $officeinfo->division_id;
        $district_id = $officeinfo->district_id;

        $url = getapiManagerBaseUrl() . '/api/mc/register_list/printPunishmentFineRegister';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['session_divid'] =$division_id;// $divid;


        $method = 'POST';
        $bodyData = json_encode($data,true);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc',   $token);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $allinfo=json_decode($res,true);
             
            return response()->json([
                'result' =>  $allinfo['result'],
                'name' => $allinfo['name'],
                'registerLabelList' => $allinfo['registerLabelList'],
                'profileID' => $roleID,
                'mag_name' =>$allinfo['mag_name'],
                'groupingValue' => $allinfo['groupingValue'],
                'zilla_name' =>$allinfo['zilla_name']
            ]);
            
        } else {
            dd('don have token');
        }
    }
    public function getAjaxUrlParameter(Request $request)
    {   
          
        
        $end_date = $request->input('end_date');
        $start_date = $request->input('start_date');
        $divid = $request->input('divisionid');
        $zillaid = $request->input('zillaid');
        $upozilaid = $request->input('upozilaid');
        $GeoCityCorporations = $request->input('GeoCityCorporations');
        $GeoMetropolitan = $request->input('GeoMetropolitan');
        $GeoThanas = $request->input('GeoThanas');
        $reportID = $request->input('reportID');
        return [
            $end_date,
            $start_date,
            $divid,
            $zillaid,
            $upozilaid,
            $GeoCityCorporations,
            $GeoMetropolitan,
            $GeoThanas,
            $reportID
        ];
        // return array($end_date, $start_date, $divid, $zillaid, $upozilaid, $GeoCityCorporations, $GeoMetropolitan, $GeoThanas, $reportID);
    }
}
 