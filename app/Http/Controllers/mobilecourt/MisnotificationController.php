<?php

namespace App\Http\Controllers\mobilecourt;

use Nette\Utils\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\TokenVerificationTrait;
use App\Repositories\MisReportRepository;

class MisnotificationController extends Controller
{
    //
    use TokenVerificationTrait;
    public function setReportDataUnapproved(Request $request)
    {
        $url = getapiManagerBaseUrl() . '/api/mc/misnotification/setReportDataUnapproved';
        $reportId = $request->query('reportId');        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($reportId);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            if($res){
                // dd($res);
                return ["status"=> "success"];
            }else{
                return ["status"=> "fail"];
            }
        } else {
            return ["status"=> "fail"];
        }
    }


    public function levelConfig(Request $request)
    {


        return view('mobile_court.notification.levelConfig');
    }
    public function getNotificationsData(Request $request, $level)
    {

        // Disable view rendering and return JSON response
        if ($request->isMethod('get') && $request->ajax()) {
            $childs = [];
            $tmp = [];

            // Prepare the level as per the given format
            if ($level) {
                $level = "LEVEL_" . $level;

                // Define the query
            //     $tmp = DB::select("
            // SELECT mi.id, mi.notificationBody, mi.notificationDate, mi.notificationLevelType, np.profileId
            // FROM mc_mis_notifications AS mi
            // LEFT JOIN mc_notification_profiles AS np ON np.notificationLevelType = mi.notificationLevelType
            // WHERE mi.notificationLevelType = ?
            // ", [$level]);

            $tmp = DB::table('mc_mis_notifications as mi')
            ->select('mi.id', 'mi.notificationBody', 'mi.notificationDate', 'mi.notificationLevelType', 'np.profileId')
            ->leftJoin('mc_notification_profiles as np', 'np.notificationLevelType', '=', 'mi.notificationLevelType')
            ->where('mi.notificationLevelType', $level)
            ->get();


            }

            // Transform the result
            foreach ($tmp as $t) {
                $childs['id'] = $t->id;
                $childs['notificationBody'] = $t->notificationBody;
                $childs['notificationDate'] = $t->notificationDate;
                $childs['notificationLevelType'] = $t->notificationLevelType;
                $childs['profileId'][] = $t->profileId;
            }

            // Return JSON re sponse
            return response()->json($childs);
        }
    }

    public function createNotificationsData(Request $request)
    {

        if (($request->isMethod('post')) && ($request->ajax() == true)) {

            $notificationModel = $request->post('data');

            if ($notificationModel["levelValue"] == 1) {
                // $notification = MisNotifications::findFirstByNotificationLevelType('LEVEL_2');
                $notification = DB::table('mc_mis_notifications')
                    ->where('notificationLevelType', 'LEVEL_2')
                    ->first();

                if ($notification->notificationDate == $notificationModel["notificationDate"] || $notification->notificationDate > $notificationModel["notificationDate"]) {

                    $dataResponse =  MisReportRepository::saveNotificationData($notificationModel);
                    //  dd( $dataResponse);

                } else {
                    $dataResponse = ' তারিখ টি  অবশ্যই  দ্বিতীয়  লেভেল  নোটিফিকেশনের  তারিখ  এর  আগের  তারিখ  হবে ।';
                }
            } else if ($notificationModel["levelValue"] == 2) {
                // $notification = MisNotifications::findFirstByNotificationLevelType('LEVEL_1');

                $notification = DB::table('mc_mis_notifications')
                    ->where('notificationLevelType', 'LEVEL_1')
                    ->first();
                if ($notification->notificationDate == $notificationModel["notificationDate"] || $notification->notificationDate < $notificationModel["notificationDate"]) {

                    // $dataResponse = $this->misReportService->saveNotificationData($notificationModel);
                    $dataResponse =  MisReportRepository::saveNotificationData($notificationModel);
                } else {

                    $dataResponse = ' তারিখ টি  অবশ্যই   প্রথম  লেভেল  নোটিফিকেশনের  তারিখ  এর   পরের  তারিখ  হবে ।';
                }
            } else if ($notificationModel["levelValue"] == 3) {
                // $dataResponse = $this->misReportService->saveNotificationData($notificationModel);
                $dataResponse =  MisReportRepository::saveNotificationData($notificationModel);
            }
        }
        return response()->json($dataResponse, 200, [], JSON_UNESCAPED_UNICODE);
        // $response = new \Phalcon\Http\Response();
        // $response->setContentType('application/json', 'UTF-8');
        // $response->setContent(json_encode($dataResponse));
        // return $response;

    }

    public function pendingReportList()
    {

        return view('mobile_court.notification.pendingReportList');
    }

    public function printmobilecourtreport(Request $request)
    {
        $office_id = globalUserInfo()->office_id;
        $officeinfo = DB::table('office')->where('id', $office_id)->first();
        $divid =  $officeinfo->division_id;
        $zillaId =  $officeinfo->district_id;
        $zilla_name = $officeinfo->dis_name_bn;
        $divname_name =  $officeinfo->div_name_bn;

        $url = getapiManagerBaseUrl() . '/api/mc/misnotification/printmobilecourtreport';
        $data = $request->all();
        // dd($data);
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
                "profileID" => '',
                "zilla_name" => $zilla_name,
                "month_year" => $res->month_year
            ];
            return response()->json( $data, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('else block');
        }
    }

    public function printappealcasereport(Request $request)
    {

        $url = getapiManagerBaseUrl() . '/api/mc/misnotification/printappealcasereport';
        $data = $request->all();
        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            return response()->json($res, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('else block');
        }
    }
    public function printadmcasereport(Request $request)
    {
        $url = getapiManagerBaseUrl() . '/api/mc/misnotification/printadmcasereport';
        $data = $request->all();
        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            return response()->json($res, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('else block');
        }
    }
    public function printemcasereport(Request $request)
    {
        $url = getapiManagerBaseUrl() . '/api/mc/misnotification/printemcasereport';
        $data = $request->all();
        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            return response()->json($res, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('else block');
        }
    }
    public function printcourtvisitreport(Request $request)
    {

        $url = getapiManagerBaseUrl() . '/api/mc/misnotification/printcourtvisitreport';
        $data = $request->all();
        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            return response()->json($res, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('else block');
        }
    }
    public function printcaserecordreport(Request $request)
    {

        $url = getapiManagerBaseUrl() . '/api/mc/misnotification/printcaserecordreport';
        $data = $request->all();
        // dd($data);
        // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
        $method = 'POST';
        $bodyData = json_encode($data);
        $token = $this->verifySiModuleToken('WEB');
        // dd('setting crpc', $bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
            return response()->json($res, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        } else {
            dd('else block');
        }
    }

    public function sendLevelThreeMessage(Request $request)
    {

        if ($request->isMethod('post') && $request->ajax()) {
            $notificationModel = $request->input('data'); // Get the 'data' from the request
            $dataResponse = MisReportRepository::sendLevel3Message($notificationModel); // Call the service method
            // dd($dataResponse);
            // Return a JSON response
            return response()->json($dataResponse);
        }

        // Optionally handle non-AJAX requests or return an error response
        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function approvedReportList()
    {
        return view('mobile_court.notification.approvedReportList');
    }

    public function getReportsData(Request $request)
    {
        // Check if the request is AJAX and GET
        if ($request->ajax() && $request->isMethod('get')) {
            $url = getapiManagerBaseUrl() . '/api/mc/misnotification/getReportsData';
            $data = $request->all();
            // dd($data);
            // $url = getapiManagerBaseUrl() . '/api/emc/crpc-section/save';
            $method = 'POST';
            $bodyData = json_encode($data);
            $token = $this->verifySiModuleToken('WEB');
            // dd('setting crpc', $bodyData);
            if ($token) {
                $res = makeCurlRequestWithToken($url, $method, $bodyData, $token);
                // dd('get reports data',$res);
                return response()->json($res, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
            } else {
                return response()->json(['error' => 'Bad Request'], 400);
            }
            // Retrieve 'reportId' and 'reportDate' from the query, with default null values if they are missing
            // $reportTypeId = $request->reportId;
            // $reportDate = $request->reportDate;

            // // Call a service method to fetch the report data
            // $dataResponse = MisReportRepository::getMonthlyReportData($reportTypeId, $reportDate);

            // // Return a JSON response with UTF-8 encoding
            // return response()->json($dataResponse, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
        }

        // If the request is not AJAX GET, return a 400 Bad Request response
        return response()->json(['error' => 'Bad Request'], 400);
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

    public function defaultSms_send(Request $request){

    $level1 = "LEVEL_1";
    $level2 = "LEVEL_2";
    $level3 = "LEVEL_3";
   $specificDate = '2024-1-07';

$date = new DateTime($specificDate);

// Deconstruct the date
$year = $date->format('Y');  // 2024
$month = $date->format('m'); // 01
$day = $date->format('d');   // 07

   $levels = ['Level_1', 'Level_2', 'Level_3']; // Example levels

    $notifications = DB::table('mc_mis_notifications as mi')
        ->select('mi.id', 'mi.notificationBody', 'mi.notificationDate', 'mi.notificationLevelType', 'np.profileId')
        ->leftJoin('mc_notification_profiles as np', 'np.notificationLevelType', '=', 'mi.notificationLevelType')
        ->whereIn('mi.notificationLevelType', $levels)
        ->where('mi.notificationDate',$day) // Match the specific date
        ->get();
    
        $notifi=[];
        foreach ($notifications as $notification) {
            $smsContent = $notification->notificationBody;
            $profileId = $notification->profileId;
            $notificationLevelType = $notification->notificationLevelType;
            $notifi[]= $this->sendLevelMessage($smsContent,$profileId,$notificationLevelType);
            
        }
        //  dd($notifi);
        // return response()->json($dataResponse);
   }

   
   public  function sendLevelMessage($smsContent,$profileId,$notificationLevelType)
   {
         
 
 
       $combinedUsers = collect(); // Initialize an empty collection for all users


           // Retrieve users from doptor_user_access_info
           // return $zillaId;
           $doptorUsers = DB::table('users as mag')
               ->join('doptor_user_access_info as dp', 'dp.user_id', '=', 'mag.id')
               ->join('office as of', 'of.id', '=', 'mag.office_id')
               ->where('dp.court_type_id', 1)
               ->where('dp.role_id',$profileId) 
               ->select('mag.name', 'mag.email', 'mag.mobile_no', 'dp.*') // Select necessary columns
               ->get(); // Retrieve all matching records

           // Retrieve users directly from the users table
           $userTableUsers = DB::table('users as mag')
               ->join('office as of', 'of.id', '=', 'mag.office_id')
               ->where('mag.role_id', $profileId) 
               ->select('mag.name', 'mag.email', 'mag.mobile_no')
               ->get();
      
           // Merge both sets of results and add them to the combinedUsers collection
           $combinedUsers = $combinedUsers->merge($doptorUsers)->merge($userTableUsers);
            // return $combinedUsers;
        foreach ($combinedUsers as $data) {

            $name = $data->name;
            // $profileName=$data->designation_bng;
            $email = $data->email;
            $mobile ='01830014474';// $data->mobile_no;
            $notificationBody = $smsContent;
            $notificationSendDate = date("Y-m-d");
            $response = MisReportRepository::SendSmsMessage($mobile,$smsContent);
            // if ($data->email) {
            //     MisReportRepository::sendEmail($email, $notificationModel["notificationBody"], $name);
            // }
            $response = true;
            $status = $response ? 'SUCCESS' : 'FAILED';
            // return $data;
            $data = [
                'name' => $name,
                'profileName' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'notificationBody' => $notificationBody,
                'notificationSendDate' => $notificationSendDate,
                'notificationStatus' => $status,
                'messageLevel' => $notificationLevelType
            ];

            // Insert the data into the notification_logs table
            $inserted = DB::table('mc_notification_logs')->insert($data);

            if ($inserted) {
                // echo $name . " Record inserted successfully";
                return true;
            } else {
                // echo "Error inserting record.";
                return  false;
            }
        }

        return true;
    
   }

   
}
