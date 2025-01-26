<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MisReportRepository
{

    public static function saveNotificationData($notificationModel)
    {

        $notification = DB::table('mc_mis_notifications')
            ->where('id', $notificationModel['id'])
            ->first();
        if ($notification) {
            $notificationData = (array) $notification; // Convert to array for updating
        } else {
            $notificationData = [
                'notificationDate' => null,
                'notificationBody' => '',
                'notificationLevelType' => ''
            ];
        }


        // Update notification fields
        $notificationData['notificationDate'] = !empty($notificationModel['notificationDate']) ? $notificationModel['notificationDate'] : null;
        $notificationData['notificationBody'] = $notificationModel['notificationBody'];

        if ($notificationModel['levelValue'] == 1) {
            $notificationData['notificationLevelType'] = 'LEVEL_1';
        } elseif ($notificationModel['levelValue'] == 2) {
            $notificationData['notificationLevelType'] = 'LEVEL_2';
        } elseif ($notificationModel['levelValue'] == 3) {
            $notificationData['notificationLevelType'] = 'LEVEL_3';
        }

        // Save the notification data
        if ($notification) {
            // Update existing notification
            DB::table('mc_mis_notifications')
                ->where('id', $notificationModel['id'])
                ->update($notificationData);
        } else {
            // Insert new notification
            DB::table('mc_mis_notifications')->insert($notificationData);
        }

        return self::saveProfileNotification($notificationData, $notificationModel);
    }
    public static function saveProfileNotification($notificationData, $notificationModel)
    {

        $notificationProfile = DB::table('mc_notification_profiles')->where('notificationLevelType', $notificationData['notificationLevelType'])->get();

        if (count($notificationProfile) > 0) {

            foreach ($notificationProfile as $item) {

                // $seizure = NotificationProfiles::findFirstById($item->id);
                DB::table('mc_notification_profiles')->where('id', $item->id)->delete();
                // $seizure->delete();
            }
        }
        // dd($notificationModel);
        foreach ($notificationModel["profilesId"] as $profileItem) {

            $data = [
                'profileId' => (int) $profileItem,
                'notificationLevelType' => $notificationData['notificationLevelType'],
                // Include other fields if necessary
            ];
            //  dd($data);
            // Insert the data using a raw DB query
            DB::table('mc_notification_profiles')->insert($data);
        }

        return true;
    }

    public static function sendLevel3Message($notificationModel)
    {
        $divId = $notificationModel["divId"];
        $zillaId = $notificationModel["zillaId"];


        $combinedUsers = collect(); // Initialize an empty collection for all users

        foreach ($notificationModel["profilesId"] as $profile) {
            // Retrieve users from doptor_user_access_info
            // return $zillaId;
            $doptorUsers = DB::table('users as mag')
                ->join('doptor_user_access_info as dp', 'dp.user_id', '=', 'mag.id')
                ->join('office as of', 'of.id', '=', 'mag.office_id')
                ->where('dp.court_type_id', 1)
                ->where('of.district_id', $zillaId) // Filter by district_id
                ->where('of.division_id', $divId) // Filter by division_id
                ->where('dp.role_id', $profile) // Filter by role_id
                ->select('mag.name', 'mag.email', 'mag.mobile_no', 'dp.*') // Select necessary columns
                ->get(); // Retrieve all matching records

            // Retrieve users directly from the users table
            $userTableUsers = DB::table('users as mag')
                ->join('office as of', 'of.id', '=', 'mag.office_id')
                ->where('of.district_id', $zillaId) // Filter by district_id
                ->where('of.division_id', $divId) // Filter by division_id
                ->where('mag.role_id', $profile) // Filter by role_id
                ->select('mag.name', 'mag.email', 'mag.mobile_no') // Select necessary columns (adjust as needed)
                ->get(); // Retrieve all matching records

            // Merge both sets of results and add them to the combinedUsers collection
            $combinedUsers = $combinedUsers->merge($doptorUsers)->merge($userTableUsers);
        }
        // return $combinedUsers;
        foreach ($combinedUsers as $data) {

            $name = $data->name;
            // $profileName=$data->designation_bng;
            $email = $data->email;
            $mobile = $data->mobile_no;
            $notificationBody = $notificationModel["notificationBody"];
            $notificationSendDate = date("Y-m-d");
            $response = self::SendSmsMessage($mobile, $notificationModel["notificationBody"]);
            if ($data->email) {
                self::sendEmail($email, $notificationModel["notificationBody"], $name);
            }
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
                'messageLevel' => 'LEVEL_3'
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



    public static function SendSmsMessage($to, $message)
    {
        $curl = curl_init();
        $new_message = curl_escape($curl, $message);
        $newto = '88' . $to;
        $url = 'http://103.69.149.50/api/v2/SendSMS?SenderId=8809617612638&Is_Unicode=true&ClientId=ec63aede-1c7e-4a5a-a1ad-36b72ab30817&ApiKey=AeHZPUEZXIILtxg0VEaGjsK%2BuPNlzhCDW0VuFRmcchs%3D&Message=' . $new_message . '&MobileNumbers=' . $newto;
        // dd($url);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    // public static function SendSmsMessage($mobile, $message)
    // {
    //     // $ms = self::toEnglish($mobile);
    //     $ms = $mobile;
    //     $txt = urlencode($message);

    //     if (substr($ms, 0, 3) != '+88') {
    //         $ms = '+88' . $ms;
    //     }
    //     try {
    //         /* $Response = file_get_contents("http://123.49.3.58:8081/web_send_sms.php?ms=" . $ms . "&txt=" . $txt . "&username=pmoffice&password=pmoffice",false,$options);*/
    //         $Response = file_get_contents("'http://103.69.149.50/api/v2/SendSMS?SenderId=8809617612638&Is_Unicode=true&ClientId=ec63aede-1c7e-4a5a-a1ad-36b72ab30817&ApiKey=AeHZPUEZXIILtxg0VEaGjsK%2BuPNlzhCDW0VuFRmcchs%3D&Message=' .$txt . '&MobileNumbers=' . $ms");
    //     } catch (\Exception $e) {
    //         $Response = 'error';
    //     }
    //     if ($Response == 'error') {
    //         return false;
    //     }
    //     if (strpos($Response, 'SUCCESS') !== false) {
    //         return true;
    //     } else if (strpos($Response, 'FAILED') !== false) {
    //         return false;
    //     }

    //     return true;
    // }
    public static function sendEmail($email_address_receiver, $notificationBody, $name_of_receiver)
    {
        $details = [
            'email_address_receiver' => $email_address_receiver,
            'email_subject' => "MIS Notification",
            'email_body' => $notificationBody,
            'name_of_receiver' => $name_of_receiver,

        ];

        $job = (new \App\Jobs\SendEmailNotificationJob($details))->delay(now()->addSeconds(2));

        dispatch($job);
    }

    public static function toEnglish($number)
    {
        $search_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", ".");
        $replace_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", ".");
        $enNumber = str_replace($search_array, $replace_array, $number);

        return $enNumber;
    }

    public static function getMonthlyReportData($reportTypeId, $reportDate)
    {
        $mth = substr($reportDate, 0, 2);
        $yr = substr($reportDate, 3, 4);
        $data = DB::table('monthly_reports')->where('report_year', $yr)
            ->where('report_month', $mth)
            ->where('report_type_id', $reportTypeId)
            ->select('*')
            ->get(); // Use first() to get a single record

        $formattedResults = $data->map(function ($item) {
            return (array) $item; // Convert each result to an array
        })->values()->all(); // Re-index the array

        // Return the final formatted results
        return $formattedResults;
        // // If no data is found, handle accordingly
        // return response()->json([]);
    }

    public static function getCountryBasedReportData($presentDate,$previousDate,$reportId){
        $resultset = [];
        $totResult = [];
        $reportName = "No data Found";
        $reportCommonHeading = "গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</br>মন্ত্রিপরিষদ বিভাগ</br>জেলা ম্যাজিস্ট্রেসি পরিবীক্ষণ অধিশাখা";

        $preMnth = (int)substr($presentDate, 0, 2);
        $preYr = substr($presentDate, 3, 4);
        $pastMnth = (int)substr($previousDate, 0, 2);
        $pastYr = substr($previousDate, 3, 4);

        // Swap if present year is less than past year
        if ($preYr < $pastYr) {
            [$preYr, $pastYr] = [$pastYr, $preYr];
            [$preMnth, $pastMnth] = [$pastMnth, $preMnth];
        }

        // Generate Bangla month and year
        $preBanglaMonthYear = self::get_bangla_monthandyearbymumber($preMnth, $preYr);
        $pastBanglaMonthYear = self::get_bangla_monthandyearbymumber($pastMnth, $pastYr);

        // Conditions based on reportId
        $query1Selection = "COALESCE(SUM(mr.case_submit), 0) as caseSubmitTotal,
                            COALESCE(SUM(mr.case_total), 0) as caseTotal,
                            COALESCE(SUM(mr.case_complete), 0) as caseCompleteTotal,
                            COALESCE(SUM(mr.case_incomplete), 0) as caseIncompleteTotal";
        $query2Selection = "SUM(x.caseSubmitTotal) as totalCaseSubmit,
                            SUM(x.caseTotal) as totalCase,
                            SUM(x.caseCompleteTotal) as totalCaseComplete,
                            SUM(x.caseIncompleteTotal) as totalCaseIncomplete";
        $reportIdCondition = "";

        if ($reportId == 1) {
            $reportName = "$reportCommonHeading</br>{$pastBanglaMonthYear} থেকে {$preBanglaMonthYear} সালের মোবাইল কোর্ট পরিচালনা সংক্রান্ত তথ্যসমূহ";
            $query1Selection = "COALESCE(SUM(mr.promap), 0) as promapTotal,
                                COALESCE(SUM(mr.court_total), 0) as courtTotal,
                                COALESCE(SUM(mr.case_total), 0) as caseTotal,
                                COALESCE(SUM(mr.fine_total), 0) as fineTotal,
                                COALESCE(CONCAT(CEIL((SUM(mr.court_total) / SUM(mr.promap)) * 100), '%'), '0%') as promapPercentage";
            $reportIdCondition = "mr.report_type_id = 1 AND";
            $query2Selection = "SUM(x.promapTotal) as TOTALPROMAP,
                                SUM(x.courtTotal) as TOTALCOURT,
                                SUM(x.caseTotal) as TOTALCASE,
                                SUM(x.fineTotal) as TOTALFINE,
                                CONCAT(CEIL((SUM(x.promapPercentage) / COUNT(x.report_month))), '%') as avgPromapPercentage";
        } elseif ($reportId == 2) {
            $reportName = "$reportCommonHeading</br>{$pastBanglaMonthYear} থেকে {$preBanglaMonthYear} সালের ফৌজদারী কার্যবিধির আপিল সংক্রান্ত তথ্যসমূহ";
            $reportIdCondition = "mr.report_type_id = 2 AND";
        } elseif ($reportId == 3) {
            $reportName = "$reportCommonHeading</br>{$pastBanglaMonthYear} থেকে {$preBanglaMonthYear} সালের ফৌজদারী কার্যবিধির অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালত সংক্রান্ত তথ্যসমূহ";
            $reportIdCondition = "mr.report_type_id = 3 AND";
        } elseif ($reportId == 4) {
            $reportName = "$reportCommonHeading</br>{$pastBanglaMonthYear} থেকে {$preBanglaMonthYear} সালের ফৌজদারী কার্যবিধির এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালত সংক্রান্ত তথ্যসমূহ";
            $reportIdCondition = "mr.report_type_id = 4 AND";
        }

        $condition = "(mr.report_year = $pastYr AND mr.report_month >= $pastMnth) OR (mr.report_year = $preYr AND mr.report_month <= $preMnth)";

        $diffYr = $preYr - $pastYr;
        if ($diffYr > 1) {
            $condition .= " OR (mr.report_year > $pastYr AND mr.report_year < $preYr)";
        } elseif ($diffYr == 0 && $pastMnth > $preMnth) {
            [$pastMnth, $preMnth] = [$preMnth, $pastMnth];
            $condition = "(mr.report_year = $preYr AND (mr.report_month >= $pastMnth AND mr.report_month <= $preMnth))";
        }

        // Main query
            $query1 = DB::table('monthly_reports as mr')
                ->selectRaw("
                    CASE mr.report_month
                        WHEN 1 THEN 'জানুয়ারী'
                        WHEN 2 THEN 'ফেব্রুয়ারী'
                        WHEN 3 THEN 'মার্চ'
                        WHEN 4 THEN 'এপ্রিল'
                        WHEN 5 THEN 'মে'
                        WHEN 6 THEN 'জুন'
                        WHEN 7 THEN 'জুলাই'
                        WHEN 8 THEN 'আগস্ট'
                        WHEN 9 THEN 'সেপ্টেম্বর'
                        WHEN 10 THEN 'অক্টোবর'
                        WHEN 11 THEN 'নভেম্বর'
                        WHEN 12 THEN 'ডিসেম্বর'
                    END AS cMonth,
                    mr.report_month,
                    mr.report_year,
                    $query1Selection
                ")
                ->whereRaw("is_approved = 1 AND $reportIdCondition ($condition)")
                ->groupBy('mr.report_year', 'mr.report_month');

            $query1Sql = $query1->toSql();

            // Execute the first query to get the data
            $resultset = $query1->get();
      
            $resultset1="";
            if ($reportId  == 1){
             $resultset1=$resultset->map(function($item) {
              
                return [
                    0 => $item->cMonth,
                    1 => (string) $item->report_month,
                    2 => (string) $item->report_year,
                    3 => $item->promapTotal,
                    4 => $item->courtTotal,
                    5 => $item->caseTotal,
                    6 => $item->fineTotal,
                    7 => $item->promapPercentage,
                    'cMonth' => $item->cMonth,
                    'report_month' => (string) $item->report_month,
                    'report_year' => (string) $item->report_year,
                    'promapTotal' => $item->promapTotal,
                    'courtTotal' => $item->courtTotal,
                    'caseTotal' => $item->caseTotal,
                    'fineTotal' => $item->fineTotal,
                    'promapPercentage' => $item->promapPercentage
                ];
            });
           }elseif($reportId  != 1){
          
            $resultset1 = $resultset->map(function($item) {
                return [
                    0 => $item->cMonth,
                    1 => (string) $item->report_month,
                    2 => (string) $item->report_year,
                    3 => $item->caseSubmitTotal,
                    4 => $item->caseTotal,
                    5 => $item->caseCompleteTotal,
                    6 => $item->caseIncompleteTotal,
                    'cMonth' => $item->cMonth,
                    'report_month' => (string) $item->report_month,
                    'report_year' => (string) $item->report_year,
                    'caseSubmitTotal' => $item->caseSubmitTotal,
                    'caseTotal' => $item->caseTotal,
                    'caseCompleteTotal' => $item->caseCompleteTotal,
                    'caseIncompleteTotal' => $item->caseIncompleteTotal
                ];
            });

           }
       
            // Summary query
            $result2="";
            $query2 = DB::table(DB::raw("({$query1Sql}) as x"))
            ->selectRaw($query2Selection)
            ->mergeBindings($query1)  
            ->get();
            if ($reportId == 1){
             
             $result2=$query2->map(function($item) {

                return [
                    0 => $item->TOTALPROMAP,
                    1 => $item->TOTALCOURT,
                    2 => $item->TOTALCASE,
                    3 => $item->TOTALFINE,
                    4 => $item->avgPromapPercentage,
                    'TOTALPROMAP' => $item->TOTALPROMAP,
                    'TOTALCOURT' => $item->TOTALCOURT,
                    'TOTALCASE' => $item->TOTALCASE,
                    'TOTALFINE' => $item->TOTALFINE,
                    'avgPromapPercentage' => $item->avgPromapPercentage
                ];
            });
            
           }elseif($reportId !=1){
           
            $result2 = $query2->map(function($item) {
                
                return [
                    0 => $item->totalCaseSubmit,
                    1 => $item->totalCase,
                    2 => $item->totalCaseComplete,
                    3 => $item->totalCaseIncomplete,
                    'totalCaseSubmit' => $item->totalCaseSubmit,
                    'totalCase' => $item->totalCase,
                    'totalCaseComplete' => $item->totalCaseComplete,
                    'totalCaseIncomplete' => $item->totalCaseIncomplete
                ];
            });
           } 
 
            return [
                "resultSet" => $resultset1,
                "totResult" =>  $result2,
                "reportName" => $reportName
            ];
    

    }

    public static function get_bangla_monthandyearbymumber($month, $year)
    {

        if ($year == "") {

            $year = self::bangla_number(date('Y'));
        }else{
            $year=self::bangla_number($year);
        }
        $mons = array(1 => "জানুয়ারী", 2 => "ফেব্রুয়ারী", 3 => "মার্চ", 4 => "এপ্রিল", 5 => "মে", 6 => "জুন", 7 => "জুলাই", 8 => "আগস্ট", 9 => "সেপ্টেম্বর", 10 => "অক্টোবর", 11 => "নভেম্বর", 12 => "ডিসেম্বর");
        $month_name = $mons[$month];

        return $month_name . " " . $year;
    }
    public static function bangla_number($int){
        $engNumber = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
        $bangNumber = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');

        $converted = str_replace($engNumber, $bangNumber, $int);
        return $converted;
    }
}
