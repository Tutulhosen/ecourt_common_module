<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\CauseListRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\LogManagementRepository;
use App\Traits\TokenVerificationTrait;

class InvestigationController extends Controller
{
    use TokenVerificationTrait;
    public function investigation_report($id, $mobile_no, $investigator_id)
    {

        $data = session('investigate_data');
        $data['id'] = $id;
        $data['mobile_no'] = $mobile_no;
        $data['investigator_id'] = $investigator_id;
        // dd($data);

        return view('Investigation.report-after-verification')->with($data);
    }
    public function investigator_verify()
    {
        return view('Investigation.form-verification');
    }
    public function investigator_verify_form_submit(Request $request)
    {
        $investigation_tracking_code = $request->investigation_tracking_code;
        $case_no = $request->case_no;
        $mobile_number = $request->mobile_number;
        $url = getapiManagerBaseUrl() . '/api/check/validInvestigationData';
        $data = [];
        $data['case_no'] = $case_no;
        $data['mobile_number'] = $mobile_number;
        $data['investigation_tracking_code'] = $investigation_tracking_code;
        $res = makeCurlRequest($url, "POST", json_encode($data));

      

        if ($res) {
            if ($res->status == 'failed') {
                return back()->with('message', 'আপনাকে খুজে পাওয়া যাচ্ছে না')->withInput();
            }
            if ($res->status == 'success') {
                $data = [];
                $data['investigator'] = $res->investigator;
                $data['case_no'] = $case_no;
                $data['investigate_data'] = $res->investigate_data;

                session(['investigate_data' => $data]);
                return redirect()->route('investigation.report', ['id' => encrypt($res->appeal_id->id), 'mobile_no' => encrypt($mobile_number), 'investigator_id' => encrypt($res->investigator->id)]);
            }
        } else {
            return back()->with('message', 'Something went wrong!!!')->withInput();
        }
    }
    public function investigator_form_submit(Request $request)
    {

     

        if (empty($_FILES["show_cause"]["name"][0])) {

            return Redirect::back()->with('withError', 'তদন্ত প্রতিবেদনের প্রধান রিপোর্ট দিতে হবে ')->with('error', 'প্রধান প্রতিবেদন জমা দেয়া হয় নাই');
        }

        // $this->validate(
        //     $request,
        //     [
        //         'full_name' => 'required',
        //         'office_name' => 'required',
        //         'subject' => 'required',
        //         'case_no' => 'required',
        //         'report_after_verification_date' => 'required',
        //         'memorial_no' => 'required',
        //     ],
        //     [
        //         'full_name.required' => 'আপনার নাম দিতে হবে',

        //         'office_name.required' => 'আপনার অফিসের নাম দিতে হবে',

        //         'subject.required' => 'বিষয় দিতে হবে',

        //         'case_no.required' => 'মামলা নম্বর দিতে হবে',

        //         'report_after_verification_date.required' => 'তারিখ দিতে হবে',
        //         'memorial_no.required' => 'স্বারক নং দিতে হবে',
        //     ],
        // );
        $log_file_data = null;
        $log_file_data_main = null;

       
        $data = session('investigate_data');

        // dd($_FILES['show_cause']);
        if (!empty($_FILES['show_cause'])) {
            if ($_FILES['show_cause']['name']) {
      
                $log_file_data_main = AttachmentRepository::investigation_attachment_base64('Investrigation', $request->appeal_id, $request->todonto_attached, $_FILES['show_cause']);
            }
        }
   
        if (!empty($_FILES['file_name'])) {
            if ($_FILES['file_name']['name']) {
           
                $log_file_data = AttachmentRepository::investigation_attachment_base64('others', $request->appeal_id, $request->file_type, $_FILES['file_name']);
            }
        }
        

      
        $insert_data = [
            'appeal_id' => $request->appeal_id,
            'investigator_id' => $request->investigator_id,
            'investigator_name' => $request->full_name,
            'investigator_organization' => $request->office_name,
            'investigation_subject' => $request->subject,
            'investigator_mobile' => $request->investigator_mobile,
            'case_no' => $request->case_no,
            'memorial_no' => $request->memorial_no,
            'investigation_comments' => $request->investigation_comments,
            'investigation_date' => $request->report_after_verification_date,
            'investigation_attachment' =>  $log_file_data,
            'investigation_attachment_main' => $log_file_data_main,
        ];

        
        // dd($insert_data);

        // dd($insert_data['investigator_name']);
        $url = getapiManagerBaseUrl() . '/api/submitFromData';
        $method = 'POST';
        $bodyData = $insert_data;
       
        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd($res);
            if ($res) {
                if ($res->status == 200) {
                    return redirect()
                        ->route('investigator.verify')
                        ->with('success_report', 'তদন্ত রিপোর্ট  প্রদান সফল হয়েছে');
                } else {
                    return back()->with('message', 'Something went wrong!!!')->withInput();
                }
            } else {
                return back()->with('message', 'Something went wrong!!!')->withInput();
            }
        }
    }

    public function investigation_approve(Request $request)
    {
        $origin_id = explode('_', $request->id);
        $data = ['is_investigation_report_accepted' => 1];
        //em_investigation_report
        $investigation_report = DB::table('em_investigation_report')
            ->where('id', '=', end($origin_id))
            ->first();

        // var_dump($investigation_report);
        // exit();
        $investigator_details = DB::table('em_investigators')
            ->where('id', '=', $investigation_report->investigator_id)->first();

        $investigator_details_array = [
            'id' => $investigator_details->id,
            'appeal_id' => $investigator_details->appeal_id,
            'type_id' => $investigator_details->type_id,
            'nothi_id' => $investigator_details->nothi_id,
            'name' => $investigator_details->name,
            'organization' => $investigator_details->organization,
            'designation' => $investigator_details->designation,
            'mobile' => $investigator_details->mobile,
            'email' => $investigator_details->email,
        ];


        $investigation_report_array = [
            'appeal_id' => $investigation_report->appeal_id,
            'investigator_name' => $investigation_report->investigator_name,
            'investigator_organization' => $investigation_report->investigator_organization,
            'investigation_subject' => $investigation_report->investigation_subject,
            'case_no' => $investigation_report->case_no,
            'memorial_no' => $investigation_report->memorial_no,
            'investigation_comments' => $investigation_report->investigation_comments,
            'investigation_date' => $investigation_report->investigation_date,
            'investigation_attachment' => json_decode($investigation_report->investigation_attachment),
            'investigation_attachment_main' => json_decode($investigation_report->investigation_attachment_main),

        ];


        LogManagementRepository::investigationreportApprove($investigation_report_array, $investigator_details_array, $investigation_report->appeal_id);


        $updated = DB::table('em_investigation_report')
            ->where('id', end($origin_id))
            ->update($data);

        if ($updated) {
            return response()->json([
                'success' => 'success',
            ]);
        }
    }
    public function investigation_details_single($id)
    {
        $investigation_single_report = DB::table('em_investigation_report')
            ->where('id', '=', $id)
            ->first();
        $investigator_details = DB::table('em_investigators')
            ->where('id', '=', $investigation_single_report->investigator_id)
            ->first();


        $evidenceinfo = DB::table('em_investigation_report_details')
            ->where('investigator_report_id', '=', $investigation_single_report->id)
            ->get();
        // dd($evidenceinfo);
        $data['investigator_details'] = $investigator_details;
        $data['investigation_single_report'] = $investigation_single_report;
        $data['evidenceinfo'] = $evidenceinfo;
        //dd($data);
        return view('Investigation.single-investigation-details')->with($data);
    }
    public function investigation_delete(Request $request)
    {
        $origin_id = explode('_', $request->id);


        $investigation_report = DB::table('em_investigation_report')
            ->where('id', '=', end($origin_id))
            ->first();

        $investigator_details = DB::table('em_investigators')
            ->where('id', '=', $investigation_report->investigator_id)->first();

        // var_dump($investigator_details);
        // exit();

        $investigator_details_array = [
            'id' => $investigator_details->id,
            'appeal_id' => $investigator_details->appeal_id,
            'type_id' => $investigator_details->type_id,
            'nothi_id' => $investigator_details->nothi_id,
            'name' => $investigator_details->name,
            'organization' => $investigator_details->organization,
            'designation' => $investigator_details->designation,
            'mobile' => $investigator_details->mobile,
            'email' => $investigator_details->email,
        ];



        $investigation_report_array = [
            'appeal_id' => $investigation_report->appeal_id,
            'investigator_name' => $investigation_report->investigator_name,
            'investigator_organization' => $investigation_report->investigator_organization,
            'investigation_subject' => $investigation_report->investigation_subject,
            'case_no' => $investigation_report->case_no,
            'memorial_no' => $investigation_report->memorial_no,
            'investigation_comments' => $investigation_report->investigation_comments,
            'investigation_date' => $investigation_report->investigation_date,
            'investigation_attachment_delete' => json_decode($investigation_report->investigation_attachment),
            'investigation_attachment_main_delete' => json_decode($investigation_report->investigation_attachment_main),

        ];

        LogManagementRepository::investigationreportDelete($investigation_report_array, $investigator_details_array, $investigation_report->appeal_id);
        // var_dump($investigation_report_array);
        // exit();

        // dd($investigation_report->investigation_attachment);

        if (!empty($investigation_report->investigation_attachment)) {
            $investigation_attachment_others_files = json_decode($investigation_report->investigation_attachment);
            foreach ($investigation_attachment_others_files as $value) {

                $fileName = $value->file_name;

                $attachmentUrl = config('app.attachmentUrl');
                $filePath = $attachmentUrl . $value->file_path;

                unlink($filePath . $fileName);
            }
        }

        if (!empty($investigation_report->investigation_attachment_main)) {
            $investigation_attachment_main_files = json_decode($investigation_report->investigation_attachment_main);
            foreach ($investigation_attachment_main_files as $value) {
                $fileName = $value->file_name;

                $attachmentUrl = config('app.attachmentUrl');
                $filePath = $attachmentUrl . $value->file_path;

                unlink($filePath . $fileName);
            }
        }

        $investigation_deleted = DB::table('em_investigation_report')
            ->where('id', '=', end($origin_id))
            ->delete();







        if ($investigation_deleted) {
            return response()->json([
                'success' => 'success',
            ]);
        }
    }
}