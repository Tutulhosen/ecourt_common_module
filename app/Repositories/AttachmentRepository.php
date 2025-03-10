<?php

namespace App\Repositories;

use App\Appeal;

use App\Models\EmAttachment;
use App\Models\CauseList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AttachmentRepository
{
    public static function appStoreAttachment($appName, $appealId, $causeListId, $captions, $request = null)
    {
        $image_name = $request->file_name['name'];
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $log_file_data = [];
        // $test = [];
        // ["file_name"]['name']
        foreach ($image_name as $key => $file) {

            $fileCategory = $captions[$i];


            $base364mage = substr($file, strpos($file, ',') + 1);

            $extension = explode('/', explode(';', $file)[0])[1];
            $image_data = base64_decode($base364mage);
            //   $fileName=$fileCategory.$appealId.$extension;
            if ($file != "" && $fileCategory != null) {
                $fileName = strtolower($image_data);
                $fileExtension = '.' . $extension;

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;
                    $causeListID = 'CauseListID - ' . $causeListId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    $attachment = new EmAttachment();
                    $attachment->appeal_id = $appealId;
                    $attachment->cause_list_id = $causeListId;
                    $attachment->file_type = $fileContentType;
                    $attachment->file_category = $fileCategory;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                    $attachment->file_submission_date = date('Y-m-d H:i:s');
                    $attachment->created_at = date('Y-m-d H:i:s');
                    // $attachment->created_by = Session::get('userInfo')->username;
                    $attachment->created_by = Auth::user()->username;
                    $attachment->updated_at = date('Y-m-d H:i:s');
                    // $attachment->updated_by = Session::get('userInfo')->username;
                    $attachment->updated_by = Auth::user()->username;
                    // dd($attachment);
                    $attachment->save();
                    // $test[$key] = $attachment;
                    // move_uploaded_file($image_data, $filePath . $fileName);
                    file_put_contents($filePath . $fileName, $image_data);
                    $file_in_log = [

                        'file_category' => $fileCategory,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/'
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);
        return json_encode($log_file_data);
    }
    public static function storeAttachment($appName, $causeListId, $captions)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $log_file_data = [];
        // $test = [];
        // ["file_name"]['name']
        foreach ($_FILES['file_name']["name"] as $key => $file) {
            $tmp_name = $_FILES['file_name']["tmp_name"][$key];
            $fileName = $_FILES['file_name']["name"][$key];
            $fileCategory = $captions[$i];

            //dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }
                $extn = 'data:application/' . pathinfo($fileName, PATHINFO_EXTENSION) . ';base64,';
                $tmp_base_64 = $extn . base64_encode(file_get_contents($tmp_name));
                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $causeListID = 'CauseListID - ' . $causeListId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . '/' . $causeListID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath,  0777, TRUE);
                    }
                    // move_uploaded_file($tmp_name, $filePath . $fileName);
                    $file_in_log = [

                        'appName' => $appName,
                        'file_category' => $fileCategory,
                        'causeListID' => $causeListID,
                        'fileContentType' => $fileContentType,
                        'tmp_name' => $tmp_name,
                        'tmp_base_64' => $tmp_base_64,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/'  . $causeListID . '/',
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);
        return json_encode($log_file_data);
    }

    public static function getAttachmentListByAppealId($appealId)
    {
        $attachmentList = DB::connection('mysql')
            ->table('em_attachments')
            ->leftjoin('em_cause_lists', 'em_cause_lists.id', '=', 'em_attachments.cause_list_id')
            ->where('em_attachments.appeal_id', $appealId)
            ->get();
        return $attachmentList;
    }

    public static function getAttachmentListByAppealIdAndCauseListId($appealId, $causeListId)
    {
        // $attachmentList=DB::connection('appeal')
        $attachmentList = DB::connection('mysql')
            ->table('em_cause_lists')
            ->join('em_attachments', 'em_cause_lists.id', '=', 'em_attachments.cause_list_id')
            ->where('em_attachments.appeal_id', $appealId)
            ->where('em_cause_lists.id', $causeListId)
            ->get();
        return $attachmentList;
    }

    public static function getAttachmentListByPaymentId($paymentId)
    {
        $attachmentList = DB::connection('appeal')
            ->table('attachments')
            ->where('attachments.payment_id', $paymentId)
            ->get();
        return $attachmentList;
    }

    public static function deleteFileByFileID($fileID)
    {

        $attachment = EmAttachment::find($fileID);
        $fileName = $attachment->file_name;

        $attachmentUrl = config('app.attachmentUrl');
        $filePath = $attachmentUrl . $attachment->file_path;
        if ($attachment !== false) {
            if ($attachment->delete() === false) {

                $messages = $attachment->getMessages();

                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } else {
                unlink($filePath . $fileName);
            }
        }
    }

    public static function deleteAppealFile($fileID, $appealID)
    {

        $attachment = EmAttachment::find($fileID);
        $fileName = $attachment->file_name;
        LogManagementRepository::Appealfiledelete($attachment, $appealID);
        $attachmentUrl = config('app.attachmentUrl');
        $filePath = $attachmentUrl . $attachment->file_path;
        if ($attachment !== false) {
            if ($attachment->delete() === false) {

                $messages = $attachment->getMessages();

                foreach ($messages as $message) {
                    echo $message, "\n";
                }
            } else {
                unlink($filePath . $fileName);
            }
        }
    }

    public static function getGUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function storeAttachmentOnPayment($appName, $appealId, $paymentId, $captions)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;

        foreach ($_FILES["files"]["name"] as $key => $file) {
            $tmp_name = $_FILES["files"]["tmp_name"][$key]['someName'];
            $fileName = $_FILES["files"]["name"][$key]['someName'];
            $fileCategory = $captions[$i]['someCaption'];

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;
                    $causeListID = 'PaymentID - ' . $paymentId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' . $causeListID . '/';
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    $attachment = new EmAttachment();
                    $attachment->appeal_id = $appealId;
                    $attachment->payment_id = $paymentId;
                    $attachment->file_type = $fileContentType;
                    $attachment->file_category = $fileCategory;
                    $attachment->file_name = $fileName;
                    $attachment->file_path = $appName . '/' . $appealYear . '/' . $appealID . '/' . $causeListID . '/';
                    $attachment->file_submission_date = date('Y-m-d H:i:s');
                    $attachment->created_at = date('Y-m-d H:i:s');
                    $attachment->created_by = globalUserInfo()->username;
                    $attachment->updated_at = date('Y-m-d H:i:s');
                    $attachment->updated_by = globalUserInfo()->username;
                    $attachment->save();
                    move_uploaded_file($tmp_name, $filePath . $fileName);
                }
            }
            $i++;
        }
    }

    public static function storeInvestirationAttachment($appName, $appealId, $captions, $captions_others_investigation_report)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        // $test = [];
        // ["file_name"]['name']
        $log_file_data = [];
        foreach ($_FILES['file_name']["name"] as $key => $file) {
            $tmp_name = $_FILES['file_name']["tmp_name"][$key];
            $fileName = $_FILES['file_name']["name"][$key];
            $fileCategory = $captions_others_investigation_report . ' ' . $captions[$i];

            // dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;


                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    // $attachment = new EmAttachment();
                    // $attachment->appeal_id = $appealId;
                    // $attachment->file_type = $fileContentType;
                    // $attachment->file_category = $fileCategory;
                    // $attachment->file_name = $fileName;
                    // $attachment->file_path = $appName . '/' . $appealYear . '/' .$appealID. '/';
                    // $attachment->file_submission_date = date('Y-m-d H:i:s');
                    // $attachment->created_at = date('Y-m-d H:i:s');
                    // // $attachment->created_by = Session::get('userInfo')->username;
                    // // $attachment->created_by = Auth::user()->username;
                    // $attachment->updated_at = date('Y-m-d H:i:s');
                    // // $attachment->updated_by = Session::get('userInfo')->username;
                    // // $attachment->updated_by = Auth::user()->username;
                    // // dd($attachment);
                    // $attachment->save();
                    // $test[$key] = $attachment;
                    move_uploaded_file($tmp_name, $filePath . $fileName);
                    $file_in_log = [

                        // 'file_id'=>$attachment->id,
                        'file_category' => $fileCategory,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/'
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);

        return json_encode($log_file_data);
    }
    public static function storeInvestirationMainAttachment($appName, $appealId, $captions_main_investigation_report)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        // $test = [];
        // ["file_name"]['name']
        $log_file_data = [];
        foreach ($_FILES['show_cause']["name"] as $key => $file) {
            $tmp_name = $_FILES['show_cause']["tmp_name"][$key];
            $fileName = $_FILES['show_cause']["name"][$key];
            $fileCategory = 'x';

            // dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }
                $extn = 'data:application/' . pathinfo($fileName, PATHINFO_EXTENSION) . ';base64,';
                $tmp_base_64 = $extn . base64_encode(($tmp_name));
                // return base64_decode(file_get_contents($tmp_name));
                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $appealID = 'AppealID - ' . $appealId;


                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    // $attachment = new EmAttachment();
                    // $attachment->appeal_id = $appealId;
                    // $attachment->file_type = $fileContentType;
                    // $attachment->file_category = $fileCategory;
                    // $attachment->file_name = $fileName;
                    // $attachment->file_path = $appName . '/' . $appealYear . '/' .$appealID. '/';
                    // $attachment->file_submission_date = date('Y-m-d H:i:s');
                    // $attachment->created_at = date('Y-m-d H:i:s');
                    // // $attachment->created_by = Session::get('userInfo')->username;
                    // // $attachment->created_by = Auth::user()->username;
                    // $attachment->updated_at = date('Y-m-d H:i:s');
                    // // $attachment->updated_by = Session::get('userInfo')->username;
                    // // $attachment->updated_by = Auth::user()->username;
                    // // dd($attachment);
                    // $attachment->save();
                    // // $test[$key] = $attachment;
                    // move_uploaded_file($tmp_name, $filePath . $fileName);
                    $file_in_log = [

                        // // 'file_id'=>$attachment->id,
                        // 'file_category'=>$captions_main_investigation_report,
                        // 'file_name'=>$fileName,
                        // 'file_path' => $appName . '/' . $appealYear . '/' .$appealID. '/'
                        'appName' => $appName,
                        'file_category' => $fileCategory,
                        // 'causeListID'=>$causeListID,
                        'fileContentType' => $fileContentType,
                        'tmp_name' => $tmp_name,
                        'tmp_base_64' => $tmp_base_64,
                        'file_name' => $fileName,
                        // 'file_path' => $appName . '/' . $appealYear . '/'  .$causeListID. '/',
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);

        return json_encode($log_file_data);
    }

    public static function storeInvestirationMainAttachment_new($appName, $appealId,$captions_main_investigation_report)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        // $test = [];
        // ["file_name"]['name']
        $log_file_data=[];
        foreach ($_FILES['show_cause']["name"] as $key => $file) {
            $tmp_name = $_FILES['show_cause']["tmp_name"][$key];
            $fileName = $_FILES['show_cause']["name"][$key];
            $fileCategory = 'x';
            
            // dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }

                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear ='APPEAL - '. date('Y');
                    $appealID = 'AppealID - '.$appealId;
                    

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' ;
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    
                    move_uploaded_file($tmp_name, $filePath . $fileName);
                    $file_in_log=[
                        
                        // 'file_id'=>$attachment->id,
                        'file_category'=>$captions_main_investigation_report,
                        'file_name'=>$fileName,
                        'file_path' => $appName . '/' . $appealYear . '/' .$appealID. '/'
                    ];
                }
                array_push($log_file_data,$file_in_log);
            }
            $i++;
        }
        // dd($test);

        return json_encode($log_file_data);
    }

   
    public static function investigation_attachment_base64($appName, $causeListId, $captions, $_file)
    {
        
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $log_file_data = [];
        // $test = [];
        // ["file_name"]['name']
        foreach ($_file["name"] as $key => $file) {
            $tmp_name = $_file["tmp_name"][$key];
            $fileName = $_file["name"][$key];
            $fileCategory = $captions;

            //dd($tmp_name.$fileName.$fileCategory);

            if ($fileName != "" && $fileCategory != null) {
                $fileName = strtolower($fileName);
                $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                $fileContentType = "";
                if (in_array($fileExtension, $image)) {
                    $fileContentType = 'IMAGE';
                }
                if (in_array($fileExtension, $document)) {
                    $fileContentType = 'DOCUMENT';
                }
                if (in_array($fileExtension, $pdf)) {
                    $fileContentType = 'PDF';
                }
                if (in_array($fileExtension, $excel)) {
                    $fileContentType = 'EXCEL';
                }
                if (in_array($fileExtension, $text)) {
                    $fileContentType = 'TEXT';
                }
                $extn = 'data:application/' . pathinfo($fileName, PATHINFO_EXTENSION) . ';base64,';
                $tmp_base_64 = $extn . base64_encode(file_get_contents($tmp_name));
                $fileName = self::getGUID() . $fileExtension;
                if ($fileContentType != "") {
                    $appealYear = 'APPEAL - ' . date('Y');
                    $causeListID = 'CauseListID - ' . $causeListId;

                    $attachmentUrl = config('app.attachmentUrl');

                    $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . '/' . $causeListID . '/';
                    // dd($filePath);
                    if (!is_dir($filePath)) {
                        mkdir($filePath,  0777, TRUE);
                    }
                    // move_uploaded_file($tmp_name, $filePath . $fileName);
                    $file_in_log = [

                        'appName' => $appName,
                        'file_category' => $fileCategory,
                        'causeListID' => $causeListID,
                        'fileContentType' => $fileContentType,
                        'tmp_name' => $tmp_name,
                        'tmp_base_64' => $tmp_base_64,
                        'file_name' => $fileName,
                        'file_path' => $appName . '/' . $appealYear . '/'  . $causeListID . '/',
                    ];
                }
                array_push($log_file_data, $file_in_log);
            }
            $i++;
        }
        // dd($test);
        return json_encode($log_file_data);
    }

    public static function storeInvestirationCourtFree($appName, $appealId, $captions_main_investigation_report)
    {
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");


        $log_file_data = [];

        $tmp_name = $_FILES['court_fee_file']["tmp_name"];
        $fileName = $_FILES['court_fee_file']["name"];
        $fileCategory = 'x';

        if ($fileName != "" && $fileCategory != null) {
            $fileName = strtolower($fileName);
            $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);

            $fileContentType = "";
            if (in_array($fileExtension, $image)) {
                $fileContentType = 'IMAGE';
            }
            if (in_array($fileExtension, $document)) {
                $fileContentType = 'DOCUMENT';
            }
            if (in_array($fileExtension, $pdf)) {
                $fileContentType = 'PDF';
            }
            if (in_array($fileExtension, $excel)) {
                $fileContentType = 'EXCEL';
            }
            if (in_array($fileExtension, $text)) {
                $fileContentType = 'TEXT';
            }

            $fileName = self::getGUID() . $fileExtension;
            if ($fileContentType != "") {
                $appealYear = 'APPEAL - ' . date('Y');
                $appealID = 'AppealID - ' . $appealId;


                $attachmentUrl = config('app.attachmentUrl');

                $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/';
                // dd($filePath);
                if (!is_dir($filePath)) {
                    mkdir($filePath, 0777, true);
                }
                move_uploaded_file($tmp_name, $filePath . $fileName);
                $file_in_log = [
                    'file_category' => $captions_main_investigation_report,
                    'file_name' => $fileName,
                    'file_path' => $appName . '/' . $appealYear . '/' . $appealID . '/'
                ];
            }
            array_push($log_file_data, $file_in_log);
        }
        // dd($log_file_data);
        if (!empty($log_file_data)) {

            return json_encode($log_file_data);
        } else {
            return null;
        }
    }
}
