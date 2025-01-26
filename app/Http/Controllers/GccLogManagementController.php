<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\TokenVerificationTrait;
class GccLogManagementController extends Controller
{
    use TokenVerificationTrait;

    public function index()
    {
        if (isset($_GET['case_no'])) {
            $datas['case_no'] = $_GET['case_no'];
        } else {
            $datas['case_no'] = null;
        }
        // dd($case_no);
        $url = getapiManagerBaseUrl() . '/api/gcc/log_index';
        $method = 'POST';
        $bodyData = $datas;

        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd($res);
            // dd('ecourt module gccc, ' , $res);
            if ($res->success) {
                // dd($res);
                $cases = $res->data;
                $page_title = 'জেনারেল সার্টিফিকেট আদালতে মামলা কার্যকলাপ নিরীক্ষা';
                return view('logManagement.gcc.index', compact(['cases', 'page_title']));
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
        $url = getapiManagerBaseUrl() . '/api/gcc/log_index_single/' . $id;
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
                return view('logManagement.gcc.log', compact('data'));
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        } else {
            return redirect()->back()->with('Internal Server Error');
        }
    }
    public function log_details_single_by_id($id)
    {
        $url = getapiManagerBaseUrl() . '/api/gcc/log/logid/'.$id;
        $user = globalUserInfo();
        $data['id'] = decrypt($id);
        $method = 'POST';
        $bodyData = $data;

        $token = $this->verifySiModuleToken('WEB');

        $data = json_encode($bodyData);
        if ($token) {
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            if ($res->success) {
                // dd($res);
                $data = $res->data;
                $page_title = 'gcc- মামলা কার্যকলাপ নিরীক্ষা';

                return view('logManagement.gcc.log_details_single_by_id', compact('data', 'page_title'));
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
        $url = getapiManagerBaseUrl() . '/api/gcc/create_log_pdf/' . $id;
        $method = 'POST';
        $bodyData = $data;
        $token = $this->verifySiModuleToken('WEB');
        $page_title = 'Gcc-মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য';
        $data = json_encode($bodyData);
        if ($token) {
            // return 'come toikenj';
            $res = makeCurlRequestWithToken($url, $method, $data, $token);
            // dd('ecourt module pdf gcc ..', $res);
            if ($res->success) {
                $data = $res->data;
                $html = view('report.gcc_pdf_log_management', compact('data', 'page_title'));
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
}