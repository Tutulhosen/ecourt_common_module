<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\TokenVerificationTrait;
class PaymentController extends Controller
{
    //
    use TokenVerificationTrait;

  
    public function payment_process(Request $request){


        $courtFee= $request->courtFee;
        $transaction_old= $request->transaction_no;
 
        $request->session()->forget('key');
     
        $transaction_no = uniqid();
        $value=array(
           'interestRate' =>$request->interestRate,
           'totalLoanAmount' => $request->totalLoanAmount,
           'totalLoanAmountText' => $request->totalLoanAmountText,
           'payment_court_id' => $request->court_id
        );
 
        Session::put('key', $value);

        // $request->totalLoanAmount;

        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        // $reqst_id =rand(1,100);// $request->id;
        
   
        if (empty($transaction_old)) { 
        $token = $this->ekPay($courtFee,$transaction_no,$request->payment_type,$request->court_id);
      
        if (!empty($token)) {
        //  return $token;
            $redirect = $paymentUrl . "v1?sToken=$token&trnsID=$transaction_no";
            // dd($redirect);
           return  response()->json($redirect);
        } else {
            // return redirect()->route('citizen.review.case.create')->with('danger', 'আবেদনের তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে কিন্তু আপনার পেমেন্টও সম্পন্ন হয়নি।');
        }
       }
    }
    
    public function ekPay($request,$transaction_no,$payment_type,$court_id){
      

        $user = globalUserInfo();
        if ($user->citizen_type_id==2) {
            $office_id = $user->office_id;
            $roleID = $user->role_id;
            $officeInfo = user_office_info();
            $citizen_info=DB::table('ecourt_citizens')->where('id','=',$user->citizen_id)->first();
            $payment_id = Str::uuid();
            // dd($payment_id);
            $amount = 20;
            $data = [
                'districtId' => $officeInfo->district_id,
                'divisionId' => $officeInfo->division_id,
                'office_id' => $office_id,
                'organization_employee_id'=>Auth::user()->organization_employee_id,
                'citizen_id'=>$user->citizen_id,
                'trnx_id'=>$transaction_no,
                'payment_type'=>$payment_type,
                'court_id'=>$court_id,
                'status'=>0, // status 0=unpaid, 1=paid
                'court_fee'=>$amount,
                'payment_id'=>$payment_id
            ];
        }
        if ($user->citizen_type_id==1) {
            $office_id = $user->office_id;
            $roleID = $user->role_id;
            $officeInfo = user_office_info();
            $citizen_info=DB::table('ecourt_citizens')->where('id','=',$user->citizen_id)->first();
            $payment_id = Str::uuid();
            // dd($payment_id);
            $amount = 20;
            $data = [
               
                'citizen_id'=>$user->citizen_id,
                'trnx_id'=>$transaction_no,
                'payment_type'=>$payment_type,
                'court_id'=>$court_id,
                'status'=>0, // status 0=unpaid, 1=paid
                'court_fee'=>$amount,
                'payment_id'=>$payment_id
            ];
        }
        
        
        DB::table('payment_history')->insert($data);
     
        $date = date('Y-m-d H:i:s');
        $BackUrl = url('');
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $userName = 'bbs_test';
        $password = 'BbstaT@tsT12';
        $mac_addr = '1.1.1.1';

        $responseUrlSuccess = $BackUrl . '/payment-success';
        $ipnUrlTrxinfo = $BackUrl . '/response-ekpay-ipn-tax';
        $responseUrlCancel = $BackUrl . '/payment-cancel';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $paymentUrl . 'v1/merchant-api',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "mer_info":
            {
                "mer_reg_id":"' . $userName . '",
                "mer_pas_key":"' . $password . '"
            },
            "req_timestamp":"' . $date . ' GMT+6",
            "feed_uri":
                {
                    "s_uri":"' . $responseUrlSuccess . '",
                    "f_uri":"' . $responseUrlCancel . '",
                    "c_uri":"' . $responseUrlCancel . '"
                },
                "cust_info":
                {
                    "cust_id":"' . $request . '",
                    "cust_name":"' .$user->name. '",
                    "cust_mobo_no":"+88' .$user->mobile_no. '",
                    "cust_mail_addr":"' .$officeInfo->organization_physical_address. '"

                },
                "trns_info":
                {
                    "trnx_id":"' .$transaction_no. '",
                    "trnx_amt":"' . $amount . '",
                    "trnx_currency":"BDT",
                    "ord_id":"' . $transaction_no . '",
                    "ord_det":"Court Fee"

                },
                "ipn_info":
                {
                    "ipn_channel":"3",
                    "ipn_email":"mafizur.mysoftheaven@gmail.com",
                    "ipn_uri":"' . $ipnUrlTrxinfo . '"

                },
                "mac_addr":"' . $mac_addr . '"

        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

       $info = json_decode($response);


       return $info->secure_token;
    }

    public function ekPaySuccess(Request $request){
        // return $request->all();
        $id = $request->transId;
        $date = date('Y-m-d');
        $userName = 'bbs-test';
        $password = 'BbstaT@tsT12';
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sandbox.ekpay.gov.bd/ekpaypg/v1/get-status',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "username":"' . $userName . '",
            "trnx_id": "' . $id . '",
            "trans_date": "' . $date . '"
        }',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
         $res=json_decode($response);

        
        // dd($res->trnx_info);
        //  $token=$res->secure_token;
       

        if($res->msg_code==1020){
            // User Name : ecourt_challan_test
            // Password : iB7$^oz$
            
        //     $curl = curl_init();
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt_array($curl, array(
        //       CURLOPT_URL => 'https://sandbox.ekpay.gov.bd/echallan/api/authenticate',
        //       CURLOPT_RETURNTRANSFER => true,
        //       CURLOPT_ENCODING => '',
        //       CURLOPT_MAXREDIRS => 10,
        //       CURLOPT_TIMEOUT => 0,
        //       CURLOPT_FOLLOWLOCATION => true,
        //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //       CURLOPT_CUSTOMREQUEST => 'POST',
        //       CURLOPT_POSTFIELDS =>'{
        //         "username": "ecourt_challan_test",
        //         "key": "iB7$^oz$"
        //         }',
        //       CURLOPT_HTTPHEADER => array(
        //         'Accept: application/json',
        //         'Content-Type: application/json',
        //         //  "Authorization: Bearer $token",
        //       ),
        //     ));
    
        //     $response2 = curl_exec($curl);
        //     curl_close($curl);
        //     $dddd=json_decode($response2);
        //     //  dd( $dddd);
        //     $trnx_id= $res->trnx_info->trnx_id;
        //     $mer_trnx_id= $res->trnx_info->mer_trnx_id;
        //     $pi_trnx_id= $res->trnx_info->pi_trnx_id;
        //     // dd($trnx_id= $res->trnx_info);
        //      $curl = curl_init();
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //     curl_setopt_array($curl, array(
        //       CURLOPT_URL => 'https://sandbox.ekpay.gov.bd/echallan/api/challan/create',
        //       CURLOPT_RETURNTRANSFER => true,
        //       CURLOPT_ENCODING => '',
        //       CURLOPT_MAXREDIRS => 10,
        //       CURLOPT_TIMEOUT => 0,
        //       CURLOPT_FOLLOWLOCATION => true,
        //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //       CURLOPT_CUSTOMREQUEST => 'POST',
        //       CURLOPT_POSTFIELDS =>'{
        //       "REQUEST_ID":"'.$pi_trnx_id.'",
        //       "REF_NO " : "'.$mer_trnx_id.'",
        //       "TRAN_DATE":"2024-09-02",
        //       "APPLICANT_NAME" : "Md. Hasan Monsur",
        //       "REFERENCE_NAME" : "Md. AHSAN Monsur",
        //       "MOBILE_NO" : "01817822832",
        //       "ADDRESS" : "Motijheel, Dhaka",
        //       "PURPOSE" : "EPASSPORT",
        //       "TRANAMOUNT" : "20",
        //       "PAY_TRXID":"'.$trnx_id.'",
        //       "CREDIT_INFO": [
        //                 {
        //                 "SLNO":1,
        //                 "CREDIT_ACCOUNT" : "1-1001-2012-1123",
        //                 "AMOUNT" : "10"
        //                 },
        //                 {
        //                 "SLNO":2,
        //                 "CREDIT_ACCOUNT" : "1-1001-2012-1212",
        //                 "AMOUNT" : "10"
        //                 }
        //         ]
        //       }',
        //       CURLOPT_HTTPHEADER => array(
        //         'Accept: application/json',
        //         'Content-Type: application/json',
        //          "Authorization: $dddd->jwt_token",
        //       ),
        //     ));
    
        //     $response21 = curl_exec($curl);
        //     curl_close($curl);
        //     $challan=json_decode($response21);

        //    dd($challan);

// $curl = curl_init();
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://sandbox.ekpay.gov.bd/echallan/api/challan/create',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS =>'{
//     "REQUEST_ID":"3467630666",
//     "TRAN_DATE":"2024-09-02"
//   }',
//   CURLOPT_HTTPHEADER => array(
//     'Accept: application/json',
//     'Content-Type: application/json',
//   ),
// ));

// $response213 = curl_exec($curl);
// curl_close($curl);
// $challansearch=json_decode($response213);

// dd($challansearch);
            $user = globalUserInfo();
        
            $data['info'] = DB::table('payment_history')->where('trnx_id',$id)->first();
            $transaction_no=$data['info']->trnx_id;
            $payment_id=$data['info']->payment_id;
            $court_fee=$data['info']->court_fee;
            // dd($data);
            DB::table('payment_history')
            ->where('trnx_id',$id)
            ->update(['status' =>1]);
            
            if($data['info']->payment_type==1){
                $user = globalUserInfo();
                $office_id = $user->office_id;
                $roleID = $user->role_id;
                $officeInfo = user_office_info();
                $available_court = DB::table('gcc_court')->where('upazila_id',$officeInfo->upazila_id)->orWhere('level',1)->where('district_id',$officeInfo->district_id)->orderBy('id','desc')->get();


                $citizen_info=DB::table('ecourt_citizens')->where('id','=',$user->citizen_id)->first();

            //dd($officeInfo->organization_routing_id);
                switch($officeInfo->organization_type)
                {
                    case "BANK":
                    $organization_type_bn_name='ব্যাংক';
                    break;
                    case "GOVERNMENT":
                    $organization_type_bn_name='সরকারি প্রতিষ্ঠান';
                    break;
                    case "OTHER_COMPANY":
                    $organization_type_bn_name='স্বায়ত্তশাসিত প্রতিষ্ঠান';
                    break;   
                }      
                $appealId = null;
                $data = [
                    'districtId' => $officeInfo->district_id,
                    'divisionId' => $officeInfo->division_id,
                    'office_id' => $office_id,
                    'appealId' => $appealId,
                    'organization_routing_id'=>$officeInfo->organization_routing_id,
                    'organization_physical_address'=>$officeInfo->organization_physical_address,
                    'organization_type'=>$officeInfo->organization_type,
                    'organization_type_bn_name'=>$organization_type_bn_name,
                    'available_court' => $available_court,
                    'office_name' => $officeInfo->office_name_bn,
                    'citizen_gender'=>$citizen_info->citizen_gender,
                    'father'=>$citizen_info->father,
                    'mother'=>$citizen_info->mother,
                    'present_address'=>$citizen_info->present_address,
                    'organization_employee_id'=>Auth::user()->organization_employee_id,
                    'transaction_no'=>$transaction_no,
                    'payment_id'=>$payment_id,
                    'court_fee'=>$court_fee
                ];
                $page_title = 'সার্টিফিকেট রিকুইজিশন নিবন্ধন';
                return redirect()->route('citizen.appeal.create', ['data' => $data, 'page_title' => $page_title])
                    ->with('success', 'আবেদনের তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে এবং আপনার পেমেন্টও সম্পন্ন হয়েছে। আপনার আবেদনের কোর্ট ফি নম্বর : '.$transaction_no);

            }elseif($data['info']->payment_type==2){
                $token = $this->verifySiModuleToken('WEB');
            
                if ($token) {  
                    $data['paymentstatus']=1;
                    $data['appeal_id']=$data['info']->appeal_id;
                
                    $alljson=json_encode($data);
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => getapiManagerBaseUrl() . '/api/v1/paymentStatusUpdate',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>array(
                        'paymentinfo' =>$alljson
                        ),
                        CURLOPT_HTTPHEADER => array(
                            'Accept: application/json',
                            "secrate_key:common-court",
                            "Authorization: Bearer $token",

                        ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    $res = json_decode($response);
                    // dd($res);
                    return redirect('dashboard');
                }
            }
        }else{
            return 'system error ';
        }



    }
    public function ekPayCancel(Request $request){
        return 'cancel';
        $id = $request->transId;
        $data['info'] = RM_CaseReviewRequisitionCourtFeeDetails::where('id',$id)->first();
        $transNo = $data['info']->transaction_no;
        $mobile =  '88' . bn2en($data['info']->citizen_mobile);
        // dd($mobile);
        $msg = 'আবেদনের তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে কিন্তু আপনার পেমেন্টও সম্পন্ন হয়নি।';
        $data['smsId'] = $this->send_sms_new($mobile, $msg);

        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        return redirect()->route('citizen.review.case.create')
        ->with('danger', 'আবেদনের তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে কিন্তু আপনার পেমেন্টও সম্পন্ন হয়নি।');
    }

    public function paynotice(Request $request){

        // dd($request->payment_notice);
        $data['payment_notice']=$request->payment_notice;
        return view('dashboard.paymentNoticeList')->with($data);
    }


    public function makepaymentmodal(Request $request){
        $data=array(
            'id'=>$request->id,
            'interestRate'=>$request->interestRate,
            'loan_amount'=>$request->loan_amount
        );
        return view('dashboard.makepaymentmodal',$data);
    }
    public function process_fee(Request $request){
       
        $totalamount=$request->loan_amount;
        $interestRate=$request->interestRate;
        $appeal_id=$request->appeal_id;

        $totalcost=($totalamount*2.5)/100;
        $totalInterestRate=($totalamount*$interestRate)/100;

        $totalpayment=($totalcost+$totalInterestRate);
        $transaction_no = uniqid();
        $token = $this->process_ekPay($totalpayment,$transaction_no,$request->payment_type,$request->court_id,$appeal_id);
     
       
        if (!empty($token)) {
            $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
            $redirect = $paymentUrl . "v1?sToken=$token&trnsID=$transaction_no";
            return  redirect($redirect);
        } else {
            return redirect()->route('citizen.review.case.create')->with('danger', 'আবেদনের তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে কিন্তু আপনার পেমেন্টও সম্পন্ন হয়নি।');
        }
        
    }


    public function process_ekPay($totalpayment,$transaction_no,$payment_type,$court_id,$appeal_id){
        $user = globalUserInfo();
       
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();
        $citizen_info=DB::table('ecourt_citizens')->where('id','=',$user->citizen_id)->first();


        $discourt_court=DB::table('gcc_court')->where('district_id','=',$officeInfo->district_id)->first();
        $upzila_court=DB::table('gcc_court')->where('upazila_id','=',$officeInfo->district_id)->first();
        if(empty( $upzila_court->upazila_id )){
            $court_id=$upzila_court->id;
        }else{
            $court_id=$discourt_court->id;
        }
        $payment_id = Str::uuid();
        // dd($payment_id);
        $amount = $totalpayment;
        $data = [
            'districtId' => $officeInfo->district_id,
            'divisionId' => $officeInfo->division_id,
            'office_id' => $office_id,
            'organization_employee_id'=>Auth::user()->organization_employee_id,
            'citizen_id'=>$user->citizen_id,
            'trnx_id'=>$transaction_no,
            'payment_type'=>$payment_type,
            'court_id'=>$court_id,
            'appeal_id'=>$appeal_id,
            'status'=>0, // status 0=unpaid, 1=paid
            'court_fee'=>$amount,
            'payment_id'=>$payment_id
        ];
        
        DB::table('payment_history')->insert($data);
     
        $date = date('Y-m-d H:i:s');
        $BackUrl = url('');
        $paymentUrl = 'https://sandbox.ekpay.gov.bd/ekpaypg/';
        $userName = 'bbs_test';
        $password = 'BbstaT@tsT12';
        $mac_addr = '1.1.1.1';

        $responseUrlSuccess = $BackUrl . '/payment-success';
        $ipnUrlTrxinfo = $BackUrl . '/response-ekpay-ipn-tax';
        $responseUrlCancel = $BackUrl . '/payment-cancel';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $paymentUrl . 'v1/merchant-api',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "mer_info":
            {
                "mer_reg_id":"' . $userName . '",
                "mer_pas_key":"' . $password . '"
            },
            "req_timestamp":"' . $date . ' GMT+6",
            "feed_uri":
                {
                    "s_uri":"' . $responseUrlSuccess . '",
                    "f_uri":"' . $responseUrlCancel . '",
                    "c_uri":"' . $responseUrlCancel . '"
                },
                "cust_info":
                {
                    "cust_id":"' . '456456456'. '",
                    "cust_name":"' .$user->name. '",
                    "cust_mobo_no":"+88' .$user->mobile_no. '",
                    "cust_mail_addr":"' .$officeInfo->organization_physical_address. '"

                },
                "trns_info":
                {
                    "trnx_id":"' .$transaction_no. '",
                    "trnx_amt":"' . $amount . '",
                    "trnx_currency":"BDT",
                    "ord_id":"' . $transaction_no . '",
                    "ord_det":"Court Fee"

                },
                "ipn_info":
                {
                    "ipn_channel":"3",
                    "ipn_email":"mafizur.mysoftheaven@gmail.com",
                    "ipn_uri":"' . $ipnUrlTrxinfo . '"

                },
                "mac_addr":"' . $mac_addr . '"

        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

       $info = json_decode($response);


       return $info->secure_token;
    }
}


