<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TokenVerificationTrait;

class GccRegisterController extends Controller
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

        $url = getapiManagerBaseUrl() . '/api/gcc/register/list';
        $method = 'POST';
        $bodyData = $data;
        $token = $this->verifySiModuleToken('WEB');
        // dd($token);
        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd('register common module.. gcc', $res);
            if ($res->success) {
                // dd($res);  
                $results = $res->data;
                // dd($data) ;   
                $page_title  = 'জেনারেল সার্টিফিকেট আদালত রেজিস্টার ';
                return view('register.gcc.index', compact('results', 'page_title'));
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
        $caseStatus = 1;

        $url = getapiManagerBaseUrl() . '/api/gcc/printPdf';
        $method = 'POST';
        $bodyData = $data;
        $token = $this->verifySiModuleToken('WEB');
        // dd($token);
        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd('register common module.. gcc for pdf', $res);
            if ($res->success) {
                $date = date($request->date);
                // dd($res);  
                $results = $res->data;
                // dd($data) ;   
                $page_title  = 'gcc- রেজিস্টার ';
                // return view('register.gcc.index', compact('results', 'page_title'));
                $html = view('register.gcc.pdf_register', compact('date', 'caseStatus', 'page_title', 'req', 'results'));


                $this->generatePDF($html);
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