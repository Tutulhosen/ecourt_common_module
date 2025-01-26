<?php

namespace App\Http\Controllers\gcc;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;

class ReportController extends Controller
{
    use TokenVerificationTrait;
    //report module
    public function index()
    {

        // dd(user_office_info()); 
        $data['courts'] = DB::table('gcc_court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('gcc_role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0, 0, 0));

        $data['page_title'] = 'রিপোর্ট'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        if (globalUserInfo()->role_id == 34) {
            $data['user_division_name'] = user_office_info()->division_name_bn;
            $data['user_division_id'] = user_office_info()->division_id;
        }
        return view('report.index')->with($data);
    }


    public function gcc_pdf_generate(Request $request)
    {
        $role = Auth::user()->role_id;

        if ($role != 34) {
            if ($request->btnsubmit == 'pdf_payment_district') {

                $request->validate(
                    [
                        'division' => 'required',
                    ],
                    [
                        'division.required' => 'বিভাগ নির্বাচন করুন',
                    ]
                );
            }

            if ($request->btnsubmit == 'pdf_num_district') {


                $request->validate(
                    [
                        'division' => 'required',
                    ],
                    [
                        'division.required' => 'বিভাগ নির্বাচন করুন',
                    ]
                );
            }
        }


        if ($request->btnsubmit == 'pdf_payment_upazila') {

            if ($role == 34) {
                $request->validate(
                    [
                        'district' => 'required',
                    ],
                    [
                        'district.required' => 'জেলা নির্বাচন করুন',
                    ]
                );
            } else {
                $request->validate(
                    [
                        'division' => 'required',
                        'district' => 'required',
                    ],
                    [
                        'division.required' => 'বিভাগ নির্বাচন করুন',
                        'district.required' => 'জেলা নির্বাচন করুন',
                    ]
                );
            }
        }

        if ($request->btnsubmit == 'pdf_num_upazila') {


            if ($role == 34) {
                $request->validate(
                    [
                        'district' => 'required',
                    ],
                    [
                        'district.required' => 'জেলা নির্বাচন করুন',
                    ]
                );
            } else {
                $request->validate(
                    [
                        'division' => 'required',
                        'district' => 'required',
                    ],
                    [
                        'division.required' => 'বিভাগ নির্বাচন করুন',
                        'district.required' => 'জেলা নির্বাচন করুন',
                    ]
                );
            }
        }


        if ($request->btnsubmit == 'pdf_case') {

            $request->validate(
                ['date_start' => 'required', 'date_end' => 'required'],
                ['date_start.required' => 'মামলা শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => 'মামলা শেষের তারিখ নির্বাচন করুন']
            );
        }




        $data['role'] = $role;
        $data['div_name'] = user_office_info()->division_name_bn;
        $data['division_id'] = user_office_info()->division_id;
        $data['dateFrom'] = isset($request->date_start) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start))) : null;
        $data['dateTo'] = isset($request->date_end) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end))) : null;
        $data['division'] = isset($request->division) ?  $request->division : null;
        $data['district'] = isset($request->district) ?  $request->district : null;
        $data['btn_type'] = $request->btnsubmit;

        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($data, true);

            $url = getapiManagerBaseUrl() . '/api/v1/gcc/report/pdf';
            $method = 'POST';
            $bodyData = $jsonData;
            $token = $token;
            $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

            // dd($response);   
            $res = json_decode($response, true);

            if ($res['success']) {
                $data = $res['data'];

                if ($request->btnsubmit == 'pdf_payment_division') {


                    $html = view('report.pdf_payment_by_division')->with($data);

                    $this->generatePamentPDF($html);
                }

                if ($request->btnsubmit == 'pdf_payment_district') {

                    $html = view('report.pdf_payment_by_district')->with($data);

                    $this->generatePamentPDF($html);
                }

                if ($request->btnsubmit == 'pdf_payment_upazila') {


                    $html = view('report.pdf_payment_by_upazila')->with($data);

                    $this->generatePamentPDF($html);
                }





                if ($request->btnsubmit == 'pdf_num_division') {


                    $html = view('report.pdf_num_division')->with($data);

                    $this->generatePDF($html);
                }



                if ($request->btnsubmit == 'pdf_num_district') {


                    $html = view('report.pdf_num_district')->with($data);

                    $this->generatePDF($html);
                }
                if ($request->btnsubmit == 'pdf_num_upazila') {


                    $html = view('report.pdf_num_upazila')->with($data);

                    $this->generatePDF($html);
                }

                if ($request->btnsubmit == 'pdf_case') {

                    if (Auth::user()->role_id == 34) {
                        $html = view('report.pdf_case_dis')->with($data);
                    } else {
                        $html = view('report.pdf_case_div')->with($data);
                    }


                    $this->generatePDF($html);
                }
            } else {
                return redirect()->back()->with('তথ্য পাওয়া যায়নি');
            }
        }
    }



    public function generatePDF($html)
    {
        $mpdf = new Mpdf([
            'format' => 'A4-L',
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
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
