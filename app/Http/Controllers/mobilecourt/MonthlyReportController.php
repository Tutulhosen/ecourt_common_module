<?php

namespace App\Http\Controllers\mobilecourt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MisReportRepository;
use App\Traits\TokenVerificationTrait;
use PhpParser\Node\Expr\FuncCall;

class MonthlyReportController extends Controller
{
    //
    use TokenVerificationTrait;

    public function report(Request $request)
    {
        return view('mobile_court.monthly_report.report');
    }
    public function getMisReportList(Request $request)
    {
        // $this->view->disable();
        $user = Auth::user();
        $reportlist = array();
        $reportlistdiv = array();
        $reportGraphList = array();
        $reportCountryList = array();
        $resultSet = array();

        $office_id = globalUserInfo()->office_id;
        $roleID = globalUserInfo()->role_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();

        if ($roleID == 8 || $roleID = 2) {
            $reportlist = DB::table('mc_report_lists')
                ->whereNotIn('id', [7])
                ->get();
            // Find records where id is not 5, 6, or 7
            $reportlistdiv = DB::table('mc_report_lists')
                ->whereNotIn('id', [5, 6, 7])
                ->get();
            // Retrieve all records from the CountryMisReport table
            $reportCountryList = DB::table('mc_country_mis_reports')->get();
        }

        // if ($user->profilesId == 7 || $user->profilesId == 11|| $user->profilesId == 12 || $user->profilesId == 14) { // ADM DM
        //     $reportlist = ReportList::find();
        // } elseif ($user->profilesId == 4) { // Divisional Commissioner
        //     $reportlist = ReportList::find();
        // } elseif ($user->profilesId == 5 || $user->profilesId == 19) { //JS
        //     $reportlist = ReportList::find("id NOT IN ('7')");
        //     $reportlistdiv = ReportList::find("id NOT IN ('5','6','7')");
        //     $reportCountryList=CountryMisReport::find();
        // }
        // mc_country_mis_report
        // mc_report_lists
        $reportGraphList = DB::table('graph_mis_reports')->get();

        $resultSet = array(
            "zillaReportList" => $reportlist,
            "divisionReportList" => $reportlistdiv,
            "countryReportList" => $reportCountryList,
            "graphReportList" => $reportGraphList
        );

        return response()->json($resultSet);
    }
    public function printcountrymobilecourtreport(Request $request)
    {

        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printcountrymobilecourtreport';
        $data = $request->all();
        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd('month report res', $res->resultSet);
            return response()->json([
                'resultSet' => $res->resultSet ?? [],
                'totResult' => $res->totResult ?? 0,
                'reportName' => $res->reportName ?? '',
            ]);
        } else {
            dd('don have token');
            return response()->json([
                'resultSet' =>  [],
                'totResult' => 0,
                'reportName' => '',
            ]);
        }
    }

    public function printdivmobilecourtreport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;

        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printdivmobilecourtreport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;;
        $data['zillaId'] = $zillaId;;
        $data['zilla_name'] = $zilla_name;;
        $data['divname_name'] = $divname_name;;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd($res);
            $result = array(
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            );
            return response()->json($result);
        } else {
            dd('don have token');
        }
    }
    public function printdivappealcasereport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printdivappealcasereport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd($res);
            $response = array(
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year,
                "pre_month_year" => $res->pre_month_year
            );
            return response()->json($response);
        } else {
            dd('don have token');
        }
    }
    public function printdivadmcasereport(Request $request)
    {

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printdivadmcasereport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd($res);
            $response = array(
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => '',
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year,
                "pre_month_year" => $res->pre_month_year
            );
            return response()->json($response);
        } else {
            dd('don have token');
        }
    }
    public function printdivemcasereport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printdivemcasereport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            //  dd($res);
             $response = array(
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => '',
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year,
                "pre_month_year" => $res->pre_month_year
            );
            return response()->json($response);
        } else {
            dd('don have token');
        }
    }

    public function printdivapprovedreport(Request $request)
    {

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printdivapprovedreport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            $response = array(
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => '',
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year,
                "pre_month_year" => $res->pre_month_year
            );
            return response()->json($response);
        } else {
            dd('don have token');
        }
    }

    public function printmobilecourtreport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printmobilecourtreport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
        
       
     
            $data = [
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            ];
            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
         
        } else {
            dd('don have token');
        }
    }

    public function printappealcasereport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printappealcasereport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd($res);
            $data = [
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            ];
            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('dont have token');
        }

      
    }

    public function printadmcasereport(Request $request)
    {

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printadmcasereport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
           
            $data = [
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            ];
            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('dont have token');
        }

        
    }
    public function printemcasereport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printemcasereport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd($res);
            // return $res;
            $data = [
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            ];
            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('dont have token');
        }
        
    }

    public function printcourtvisitreport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printcourtvisitreport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);

            $data = [
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            ];
            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('dont have token');
        }
        

       
    }
    public function printcaserecordreport(Request $request)
    {

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printcaserecordreport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            // dd($res);
            $data = [
                "result" => $res->result,
                "name" => $res->name,
                "profileID" => 5,
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            ];
            return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('dont have token');
        }

       
    }

    public function printmobilecourtstatisticreport(Request $request)
    {

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/printmobilecourtstatisticreport';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
        //    dd($res);
           $data = [
            "result" => $res->result,
            "name" => $res->name,
            "profileID" => 5,
            "zilla_name" => $zilla_name,
            "month_year" => $res->month_year
        ];
        return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('dont have token');
        }

      
    }

    // Graph 
    public function ajaxDataCourt(Request $request)
    {
      
        $childs = array();
        $office_id = globalUserInfo()->office_id;
        $user = Auth::user();
        $roleID = globalUserInfo()->role_id;

        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;
     
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/ajaxDataCourt';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $divname_name;
        $data['office_id'] = $office_id;


        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $childs =json_decode($res,true);
            return [$childs[0]];
        } else {
            dd('dont have token');
        }
        // if ($roleID == 37 || $roleID == 38) { // ADM DM
        //     $childs = $this->ajaxDataCourtForDivision($request);
        // }

       
        // if ($roleID == 34 ) { // Divisional Commissioner
        //     $childs = $this->ajaxDataCourtForDivision($request);
        // }
     
        // if ($roleID == 2 || $roleID == 8 ) { //JS
        //     $childs = $this->ajaxDataCourtForCountry($request);
        // }
         //   
        // return response()->json([$childs]);
    }

    public function ajaxDataCase(Request $request)
    {
        $childs = array();
        $office_id = globalUserInfo()->office_id;
        $user = Auth::user();
        $roleID = globalUserInfo()->role_id;

        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;
        $div_name = $officeinfo->div_name_bn;
        $zilla_name = $officeinfo->dis_name_bn;

        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/ajaxDataCase';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $div_name;
        $data['office_id'] = $office_id;

        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $childs=json_decode($res,true);
            // return response()->json([$childs[0]]);
            return [$childs[0]];
        } else {
            dd('dont have token');
        }
        // if ($roleID == 37 || $roleID == 38) { // ADM DM
        //     $childs = $this->ajaxDataCaseForDivision($request);
        // }

        // if ($roleID == 34) { //JS
        //     $childs = $this->ajaxDataCaseForDivision($request);
        // }

        // if ($roleID == 2 || $roleID == 8) { // Divisional Commissioner
        //     $childs = $this->ajaxDataCaseForCountry($request);
        // }
        

        // return response()->json([$childs]);
    }
    public function ajaxDataFine(Request $request)
    {
        $childs = array();
        $office_id = globalUserInfo()->office_id;
        $user = Auth::user();
        $roleID = globalUserInfo()->role_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();

        $divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;
        $div_name = $officeinfo->div_name_bn;
        $zilla_name = $officeinfo->dis_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/ajaxDataFine';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $div_name;
        $data['office_id'] = $office_id;

        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $childs=json_decode($res,true);
            // return $res;
            return [$childs[0]];
        } else {
            dd('dont have token');
        }

        // if ($roleID == 37 || $roleID == 38) { // ADM DM
        //     $childs = $this->ajaxDataFineForDivision($request);
        // }
        // if ($roleID == 2 || $roleID == 8) { // Divisional Commissioner
        //     $childs = $this->ajaxDataFineForCountry($request);
        // }
        // if ($roleID == 34) { //JS
           
        //     $childs = $this->ajaxDataFineForDivision($request);
        // }


        // return response()->json([$childs]);
    }
    public function ajaxDataAppeal(Request $request)
    {
        $childs = array();
        $office_id = globalUserInfo()->office_id;
        $user = Auth::user();
        $roleID = globalUserInfo()->role_id;

        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;
        $div_name = $officeinfo->div_name_bn;
        $zilla_name = $officeinfo->dis_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/ajaxDataAppeal';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $div_name;
        $data['office_id'] = $office_id;

        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $childs=json_decode($res,true);
            return [$childs[0]];
        } else {
            dd('dont have token');
        }

        // if ($roleID == 37 || $roleID == 38) { // ADM DM
        //     $childs = $this->ajaxDataAppealForDivision($request);
        // }
        // if ($roleID == 2 || $roleID == 8) { // Divisional Commissioner
        //     $childs = $this->ajaxDataAppealForDivision($request);
        // }
        // if ($roleID == 34) { //JS
        //     $childs = $this->ajaxDataAppealForCountry($request);
        // }

        // return response()->json([$childs]);
    }

    public function ajaxDataEm(Request $request)
    {
        $childs = array();
        $office_id = globalUserInfo()->office_id;
        $user = Auth::user();
        $roleID = globalUserInfo()->role_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
 
        $divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;
        $div_name = $officeinfo->div_name_bn;
        $zilla_name = $officeinfo->dis_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/ajaxDataEm';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $div_name;
        $data['office_id'] = $office_id;

        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $childs=json_decode($res,true);
            return [$childs[0]];
        } else {
            dd('dont have token');
        }
        // if ($roleID == 37 || $roleID == 38) { // ADM DM
        //     $childs = $this->ajaxDataEmForDivision($request);
        // }
        // if ($roleID == 2 || $roleID == 8) { // Divisional Commissioner
        //     $childs = $this->ajaxDataEmForCountry($request);
        // }
        // if ($roleID == 34) { //JS
        
        //     $childs = $this->ajaxDataEmForDivision($request);
        // }
        
        
        // return response()->json([$childs]);
    }
    public function ajaxDataAdm(Request $request)
    {
        $childs = array();
        $office_id = globalUserInfo()->office_id;
        $user = Auth::user();
        $roleID = globalUserInfo()->role_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();

        $divid = $officeinfo->division_id;
        $zillaId = $officeinfo->district_id;
        $div_name = $officeinfo->div_name_bn;
        $zilla_name = $officeinfo->dis_name_bn;
        $url = getapiManagerBaseUrl() . '/api/mc/monthly_report/ajaxDataAdm';
        $data = $request->all();
        $data['roleID'] = globalUserInfo()->role_id;;
        $data['divid'] = $divid;
        $data['zillaId'] = $zillaId;
        $data['zilla_name'] = $zilla_name;
        $data['divname_name'] = $div_name;
        $data['office_id'] = $office_id;

        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $childs=json_decode($res,true);
          
            return [$childs[0]];
        } else {
            dd('dont have token');
        }    
        // if ($roleID == 37 || $roleID == 38) { // ADM DM
        //     $childs = $this->ajaxDataAdmForDivision($request);
        // }
        // if ($roleID == 2 || $roleID == 8) { // Divisional Commissioner
        //     $childs = $this->ajaxDataAdmForDivision($request);
        // }
        // if ($roleID == 34) { //JS
        //     $childs = $this->ajaxDataAdmForCountry($request);
        // }
        // return response()->json([$childs]);
    }

    
    public function dashboard_monthly_report(Request $request){

        $year = $request->query('year');
        $currentMonth = $request->query('currentMonth');
        $previousMonth = $request->query('previousMonth');
        // Validate the inputs if necessary
        if (globalUserInfo()->role_id==34) {
            $d['divisionid']=user_office_info()->division_id;
        } else {
            $d['divisionid']=null;
        }
        
        $d['year']=$year;
        $d['currentMonth']=$currentMonth;
        $d['previousMonth']=$previousMonth;
        $d['role_id']=globalUserInfo()->role_id;
        
        $token = $this->verifySiModuleToken('WEB');
        
        if ($token) {

            $jsonData = json_encode($d, true);
            $url = getapiManagerBaseUrl() . '/api/mc/dashboard/dashboard_monthly_report';

            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
            $res = json_decode($response, true);
            // dd($res);
            return response()->json($res);
            
        }
    }
    

    public function ajaxDataCourtForDivision($request)
    {

        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')
            ->leftJoin('district as zilla', function ($join) {
                $join->on('office.district_id', '=', 'zilla.id')
                    ->on('office.division_id', '=', 'zilla.division_id');
            })->where('office.id', $office_id)->first();


        $divid = $officeinfo->division_id;



        $report_date = $request->report_date;
        $report_date2 = $request->report_date2;
        $yData = '';
        if ($report_date != "") {
            $report_date_array = explode("-", $report_date);
            $mth = $report_date_array[0];
            $yr = $report_date_array[1];

            $month =  $this->get_bangla_monthonly($mth);


            $preMonth = (int)$mth - 1;;
            $currentmonth = $mth;
            $nextMonth = (int)$mth + 1;
            if ($report_date2 != "") {
                $report_date2 = trim($report_date2);  // Ensure no extra spaces
                $report_date2_array = explode("-", $report_date2);  // Split into components
                $mth2 = $report_date2_array[0];  // Expected to be '08' if correctly formatted
                $yr2 = $report_date2_array[1];
                $nextMonth = trim($mth2);
            }
 
            $yData = ["প্রমাপ", $this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        }


        $childs = array();
       
        $info = DB::table('monthly_reports')
            ->select(
                'zillaname',
                DB::raw("SUM(IF(report_month = $currentmonth, court_total, 0)) as court_total1"),
                DB::raw("SUM(IF(report_month = $nextMonth, court_total, 0)) as court_total2"),
                DB::raw("SUM(IF(report_month = $currentmonth, promap, 0)) as promap")
            )
            ->where('divid', $divid)
            ->where('report_type_id', 1)
            ->where('report_year', $yr)
            ->groupBy('zillaid')
            ->get();
        foreach ($info as $t) {

            $childs[] = array(
                'location' => $t->zillaname,
                $yData[0] => "" . $t->promap . "",
                $yData[1] => "" . $t->court_total1 . "",
                $yData[2] => "" . $t->court_total2 . "",
                'yData' =>  $yData
            );
        }

        return $childs;
    }
    public function ajaxDataCaseForDivision($request)
    {
        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();


        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')
            ->leftJoin('district as zilla', function ($join) {
                $join->on('office.district_id', '=', 'zilla.id')
                    ->on('office.division_id', '=', 'zilla.division_id');
            })->where('office.id', $office_id)->first();

        $divid = $officeinfo->division_id;

        $report_date = $request->report_date;
        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];

            $month =  $this->get_bangla_monthonly($mth);


            $preMonth = $mth - 1;;
            $currentmonth = $mth;
            $nextMonth = $mth + 1;

            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        }

        $childs = array();
        // $phql = "
        //             SELECT
        //             zillaname,
        //             SUM( IF( monthlyreport.report_month =$currentmonth, monthlyreport.case_total, 0 ) ) case_total1,
        //             SUM( IF( monthlyreport.report_month =$nextMonth, monthlyreport.case_total, 0 ) ) case_total2
        //             FROM Mcms\Models\MonthlyReport as monthlyreport
        //             WHERE monthlyreport.divid = $divid AND monthlyreport.report_type_id = 1 AND monthlyreport.report_year = $yr
        //             GROUP BY zillaname";

        // $query = $this->modelsManager->createQuery($phql);
        // $info = $query->execute();

        $info = DB::table('monthly_reports as monthlyreport')
            ->select(
                'zillaname',
                DB::raw("SUM(IF(monthlyreport.report_month = $currentmonth, monthlyreport.case_total, 0)) as case_total1"),
                DB::raw("SUM(IF(monthlyreport.report_month = $nextMonth, monthlyreport.case_total, 0)) as case_total2")
            )
            ->where('monthlyreport.divid', $divid)
            ->where('monthlyreport.report_type_id', 1)
            ->where('monthlyreport.report_year', $yr)
            ->groupBy('zillaname')
            ->get();

        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->zillaname,
                $yData[0] => "" . $t->case_total1 . "",
                $yData[1] => "" . $t->case_total2 . "",
                'yData' =>  $yData
            );
        }

        return $childs;
    }
    public function ajaxDataFineForDivision($request)
    {
        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();

        $report_date = $request->report_date;

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')
            ->leftJoin('district as zilla', function ($join) {
                $join->on('office.district_id', '=', 'zilla.id')
                    ->on('office.division_id', '=', 'zilla.division_id');
            })->where('office.id', $office_id)->first();

        $divid = $officeinfo->division_id;


        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];

            $month = $this->get_bangla_monthonly($mth);


            $preMonth = $mth - 1;;
            $currentmonth = $mth;
            $nextMonth = $mth + 1;

            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        }

        $childs = array();
        $info = DB::table('monthly_reports as monthlyreport')
            ->select(
                'zillaname',
                DB::raw("SUM(IF(monthlyreport.report_month = $currentmonth, monthlyreport.fine_total, 0)) as fine_total1"),
                DB::raw("SUM(IF(monthlyreport.report_month = $nextMonth, monthlyreport.fine_total, 0)) as fine_total2")
            )
            ->where('monthlyreport.divid', $divid)
            ->where('monthlyreport.report_type_id', 1)
            ->where('monthlyreport.report_year', $yr)
            ->groupBy('zillaname')
            ->get();

        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->zillaname,
                $yData[0] => "" . $t->fine_total1 . "",
                $yData[1] => "" . $t->fine_total2 . "",
                'yData' =>  $yData
            );
        }

        return $childs;
    }

    public function ajaxDataAppealForDivision($request)
    {
        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();

        $report_date = $request->report_date;

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')
            ->leftJoin('district as zilla', function ($join) {
                $join->on('office.district_id', '=', 'zilla.id')
                    ->on('office.division_id', '=', 'zilla.division_id');
            })->where('office.id', $office_id)->first();

        $divid = $officeinfo->division_id;


        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];

            $preMonth = $mth - 1;;
            $currentmonth = $mth;
            $nextMonth = $mth + 1;
           
        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
          
        }

        $info = DB::table('monthly_reports as monthlyreport')
            ->select(
                'zillaname',
                DB::raw("SUM(monthlyreport.pre_case_incomplete) as pre_case_incomplete"),
                DB::raw("SUM(monthlyreport.case_submit) as case_submit"),
                DB::raw("SUM(monthlyreport.case_complete) as case_complete"),
                DB::raw("SUM(monthlyreport.case_incomplete) as case_incomplete")
            )
            ->where('monthlyreport.divid', $divid)
            ->where('monthlyreport.report_month', $currentmonth)
            ->where('monthlyreport.report_type_id', 2)
            ->where('monthlyreport.report_year', $yr)
            ->groupBy('zillaname')
            ->get();
        $month_year = $this->get_bangla_monthbymumber($currentmonth, $yr);
        $yData = ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'];
        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->zillaname,
                'জের' => "" . $t->pre_case_incomplete . "",
                'দায়েরকৃত' => "" . $t->case_submit . "",
                'নিষ্পন্ন' => "" . $t->case_complete . "",
                'অনিষ্পন্ন' => "" . $t->case_incomplete . "",
                'reportmonth' => "(" . $month_year . ")",
                'yData' => $yData
            );
        }
        return $childs;
    }

    public function ajaxDataEmForDivision($request)
    {

        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();

        $report_date = $request->report_date;

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')
            ->leftJoin('district as zilla', function ($join) {
                $join->on('office.district_id', '=', 'zilla.id')
                    ->on('office.division_id', '=', 'zilla.division_id');
            })->where('office.id', $office_id)->first();

        $divid = $officeinfo->division_id;


        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];

            // $month = BanglaDate::get_bangla_monthonly($mth);


            $preMonth = $mth - 1;;
            $currentmonth = $mth;
            $nextMonth = $mth + 1;

            // $yData = [BanglaDate::get_bangla_monthonly($currentmonth) ,BanglaDate::get_bangla_monthonly($nextMonth)];

        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            // $yData = [BanglaDate::get_bangla_monthonly($currentmonth) ,BanglaDate::get_bangla_monthonly($nextMonth)];
        }

        $info = DB::table('monthly_reports as monthlyreport')
            ->select(
                'zillaname',
                DB::raw("SUM(monthlyreport.pre_case_incomplete) as pre_case_incomplete"),
                DB::raw("SUM(monthlyreport.case_submit) as case_submit"),
                DB::raw("SUM(monthlyreport.case_complete) as case_complete"),
                DB::raw("SUM(monthlyreport.case_incomplete) as case_incomplete")
            )
            ->where('monthlyreport.divid', $divid)
            ->where('monthlyreport.report_month', $currentmonth)
            ->where('monthlyreport.report_type_id', 4)
            ->where('monthlyreport.report_year', $yr)
            ->groupBy('zillaname')
            ->get();
        $month_year = $this->get_bangla_monthbymumber($currentmonth, $yr);
        $yData = ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'];
        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->zillaname,
                'জের' => "" . $t->pre_case_incomplete . "",
                'দায়েরকৃত' => "" . $t->case_submit . "",
                'নিষ্পন্ন' => "" . $t->case_complete . "",
                'অনিষ্পন্ন' => "" . $t->case_incomplete . "",
                'reportmonth' => "(" . $month_year . ")",
                'yData' => $yData
            );
        }
        return $childs;
    }

    public function ajaxDataAdmForDivision(Request $request)
    {
        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();

        $report_date = $request->report_date;

        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')
            ->leftJoin('district as zilla', function ($join) {
                $join->on('office.district_id', '=', 'zilla.id')
                    ->on('office.division_id', '=', 'zilla.division_id');
            })->where('office.id', $office_id)->first();

        $divid = $officeinfo->division_id;


        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];

            $preMonth = $mth - 1;;
            $currentmonth = $mth;
            $nextMonth = $mth + 1;

        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            // $yData = [BanglaDate::get_bangla_monthonly($currentmonth) ,BanglaDate::get_bangla_monthonly($nextMonth)];
        }
        $childs = array();
        $info = DB::table('monthly_reports as monthlyreport')
            ->select(
                'divname',
                DB::raw("SUM(monthlyreport.pre_case_incomplete) as pre_case_incomplete"),
                DB::raw("SUM(monthlyreport.case_submit) as case_submit"),
                DB::raw("SUM(monthlyreport.case_complete) as case_complete"),
                DB::raw("SUM(monthlyreport.case_incomplete) as case_incomplete")
            )
            ->where('monthlyreport.report_month', $currentmonth)
            ->where('monthlyreport.report_type_id', 3)
            ->where('monthlyreport.divid', $divid)
            ->where('monthlyreport.report_year', $yr)
            ->groupBy('divname')
            ->get();
        $month_year = $this->get_bangla_monthbymumber($currentmonth, $yr);
        $yData = ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'];
        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->divname,
                'জের' => "" . $t->pre_case_incomplete . "",
                'দায়েরকৃত' => "" . $t->case_submit . "",
                'নিষ্পন্ন' => "" . $t->case_complete . "",
                'অনিষ্পন্ন' => "" . $t->case_incomplete . "",
                'reportmonth' => "(" . $month_year . ")",
                'yData' => $yData
            );
        }

        return $childs;
    }


    public function ajaxDataCourtForCountry($request)
    {
        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yr = "2015";
        $yData = array();

        $report_date = $request->report_date;
        $report_date2 = $request->report_date2;

        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];

            $month = $this->get_bangla_monthonly($mth);


            $preMonth = $mth - 1;
            $currentmonth = $mth;
            $nextMonth = $mth + 1;
            if ($report_date2 != "") {
                $mth2 = substr($report_date2, 0, 2);
                $yr2 = substr($report_date2, 3, 4); // 01/02/2015 => 2015 06-2015
                $nextMonth = $mth2;
            }
            $yData = ["প্রমাপ", $this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly((int)$nextMonth), "প্রমাপ"];
        }

        $childs = array();
       
        $info =  DB::table('monthly_reports as monthlyreport')
        ->select(
            'monthlyreport.divname',
            DB::raw("SUM(IF(monthlyreport.report_month = ?, monthlyreport.court_total, 0)) as court_total1", [$currentmonth]),
            DB::raw("SUM(IF(monthlyreport.report_month = ?, monthlyreport.court_total, 0)) as court_total2", [$nextMonth]),
            DB::raw("SUM(IF(monthlyreport.report_month = ?, monthlyreport.promap, 0)) as promap", [$currentmonth])
        )
        ->where('monthlyreport.report_type_id', 1)
        ->where('monthlyreport.report_year', $yr)
        ->groupBy('monthlyreport.divname')
        ->get();

        $month_year = $this->get_bangla_monthbymumber($currentmonth, $yr);

        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->divname,
                $yData[0] => "" . $t->promap . "",
                $yData[1] => "" . $t->court_total1 . "",
                $yData[2] => "" . $t->court_total2 . "",
                'yData' =>  $yData
            );
        }

        return $childs;
    }
    public function ajaxDataCaseForCountry($request)
    {
        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();

        $report_date = $request->report_date;
        $report_date2 = $request->report_date2;

        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];
            $month = $this->get_bangla_monthonly($mth);


            $preMonth = $mth - 1;;
            $currentmonth = $mth;
            $nextMonth = $mth + 1;
            if ($report_date2 != "") {
                $mth2 = substr($report_date2, 0, 2);
                $yr2 = substr($report_date2, 3, 4); // 01/02/2015 => 2015 06-2015
                $nextMonth = $mth2;
            }


            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        }
        $childs = array();
        $info = DB::table('monthly_reports as monthlyreport')
        ->select(
            'divname',
            DB::raw('SUM(CASE WHEN monthlyreport.report_month = ? THEN monthlyreport.case_total ELSE 0 END) as case_total1', [$currentMonth]),
            DB::raw('SUM(CASE WHEN monthlyreport.report_month = ? THEN monthlyreport.case_total ELSE 0 END) as case_total2', [$nextMonth])
        )
        ->where('monthlyreport.report_type_id', 1)
        ->where('monthlyreport.report_year', $yr)
        ->groupBy('divname')
        ->get();
 
        $childs=[];
        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->divname,
                $yData[0] => "" . $t->case_total1 . "",
                $yData[1] => "" . $t->case_total2 . "",
                'yData' =>  $yData
            );
        }

        return $childs;
    }
    public function ajaxDataFineForCountry($request)
    {
        $preMonth = "";
        $month = "";
        $nextMonth = "";
        $yData = array();

        $report_date = $request->report_date;
        $report_date2 = $request->report_date2;

        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];


            $month = $this->get_bangla_monthonly((int)$mth);


            $preMonth = (int)$mth - 1;;
            $currentmonth = $mth;
            $nextMonth = (int)$mth + 1;
            if ($report_date2 != "") {
                $mth2 = substr($report_date2, 0, 2);
                $yr2 = substr($report_date2, 3, 4); // 01/02/2015 => 2015 06-2015
                $nextMonth = (int)$mth2;
            }

            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        } else {
            $preMonth = "03";
            $currentmonth = "04";
            $nextMonth = "05";
            $yData = [$this->get_bangla_monthonly($currentmonth), $this->get_bangla_monthonly($nextMonth)];
        }

        $childs = array();
        $info = DB::table('monthly_reports as monthlyreport')
        ->select(
            'divname',
            DB::raw("SUM(CASE WHEN monthlyreport.report_month = ? THEN monthlyreport.fine_total ELSE 0 END) as fine_total1", [$currentmonth]),
            DB::raw("SUM(CASE WHEN monthlyreport.report_month = ? THEN monthlyreport.fine_total ELSE 0 END) as fine_total2", [$nextMonth])
        )
        ->where('monthlyreport.report_type_id', 1)
        ->where('monthlyreport.report_year', $yr)
        ->groupBy('divname')
        ->get();
        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->divname,
                $yData[0] => "" . $t->fine_total1 . "",
                $yData[1] => "" . $t->fine_total2 . "",
                'yData' =>  $yData
            );
        }

        return $childs;
    }
    public function ajaxDataAppealForCountry($request)
    {
        $currentmonth = "04";
        $yr = "2015";
        $report_date = $request->report_date;
        $report_date2 = $request->report_date2;

        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];

            $currentmonth = $mth;

            $nextMonth = (int)$mth + 1;
            if ($report_date2 != "") {
                $mth2 = substr($report_date2, 0, 2);
                $yr2 = substr($report_date2, 3, 4); // 01/02/2015 => 2015 06-2015
                $nextMonth = $mth2;
            }
        } else {
            $currentmonth = "04";
        }

        //        SUM(monthlyreport.pre_case_incomplete) as pre_case_incomplete,
        $childs = array();
        $info = DB::table('monthly_reports')
        ->selectRaw("
            divname,
            SUM(pre_case_incomplete) as pre_case_incomplete,
            SUM(case_submit) as case_submit,
            SUM(case_complete) as case_complete,
            SUM(case_incomplete) as case_incomplete
        ")
        ->where('report_month', $currentmonth)
        ->where('report_type_id', 2)
        ->where('report_year', $yr)
        ->groupBy('divname')
        ->get();

        $month_year = $this->get_bangla_monthbymumber($currentmonth, $yr);
        $yData = ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'];

        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->divname,
                'জের' => "" . $t->pre_case_incomplete . "",
                'দায়েরকৃত' => "" . $t->case_submit . "",
                'নিষ্পন্ন' => "" . $t->case_complete . "",
                'অনিষ্পন্ন' => "" . $t->case_incomplete . "",
                'reportmonth' => "(" . $month_year . ")",
                'yData' =>  $yData
            );
        }

        return $childs;
    }
    public function ajaxDataEmForCountry($request)
    {
        $currentmonth = "04";

        $report_date = $request->report_date;

        if ($report_date != "") {
            $report_date = trim($report_date);  // Ensure no extra spaces
            $report_date_array = explode("-", $report_date);
            $mth = trim($report_date_array[0]);
            $yr = $report_date_array[1];
      
            $currentmonth = $mth;
        } else {
            $currentmonth = "04";
        }

        $childs = array();
        $info = DB::table('monthly_reports')
        ->select(
            'divname',
            DB::raw('SUM(pre_case_incomplete) as pre_case_incomplete'),
            DB::raw('SUM(case_submit) as case_submit'),
            DB::raw('SUM(case_complete) as case_complete'),
            DB::raw('SUM(case_incomplete) as case_incomplete')
        )
        ->where('report_month', $currentmonth)
        ->where('report_type_id', 4)
        ->where('report_year', $yr)
        ->groupBy('divname')
        ->get();
        $month_year = $this->get_bangla_monthbymumber((int)$currentmonth, $yr);
        $yData = ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'];
        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->divname,
                'জের' => "" . $t->pre_case_incomplete . "",
                'দায়েরকৃত' => "" . $t->case_submit . "",
                'নিষ্পন্ন' => "" . $t->case_complete . "",
                'অনিষ্পন্ন' => "" . $t->case_incomplete . "",
                'reportmonth' => "(" . $month_year . ")",
                'yData' => $yData
            );
        }

        return $childs;
    }
    public function ajaxDataAdmForCountry($request)
    {
        $currentmonth = "04";

        $report_date = $request->report_date;

        if ($report_date != "") {
            $report_date_array = explode("-", $report_date);
            $mth = $report_date_array[0];
            $yr = $report_date_array[1];
            //            $mth = substr($report_date, 0, 2);
            //            $yr = substr($report_date, 3, 4); // 01/02/2015 => 2015 06-2015
            $currentmonth = $mth;
        } else {
            $currentmonth = "04";
        }


        $childs = array();
        $info = DB::table('monthly_reports')
                ->selectRaw("
                    divname,
                    SUM(pre_case_incomplete) as pre_case_incomplete,
                    SUM(case_submit) as case_submit,
                    SUM(case_complete) as case_complete,
                    SUM(case_incomplete) as case_incomplete
                ")
                ->where('report_month', $currentmonth)
                ->where('report_type_id', 3)
                ->where('report_year', $yr)
                ->groupBy('divname')
                ->get();
        $month_year = $this->get_bangla_monthbymumber($currentmonth, $yr);
        $yData = ['জের', 'দায়েরকৃত', 'নিষ্পন্ন', 'অনিষ্পন্ন'];

        foreach ($info as $t) {
            $childs[] = array(
                'location' => $t->divname,
                'জের' => "" . $t->pre_case_incomplete . "",
                'দায়েরকৃত' => "" . $t->case_submit . "",
                'নিষ্পন্ন' => "" . $t->case_complete . "",
                'অনিষ্পন্ন' => "" . $t->case_incomplete . "",
                'reportmonth' => "(" . $month_year . ")",
                'yData' => $yData
            );
        }

        return $childs;
    }
    public  function get_bangla_monthbymumber($month, $year)
    {

        if ($year == "") {
            $year = date('Y');
        }
        $mons = array(
            '01' => "জানুয়ারী",
            '02' => "ফেব্রুয়ারী",
            '03' => "মার্চ",
            '04' => "এপ্রিল",
            '05' => "মে",
            '06' => "জুন",
            '07' => "জুলাই",
            '08' => "আগস্ট",
            '09' => "সেপ্টেম্বর",
            '10' => "অক্টোবর",
            '11' => "নভেম্বর",
            '12' => "ডিসেম্বর"
        );

        $month_name = $mons[$month];

        return $month_name . " " . $year;
    }



    public   function get_bangla_monthonly($month)
    {

        $mons = array(
            '01' => "জানুয়ারী",
            '02' => "ফেব্রুয়ারী",
            '03' => "মার্চ",
            '04' => "এপ্রিল",
            '05' => "মে",
            '06' => "জুন",
            '07' => "জুলাই",
            '08' => "আগস্ট",
            '09' => "সেপ্টেম্বর",
            '10' => "অক্টোবর",
            '11' => "নভেম্বর",
            '12' => "ডিসেম্বর"
        );
        $convertedMonth = $mons[$month];
        return $convertedMonth;
    }
}
