<?php

namespace App\Http\Controllers\emc;


use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;

class EmcReportController extends Controller
{
    use TokenVerificationTrait;
    public function index()
    {
        // Dropdown List

        $data['courts'] = DB::table('emc_court')->select('id', 'court_name')->get();
   
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
      
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        $data['getMonth'] = date('M', mktime(0, 0, 0));
        $data['page_title'] = 'রিপোর্ট';

        if (globalUserInfo()->role_id == 34) {
            $data['user_division_name'] = user_office_info()->division_name_bn;
            $data['user_division_id'] = user_office_info()->division_id;
        }
        
        return view('emc_court.report.index')->with($data);
    }

    public function pdf_generate(Request $request)
    {
        $role=Auth::user()->role_id;

        if ($role !=34) {
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

            if ($request->btnsubmit == 'pdf_crpc_district') {
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
        
        if ($request->btnsubmit == 'pdf_num_upazila') {
            if ($role==34) {
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

        if ($request->btnsubmit == 'pdf_crpc_upazila') {
            if ($role==34) {
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
      
     
        $div_name = user_office_info()->division_name_bn;
        $division_id = user_office_info()->division_id;

        $token = $this->verifySiModuleToken('WEB');
    
        $btn_type=$request->all();
      
        if( $token){
              $data=array(
               'division'=>isset($btn_type['division']) ?  $btn_type['division']: null,
               'district'=>isset($btn_type['district']) ?  $btn_type['district']: null,
               'date_start'=>isset($btn_type['date_start']) ?  $btn_type['date_start']: null,
               'date_end' =>isset($btn_type['date_end']) ?  $btn_type['date_end']: null,
               'btnsubmit'=> isset($btn_type['btnsubmit']) ?  $btn_type['btnsubmit']: null,
               'role'=> $role,
               'div_name'=> $div_name,
               'division_id'=> $division_id,
              );

            $datalll=json_encode($data);
              
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/emc_pdf_generate',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST =>'POST',
                CURLOPT_POSTFIELDS =>array('data' =>$datalll),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type' => 'application/json',
                    "Authorization: Bearer $token",
                ),
            ));
            $response = curl_exec($curl);
            // dd($response);
            curl_close($curl);
            $punishment= json_decode($response,true);
            // dd($punishment);
            
          
            
            if($punishment['success']==true){
                $data =$punishment['data'];
            
                if ($request->btnsubmit == 'pdf_num_division') {


                    $html = view('emc_court.report.pdf_num_division')->with($data);
                    return $this->generatePDF($html);
                }
                if ($request->btnsubmit == 'pdf_num_district') {

                    $html = view('emc_court.report.pdf_num_district')->with($data);
                    // Generate PDF
                    $this->generatePDF($html);
                }
                if ($request->btnsubmit == 'pdf_num_upazila') {
                
                $html = view('emc_court.report.pdf_num_upazila')->with($data);
                // Generate PDF
                $this->generatePDF($html);
                }
                if ($request->btnsubmit == 'pdf_crpc_division') {
                    // dd($data);
                    $html = view('emc_court.report.pdf_crpc_division')->with($data);
                    $this->generatePDF($html);
                }
                if ($request->btnsubmit == 'pdf_crpc_district') {
                    $html = view('emc_court.report.pdf_crpc_district')->with($data);
                    // dd($html);
                    // Generate PDF
                    $this->generatePDF($html);
                }
                if ($request->btnsubmit == 'pdf_crpc_upazila') {
                    $html = view('emc_court.report.pdf_crpc_upazila')->with($data);
                    // dd($html);
                    // Generate PDF
                    $this->generatePDF($html);
                }
                if ($request->btnsubmit == 'pdf_case') {
                    // dd($data);
                    $html = view('emc_court.report.pdf_case')->with($data);
                    // Generate PDF
                    $this->generatePDF($html);
                }
            }else{
                return "dlaksdfjalsd";
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

















   

   


    


    
}