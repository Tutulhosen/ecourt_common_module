<?php

namespace App\Http\Controllers;

use App\Traits\TokenVerificationTrait;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;

class EmcLogManagementController extends Controller
{
    use TokenVerificationTrait;

    public function index()
    {

        if (isset($_GET['case_no'])) {
            $datas['case_no'] = $_GET['case_no'];
        } else {
            $datas['case_no'] = null;
        }
        $url = getapiManagerBaseUrl() . '/api/emc/log_index';
        $method = 'POST';
        $bodyData = $datas;

        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd($res);
            if ($res->success) {
                $cases = $res->data;
                $page_title = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে মামলা কার্যকলাপ নিরীক্ষা';

                return view('logManagement.emc.index', compact(['cases', 'page_title']));
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }
    }

    public function log_index_single(Request $request, $id = '')
    {
        $data = [];
        $user = globalUserInfo();
        $data['id'] = decrypt($id);
        $data['user'] = $user;
        $data['office_id'] = $user->office_id;
        $data['roleID'] = $user->role_id;
        $data['officeInfo'] = user_office_info();
        $url = getapiManagerBaseUrl() . '/api/emc/log_index_single/' . $id;
        $method = 'POST';
        $bodyData = $data;
        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd($res);
            if ($res->success) {
                // dd($res);
                $data = $res->data;
                // dd($data);   
                return view('logManagement.emc.log', compact('data'));
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }
    }
    public function create_log_pdf(Request $request, $id = '')
    {

        $data = [];
        $user = globalUserInfo();
        // $data['id'] = decrypt($id);
        $data['user'] = $user;
        $data['office_id'] = $user->office_id;
        $data['roleID'] = $user->role_id;
        $data['officeInfo'] = user_office_info();
        $url = getapiManagerBaseUrl() . '/api/emc/create_log_pdf/' . $id;
        $method = 'POST';
        $bodyData = $data;
        $token = $this->verifySiModuleToken('WEB');
        $page_title = 'মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য';
        $data = json_encode($bodyData);
        if ($token) {
            // return 'come toikenj';
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd('ecourt module pdf ..', $res->data);
            if ($res->success) {
                $data = $res->data;
                $html = view('report.em_pdf_log_management', compact('data', 'page_title'));
                $this->generatePamentPDF($html);
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }
    }
    public function generatePamentPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function log_details_single_by_id($id)
    {

        $url = getapiManagerBaseUrl() . '/api/emc/log/logid/details/' . $id;
        $method = 'POST';


        $token = $this->verifySiModuleToken('WEB');

        $data = null;
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
          
            if ($res->success) {
                // dd($res);
                $data = $res->data;
                $page_title = 'emc- মামলার বিস্তারিত তথ্য';

                return view('logManagement.emc.log_details_single_by_id', compact(['data', 'page_title']));
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }
    }
}