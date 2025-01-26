<?php

namespace App\Http\Controllers\citizen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Arr;

class GccCitizenAppealListController extends Controller
{
    use TokenVerificationTrait;
    //gcc org rep 
    public function all_case()
    {
        // dd('hi');
        $res = $this->fecthDashboradData();
        // dd($res);
        $all_appeals = $res->total_case_count_applicant->all_appeals;
        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd(/* $ct_info->citizen_name */ $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'সকল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function running_case()
    {


        $res = $this->fecthDashboradData();
        // if (!empty($res)) {
        $all_appeals = $res->total_running_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'চলমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function pending_case()
    {


        $res = $this->fecthDashboradData();
        // if (!empty($res)) {
        $all_appeals = $res->total_pending_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'অপেক্ষমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function complete_case()
    {


        $res = $this->fecthDashboradData();
        // if (!empty($res)) {
        $all_appeals = $res->total_completed_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'নিস্পত্তি মামলার তালিকা';

        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }

    //gcc citizen
    public function all_case_gcc_citizen()
    {
        // dd('hi');
        $res = $this->fecthDashboradData_gcc_citizen();
       
        $all_appeals = $res->total_case_count_gcc_citizen->all_appeals;
        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd(/* $ct_info->citizen_name */ $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        $page_title = 'সকল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }
    public function running_case_gcc_citizen()
    {


        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->total_running_case_count_gcc_citizen->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        $page_title = 'চলমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }
    public function pending_case_gcc_citizen()
    {


        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->total_pending_case_count_gcc_citizen->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        $page_title = 'অপেক্ষমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }
    public function complete_case_gcc_citizen()
    {

        // dd(globalUserInfo());
        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->total_completed_case_count_gcc_citizen->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
           $payment= DB::table('certify_copy')->where('appeal_id', $single_appeal->id)->select('status')->first();
           if ($payment) {
            $single_appeal->appeal_payment_status = $payment->status;
        }

        }
        // dd($all_appeals);

        $results = $all_appeals;
        // dd($results);
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'নিস্পত্তি মামলার তালিকা';
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }

    public function case_for_all_case_gcc_citizen()
    {
        // dd('hi');
        $res = $this->fecthDashboradData_gcc_citizen();
       
        $all_appeals = $res->total_appeal_case_count_gcc_citizen->all_appeals;
        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd(/* $ct_info->citizen_name */ $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        $page_title = 'সকল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }
    public function case_for_running_case_gcc_citizen()
    {


        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->total_running_appeal_case_count_gcc_citizen->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        $page_title = 'চলমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }
    public function case_for_pending_case_gcc_citizen()
    {


        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->total_pending_appeal_case_count_gcc_citizen->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        $page_title = 'অপেক্ষমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }
    public function case_for_complete_case_gcc_citizen()
    {


        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->total_completed_appeal_case_count_gcc_citizen->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
           $payment= DB::table('certify_copy')->where('appeal_id', $single_appeal->id)->select('status')->first();
           if ($payment) {
            $single_appeal->appeal_payment_status = $payment->status;
        }

        }
        // dd($all_appeals);

        $results = $all_appeals;
        // dd($results);
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'নিস্পত্তি মামলার তালিকা';
        $court_type=$res->total_case_count_gcc_citizen->court_type;
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type'));
    }

    public function certify_copy_fee_case()
    {

        // dd('f');
        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->certify_copy_fee_count_gcc_citizen->all_appeals;
        
        $results=[];
        foreach ($all_appeals as $single_appeal) {
            $lists=DB::table('certify_copy')->where('appeal_id', $single_appeal->id)->first();
            array_push($results, $lists);
        }
        
     
        $data['list']=$results;
        $data['page_title']='সার্টিফিকেট কপির আবেদন লিস্ট';
        
        return view('gcc_citizenAppealList.certiry_copy_list')->with($data);
    }

    public function for_hearing()
    {


        $res = $this->fecthDashboradData_gcc_citizen();
        // if (!empty($res)) {
        $all_appeals = $res->hearing_count_gcc_citizen->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
           $payment= DB::table('certify_copy')->where('appeal_id', $single_appeal->id)->select('status')->first();
           if ($payment) {
            $single_appeal->appeal_payment_status = $payment->status;
        }

        }
        // dd($all_appeals);

        $results = $all_appeals;
        // dd($results);
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'শুনানি';
        $court_type=$res->certify_copy_fee_count_gcc_citizen->court_type;
        $certify_copy_fee_count_gcc_citizen = $res->certify_copy_fee_count_gcc_citizen->total_count;
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title', 'court_type', 'certify_copy_fee_count_gcc_citizen'));
    }

    public function certify_copy_cancel()
    {


        $res = $this->fecthDashboradData_gcc_citizen();
   
        $all_appeals = $res->cancel_certify_copy->all_appeals;
        $results=[];
        foreach ($all_appeals as $single_appeal) {
            $lists=DB::table('certify_copy')->where('appeal_id', $single_appeal->id)->first();
            array_push($results, $lists);
        }
        
     
        $data['list']=$results;
        $data['page_title']='সার্টিফিকেট কপির আবেদন লিস্ট';
        
        return view('gcc_citizenAppealList.certiry_copy_list')->with($data);
    }

    //certificate copy process

    public function court_fee_page($id, $court_id){
        $Id = decrypt($id);
        // dd(Auth::user());
        $CourtId = decrypt($court_id);
        $available_court = DB::table('gcc_court')->where('id',$CourtId)->first();
        $data['available_court']=$available_court;
        $data['appeal_id']=$Id;
        $data['court_id']=$CourtId;

        $res = $this->fecthDashboradData_gcc_citizen();
        
        $all_appeals = $res->total_completed_case_count_gcc_citizen->all_appeals;
        $selected_appeal = array_filter($all_appeals, function ($appeal) use ($Id) {
            return $appeal->id == $Id;
        });
        $selected_appeal = reset($selected_appeal);
        $data['case_no']=$selected_appeal->case_no;
        
        $payment= DB::table('certify_copy')->where('appeal_id', $Id)->select('status')->first();
        if (!empty($payment)) {
            if ($payment->status==1) {
                // dd($payment);
                return back()->with('error', 'আপনি ইতোপূর্বে সার্টিফাইড কপির জন্য আবেদন করেছেন । আপনার আবেদনটি আপেক্ষমান আছে।');
            }
        } else {
            
                return view('gcc_citizenAppealList.gccCitizenCourtFeeForAppeal')->with($data);
        }
        
        
        
    }

    public function court_fee(Request $request){
        $data['appeal_id']             =$request->appeal_id;
        $data['amount']                =$request->court_fee_amount;
        $data['court_id']              =$request->court_id;
        $data['applicent_name']        =$request->applicent_name;
        $data['applicent_nid']         =$request->nid;
        $data['applicent_phn'  ]       =$request->applicant_phn;
        $data['applicent_p_address']   =$request->p_address;
        $data['applicent_per_address'] =$request->per_address;
        $data['description']           =$request->description;
        $data['case_no' ]              =$request->case_no;
        
       $payment_id= DB::table('certify_copy')->insertGetId($data);
    
       $certify_id=date('d').$payment_id;

        if ($payment_id) {
            DB::table('certify_copy')->where('id', $payment_id)->update([
                'certify_id' =>$certify_id
            ]);
            $payment_appeal_info=DB::table('certify_copy')->where('id', $payment_id)->first();
            $data['appeal_payment_id']=$payment_id;
            $dataPayload['id'] = $payment_appeal_info->appeal_id;
            $dataPayload['status'] = $payment_appeal_info->status;
            $dataPayload['data'] = $data;
            $dataPayload['certify_id'] = $certify_id;
            $token = $this->verifySiModuleToken('WEB');
            // dd($token);
            if ($token) {
                $jsonData = json_encode($dataPayload);
                $url = getapiManagerBaseUrl() . '/api/v1/gcc/citizen/request/certificate/copy';
                $method = 'POST';
                $bodyData = $jsonData;
                $token = $token;
                $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);
                // dd(json_decode($response));
                
            }
        }
        return redirect()->route('gcc.citizen.appeal.complete_case')->with('success', 'আপনার আবেদনটি ডিসি মহাদয় বরাবর প্রেরণ করা হয়েছে ।');
  
    }

    public function certify_copy_fee_page($id, $court_id){
        $Id = decrypt($id);
        $CourtId = decrypt($court_id);
        $certify_copy=DB::table('certify_copy')->where('id', $Id)->first();
        $available_court = DB::table('gcc_court')->where('id',$CourtId)->first();
        $data['available_court']=$available_court;
        $data['appeal_id']=$certify_copy->appeal_id;
        $data['total_page']=$certify_copy->total_page;
        $data['cost_total']=$certify_copy->cost_total;
        $data['court_id']=$CourtId;
        // dd($certify_copy);
        if ($certify_copy->status==2) {
             // dd($payment);
             return back()->with('error', 'আপনি ইতোপূর্বে সার্টিফাইড কপির জন্য ফি প্রদান করেছেন । আপনার আবেদনটি আপেক্ষমান আছে।');
        } else {
                // dd($data);
                return view('gcc_citizenAppealList.gccCitizenCertifyCopyFeeForAppeal')->with($data);
        }
        
        
        
    }

    public function certify_copy_fee(Request $request){
        
       
        
       $update= DB::table('certify_copy')->where('appeal_id', $request->appeal_id)->update([
            'status' => 2,
            'certify_copy_fee' => "FEE_COMPLATE",
        ]);

        if ($update == 1 || $update == 0) {
            $payment_appeal_info=DB::table('certify_copy')->where('appeal_id', $request->appeal_id)->first();

            $dataPayload['id'] = $payment_appeal_info->appeal_id;
            $dataPayload['status'] = $payment_appeal_info->status;
            $dataPayload['certify_copy_fee'] = $payment_appeal_info->certify_copy_fee;

            $token = $this->verifySiModuleToken('WEB');
            // dd($token);
            if ($token) {
                $jsonData = json_encode($dataPayload);
                $url = getapiManagerBaseUrl() . '/api/v1/gcc/citizen/request/certificate/copy';
                $method = 'POST';
                $bodyData = $jsonData;
                $token = $token;
                $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

                // dd($response);
            }
        }
        return redirect()->route('dashboard.index')->with('success', 'আপনার সার্টিফিকেট কপির ফি প্রদান সম্পন্ন হয়েছে ।');
  
    }

    public function attached_certify_copy_page($id, $court_id){
        $Id = decrypt($id);
        $CourtId = decrypt($court_id);
        $available_court = DB::table('gcc_court')->where('id',$CourtId)->first();
        $data['available_court']=$available_court;
        $data['appeal_id']=$Id;
        $data['court_id']=$CourtId;

        return view('gcc_citizenAppealList.certify_copy_attached')->with($data);
        
    }

    public function attached_certify_copy(Request $request){
        
       
        
       $update= DB::table('certify_copy')->where('appeal_id', $request->appeal_id)->update([
            'status' => 3,
        ]);

        if ($update == 1 || $update == 0) {
            $payment_appeal_info=DB::table('certify_copy')->where('appeal_id', $request->appeal_id)->first();

            $dataPayload['id'] = $payment_appeal_info->appeal_id;
            $dataPayload['status'] = $payment_appeal_info->status;
            $dataPayload['certify_id'] = $payment_appeal_info->certify_id;

            $token = $this->verifySiModuleToken('WEB');
            // dd($token);
            if ($token) {
                $jsonData = json_encode($dataPayload);
                $url = getapiManagerBaseUrl() . '/api/v1/gcc/citizen/request/certificate/copy';
                $method = 'POST';
                $bodyData = $jsonData;
                $token = $token;
                $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

                // dd($response);
            }
        }
        return redirect()->route('gcc.citizen.appeal.complete_case')->with('success', 'আপনার সার্টিফিকেট কপি যুক্ত হয়েছে। এই মামলাটি এখন আপিলের জন্য অনুমোদিত');
  
    }

    public function certify_copy_list(){
        $data['list']=DB::table('certify_copy')->where('applicent_phn', globalUserInfo()->mobile_no)->get();
        $data['page_title']='সার্টিফিকেট কপির আবেদন লিস্ট';
        
        return view('gcc_citizenAppealList.certiry_copy_list')->with($data);
        
    }

    public function certify_applicent_form($id){

        $data['list']=DB::table('certify_copy')->where('id', $id)->first();
        $data['page_title']='সার্টিফিকেট কপির আবেদন পত্র';
        
        return view('gcc_citizenAppealList.certify_application_form')->with($data);
        
    }

    //appeal process
    public function appeal_court_fee_page($id, $court_id){
        $Id = decrypt($id);
        // dd(Auth::user());
        $CourtId = decrypt($court_id);
        $available_court = DB::table('gcc_court')->where('id',$CourtId)->first();
        $data['available_court']=$available_court;
        $data['appeal_id']=$Id;
        $data['court_id']=$CourtId;

        $res = $this->fecthDashboradData_gcc_citizen();
        
        $all_appeals = $res->total_completed_case_count_gcc_citizen->all_appeals;
        $selected_appeal = array_filter($all_appeals, function ($appeal) use ($Id) {
            return $appeal->id == $Id;
        });
        $selected_appeal = reset($selected_appeal);
        $data['case_no']=$selected_appeal->case_no;
            // dd($Id);
        $payment= DB::table('certify_copy')->where('appeal_id', $Id)->select('status')->first();
 
        if ($payment->status==4) {
    
            return back()->with('error', 'আপনি ইতোপূর্বে মামলাটি আপিলের জন্য আবেদন করেছেন । আপনার আবেদনটি আপেক্ষমান আছে।');
            
        } else {
            
                return view('gcc_citizenAppealList.appeal_court_fee')->with($data);
        }
        
        
        
    }

    public function appeal_court_fee(Request $request){
    //    dd($request);
        $update= DB::table('certify_copy')->where('appeal_id', $request->appeal_id)->update([
            'status' => 4,
        ]);

        if ($update == 1 || $update == 0) {
            $payment_appeal_info=DB::table('certify_copy')->where('appeal_id', $request->appeal_id)->first();

            $dataPayload['id'] = $payment_appeal_info->appeal_id;
            $dataPayload['status'] = $payment_appeal_info->status;

            $token = $this->verifySiModuleToken('WEB');
            // dd($token);
            if ($token) {
                $jsonData = json_encode($dataPayload);
                $url = getapiManagerBaseUrl() . '/api/v1/gcc/citizen/request/certificate/copy';
                $method = 'POST';
                $bodyData = $jsonData;
                $token = $token;
                $response = makeCurlRequestWithToken_update($url, $method, $bodyData, $token);

                // dd($response);
            }
        }
        return redirect()->route('dashboard.index')->with('success', 'আপিলের ফি প্রদান সম্পন্ন হয়েছে এবং আবেদনটি ডিসি মহাদয় বরাবর প্রেরণ করা হয়েছে।');
  
    }
    //gcc org rep for appeal
    public function all_case_appeal_case()
    {
        // dd('hi');
        $res = $this->fecthDashboradData();
        // dd($res);
        $all_appeals = $res->total_appeal_case_count_applicant->all_appeals;
        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd(/* $ct_info->citizen_name */ $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'সকল আপিল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function running_case_appeal_case()
    {


        $res = $this->fecthDashboradData();
        // if (!empty($res)) {
        $all_appeals = $res->total_running_appeal_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'চলমান আপিল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function pending_case_appeal_case()
    {


        $res = $this->fecthDashboradData();
        // if (!empty($res)) {
        $all_appeals = $res->total_pending_appeal_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'অপেক্ষমান আপিল মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }
    public function complete_case_appeal_case()
    {


        $res = $this->fecthDashboradData();
        // if (!empty($res)) {
        $all_appeals = $res->total_completed_appeal_case_count_applicant->all_appeals;

        foreach ($all_appeals as $single_appeal) {
            // array_push($appeal_id_array, $appeal_ids_from_db_single->id);
            $ct_info = DB::table('ecourt_citizens')
                // ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                ->where('ecourt_citizens.id', $single_appeal->citizen_id)
                ->select('ecourt_citizens.citizen_name')
                ->first();
            // dd($ct_info->citizen_name, $single_appeal);
            if ($ct_info) {
                $single_appeal->citizen_name = $ct_info->citizen_name;
            }
        }
        // dd($all_appeals);

        $results = $all_appeals;
        // } else {
        //     $data['total_case'] = 'server error';
        // }
        $page_title = 'নিস্পত্তি আপিল মামলার তালিকা';

        return view('gcc_citizenAppealList.appealCasewiseList', compact('results', 'page_title'));
    }



    public function CaseAppeal($id)
    {
        $data['id'] = decrypt($id);
        // dd($data);
        $data['user'] = globalUserInfo();

        // dd($user);
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($data);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/case/for/appeal';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);

            if ($result['success'] == true) {
                return redirect()->route('gcc.pp.citizen.case.for.appeal.pending_case');
            } else {
            }
        }
    }

    public function index(Request $request)
    {
        $user = globalUserInfo();

        if ($user->role_id == 35) {
            $total_case = [];
            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif ($user->role_id == 36) {
            $total_case = [];
            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = $user->role_id;
        $gcoUserName = '';

        $page_title = 'চলমান মামলার তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function all_case_old(Request $request)
    {
        $user = globalUserInfo();

        if (globalUserInfo()->role_id == 35) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif ($user->role_id == 36) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = $user->role_id;
        $gcoUserName = '';
        // return $results;
        $page_title = 'সকল মামলার তালিকা';
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function pending_list(Request $request)
    {
        $user = globalUserInfo();

        // if ($user->role_id == 35) {
        //     $total_case = [];

        //     $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
        //         ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
        //         ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
        //         ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
        //         ->whereIn('gcc_appeal_citizens.citizen_type_id', [1,2,5])
        //         ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM','SEND_TO_GCO', 'SEND_TO_ASST_GCO'])
        //         ->select('gcc_appeal_citizens.appeal_id')
        //         ->get();

        //     foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
        //         array_push($total_case, $appeal_ids_from_db_single->appeal_id);
        //     }

        //     $results = GccAppeal::WhereIn('ID', $total_case);

        //     if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
        //         $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
        //         $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
        //         $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
        //     }
        //     if (!empty($_GET['case_no'])) {
        //         $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
        //     }

        //     $results = $results->paginate(10);
        // } elseif ($user->role_id == 36) {
        //     $total_case = [];

        //     $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
        //         ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
        //         ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
        //         ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
        //         ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
        //         ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_DIV_COM', 'SEND_TO_DC', 'SEND_TO_LAB_CM'])
        //         ->select('gcc_appeal_citizens.appeal_id')
        //         ->get();

        //     foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
        //         array_push($total_case, $appeal_ids_from_db_single->appeal_id);
        //     }

        //     $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

        //     if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
        //         $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
        //         $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
        //         $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
        //     }
        //     if (!empty($_GET['case_no'])) {
        //         $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
        //     }

        //     $results = $results->paginate(10);
        // }

        // $date = date($request->date);
        // $caseStatus = 1;
        // $userRole = $user->role_id;
        // $gcoUserName = '';

        $page_title = 'গ্রহণের জন্য অপেক্ষমান রিকুইজিশনের তালিকা';
        return view('gcc_citizenAppealList.appealCasewiseList', compact('page_title'));
    }
    public function closed_list(Request $request)
    {
        $user = globalUserInfo();

        if ($user->role_id == 35) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1, 2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif ($user->role_id == 36) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = $user->role_id;
        $gcoUserName = '';
        $page_title = 'নিষ্পত্তি মামলার তালিকা';
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }


    public function fecthDashboradData()
    {
        $user = Auth::user();
        $citizen_info = DB::table('users')
            ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
            ->select('ecourt_citizens.citizen_NID', 'ecourt_citizens.organization_id')
            ->where('users.id', $user->id)
            ->where('ecourt_citizens.citizen_type_id', 2)
            ->first();

        $auth_user = [
            'citizen_nid' => $citizen_info->citizen_NID,
            'organization_id' => $citizen_info->organization_id,
            'user_id' => $user->id,
            'username' => $user->username,
        ];



        $jsonData = json_encode($auth_user);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl() . '/api/common-module-login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'jss' => $jsonData
            ),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:common-court",

            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response);
        // if (!empty($res)) {

        return $res;
    }

    public function fecthDashboradData_gcc_citizen()
    {
        $user = Auth::user();
        $citizen_info = DB::table('users')
            ->join('ecourt_citizens', 'ecourt_citizens.id', 'users.citizen_id')
            ->select('ecourt_citizens.citizen_NID','ecourt_citizens.citizen_phone_no')
            ->where('users.id', $user->id)
            ->where('ecourt_citizens.citizen_type_id', 1)
            ->first();
        $auth_user = [
            'citizen_nid' => $citizen_info->citizen_NID,
            'citizen_phone_no' => $citizen_info->citizen_phone_no,
            'user_id' => $user->id,
            'username' => $user->username,

        ];

        $jsonData = json_encode($auth_user);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl() . '/api/gcc-citizen-dashboard-data',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'jss' => $jsonData
            ),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:common-court",

            ),
        ));

        $gcc_response = curl_exec($curl);
        curl_close($curl);
        $gcc_res = json_decode($gcc_response);
      

        return $gcc_res;
    }

    //for org rep
    public function showAppealCaseDetails($id)
    {
        $dataPayload = [];
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();
        $dataPayload['id'] = $id;
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($dataPayload);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/appeal/case/details';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);
    
            if ($result['success'] == true) {
                $page_title = 'সার্টিফিকেট রিকুইজিশান এর  বিস্তারিত তথ্য';
                $data = $result['data'];
          
                return view('appealView.gccAppealView', compact('page_title', "data"));
            } else {
            }
        }
    }

    public function showAppealTrakingPage($id)
    {
        $dataPayload = [];
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $officeInfo = user_office_info();
        $dataPayload['id'] = $id;
        $dataPayload['office_id'] = $office_id;
        $dataPayload['officeInfo'] = $officeInfo;
        $dataPayload['userInfo'] =  $user;
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($dataPayload);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/appeal/case/tracking';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);
            // dd('common module for gcc tracking', $result);
            if ($result['success'] == true) {

                $data['appeal']  = $result['data']['appeal'];
                $data['shortOrderTemplateList']  = $result['data']['shortOrderTemplateList'];
                $user_id = $data['appeal']['created_by'];
                $user = DB::table('users')->where('id', $user_id)->first();
                if ($user) {
                    $data['applicant_name'] = $user->name;
                }
                // dd($data, $user_id);
                $data['applicant_type'] = $data['appeal']['office_unit_name'];
                $page_title = 'মামলা ট্র্যাকিং';
                return view('appealView.gccAppealTracking', compact('page_title', "data"));
            } else {
            }
        }
    }

    //for gcc citizen
    public function showCitizenCaseDetails($id)
    {
        $dataPayload = [];
        $id = decrypt($id);
        $user = globalUserInfo();
        $dataPayload['id'] = $id;
        $dataPayload['userInfo'] =  $user;

        $token = $this->verifySiModuleToken('WEB');
        // dd($token);
        if ($token) {
            $jsonData = json_encode($dataPayload);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/citizen/case/details';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);
            // dd($result);
            if ($result['success'] == true) {
                $page_title = 'সার্টিফিকেট রিকুইজিশান এর  বিস্তারিত তথ্য';
                $data = $result['data'];
                return view('appealView.gccAppealView', compact('page_title', "data"));
            } else {
            }
        }
    }

    public function showCitizenTrakingPage($id)
    {
        $dataPayload = [];
        $id = decrypt($id);
        $user = globalUserInfo();
        $dataPayload['id'] = $id;

        $dataPayload['userInfo'] =  $user;
        $token = $this->verifySiModuleToken('WEB');
        if ($token) {
            $jsonData = json_encode($dataPayload);
            $url = getapiManagerBaseUrl() . '/api/v1/gcc/citizen/case/tracking';
            $method = 'POST';
            $bodyData = $jsonData;

            $res = makeCurlRequestWithToken_new($url, $method, $bodyData, $token);
            $result = json_decode($res, true);
            // dd($result);
            // dd('common module for gcc tracking', $result);
            if ($result['success'] == true) {

                $data['appeal']  = $result['data']['appeal'];
                $data['shortOrderTemplateList']  = $result['data']['shortOrderTemplateList'];
                $user_id = $data['appeal']['created_by'];
                $user = DB::table('users')->where('id', $user_id)->first();
                if ($user) {
                    $data['applicant_name'] = $user->name;
                }
                // dd($data, $user_id);
                $data['applicant_type'] = $data['appeal']['office_unit_name'];
                $page_title = 'মামলা ট্র্যাকিং';
                return view('appealView.gccAppealTracking', compact('page_title', "data"));
            } else {
            }
        }
    }
}