<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TokenVerificationTrait;

class EmcRegisterController extends Controller
{
    use TokenVerificationTrait;

    public function index(Request $request)
    {
        $data = [];
        $user = globalUserInfo();
        $data['user'] = $user;
        $data['office_id'] = $user->office_id;
        $data['roleID'] = $user->role_id;
        $data['officeInfo'] = user_office_info();
        if (!empty($_GET['date_start'])  && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $data['dateFrom'] = $dateFrom;
            $data['dateTo'] = $dateTo;
        }
        if (!empty($_GET['case_no'])) {
            $case_no = $_GET['case_no'];
            $data['case_no'] = $case_no;
        }
        if (!empty($_GET['caseStatus'])) {
            $caseStatus = $_GET['caseStatus'];
            $data['caseStatus'] = $caseStatus;
        }

        $url = getapiManagerBaseUrl() . '/api/emc/register/list';
        $method = 'POST';
        $bodyData = $data;
        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd('register common module..', $res);
            if ($res->success) {
                // dd($res);  
                $data = $res->data;
                // dd($data) ;   
                $page_title  = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট রেজিস্টার ';
                return view('register.emc.index', compact('data', 'page_title'));
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }
    }
    public function registerPrint(Request $request)
    {
        $data = [];
        $req = $request->all();
        $user = globalUserInfo();
        $data['user'] = $user;
        $data['office_id'] = $user->office_id;
        $data['roleID'] = $user->role_id;
        $data['officeInfo'] = user_office_info();
        if (!empty($_GET['date_start'])  && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $data['dateFrom'] = $dateFrom;
            $data['dateTo'] = $dateTo;
        }
        if (!empty($_GET['case_no'])) {
            $case_no = $_GET['case_no'];
            $data['case_no'] = $case_no;
        }
        if (!empty($_GET['caseStatus'])) {
            $caseStatus = $_GET['caseStatus'];
            $data['caseStatus'] = $caseStatus;
        }

        $url = getapiManagerBaseUrl() . '/api/emc/printPdf';
        $method = 'POST';
        $bodyData = $data;
        $token = $this->verifySiModuleToken('WEB');
        $caseStatus = 1;

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd('register common module for pdf..', $res);
            if ($res->success) {
                // dd($res);  
                $date = date($request->date);

                $results = $res->data;
                // dd($data) ;   
                $page_title  = 'emc -রেজিস্টার ';
                $html = view('register.gcc.pdf_register', compact('date', 'caseStatus', 'page_title', 'req', 'results'));


                $this->generatePDF($html);
                // return view('register.emc.index', compact('data', 'page_title'));
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }
    }
    public function generatePDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L',
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}