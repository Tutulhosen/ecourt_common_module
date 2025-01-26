<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\TokenVerificationTrait;


class PeshkarSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use TokenVerificationTrait;
    public function index()
    {
        return view('setting.index');
    }


    //=====================Short Decisoin====================//
    public function shortDecision(Request $request)
    {

        $result = DB::table('peshkar_case_shortdecisions')
            ->select('peshkar_case_shortdecisions.id', 'peshkar_case_shortdecisions.case_short_decision', 'peshkar_case_shortdecisions.active_status');
        if (!empty($request->search_short_order_name)) {
            $result = $result->where('peshkar_case_shortdecisions.case_short_decision', 'LIKE', '%' . $request->search_short_order_name . '%');
        }
        // return $data;
        $data['shortDecision'] = $result->paginate(10);
        $data['page_title'] = 'পেশকার কর্তৃক গৃহীত ব্যবস্থা';
        return view('setting.emc.peshkar.short_decision')->with($data);
    }

    public function shortDecisionDetailsCreate($id)
    {
        $data['shortDecision'] = DB::table('peshkar_case_shortdecisions')->where('peshkar_case_shortdecisions.id', $id)->first();
        $law_sec = DB::table('peshkar_case_shortdecisions')->select('law_sec_id')->where('peshkar_case_shortdecisions.id', $id)->first()->law_sec_id;
        $data['law_sec_id'] = explode(",", str_replace(array('[', ']', '"'), '', $law_sec));

        foreach ($data['law_sec_id'] as $crpc_id) {

            $data['shortDecisionDetails'][] = DB::table('peshkar_case_shortdecisions_details')->where('case_short_decision_id', $id)->where('law_sec_id', $crpc_id)->select('delails')->get();
            $data['smsDetails'][] = DB::table('peshkar_case_shortdecisions_details')->where('case_short_decision_id', $id)->where('law_sec_id', $crpc_id)->select('sms_templet')->get();
        }
        $data['page_title'] = 'পেশকার কর্তৃক গৃহীত ব্যবস্থার বিস্তারিত';
        // return $data;
        return view('setting.emc.peshkar.short_decision_template_create')->with($data);
    }

    public function shortDecisionDetailsStore(Request $request)
    {
        // return $request;


        foreach ($request->law_sec_id as  $key => $value) {
            $is_available = DB::table('peshkar_case_shortdecisions_details')->where('case_short_decision_id', $request->case_short_decision_id)->where('law_sec_id', $value)->first();
            // return $is_available->id;
            $data = array();
            $data['case_short_decision_id'] = $request->case_short_decision_id;
            $data['law_sec_id'] = $value;
            $data['delails'] = $request->details[$key];
            $data['sms_templet'] = $request->sms_templet[$key];
            if (!empty($is_available)) {
                DB::table('peshkar_case_shortdecisions_details')->where('id', $is_available->id)->update($data);
            } else {
                DB::table('peshkar_case_shortdecisions_details')->insert($data);
            }
        }

        return redirect()->route('peshkar.short.decision')->with('success', 'Short decision data updated successfully');
    }

    public function shortDecisionCreate()
    {
        $data['crpc_sections'] = DB::table('crpc_sections')->select('crpc_id')->get();

        $data['page_title'] = 'পেশকার কর্তৃক গৃহীত ব্যবস্থা তৈরি ';
        // return $data;
        return view('setting.emc.peshkar.short_decision_create')->with($data);
    }

    public function shortDecisionEdit($id)
    {
        $data['shortDecision'] = DB::table('peshkar_case_shortdecisions')->where('peshkar_case_shortdecisions.id', $id)->first();


        $data['crpc_sections'] = DB::table('crpc_sections')->select('crpc_id')->get();

        $data['page_title'] = 'পেশকার কর্তৃক গৃহীত ব্যবস্থা সংশোধন';
        // return $data;
        return view('setting.emc.peshkar.short_decision_edit')->with($data);
    }

    public function shortDecisionStore(Request $request)
    {
        // return $request;
        $request->validate([
            'case_short_decision'   => 'required',
            'law_sec_id'            => 'required',
        ]);

        $crpc = $request->input('law_sec_id');
        $crpc_implode = implode(",", $crpc);

        $data = [
            'case_short_decision'   => $request->case_short_decision,
            'law_sec_id'            => $crpc_implode,
            'active_status'         => 1,
        ];
        $datas = json_encode($data, true);
        $url = getapiManagerBaseUrl() . '/api/emc/peskar-short-decision-create';
        $token = $this->verifySiModuleToken('WEB');
        $method = 'POST';

        $res = makeCurlRequestWithToken_update(
            $url,
            $method,
            $datas,
            $token
        );
        $res = json_decode($res, true);
        if ($res['status'] == false) {
            dd($res);
        }
        $ID = DB::table('peshkar_case_shortdecisions')->insert($data);

        return redirect()->route('peshkar.short.decision')->with('success', 'Short decision data updated successfully');
    }

    public function shortDecisionUpdate(Request $request, $id = '')
    {
        // return $request;
        $request->validate([
            'case_short_decision'   => 'required',
        ]);

        $crpc = $request->input('law_sec_id');
        if (empty($crpc)) {
            $data = [
                'case_short_decision'   => $request->case_short_decision,
                'law_sec_id'            => '',
            ];
            $datas = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/emc/peskar-short-decision-update/' . $id;
            $token = $this->verifySiModuleToken('WEB');
            $method = 'POST';

            $res = makeCurlRequestWithToken_update(
                $url,
                $method,
                $datas,
                $token
            );
            $res = json_decode($res, true);
            if ($res['status'] == false) {
                dd($res);
            }
            DB::table('peshkar_case_shortdecisions')->where('id', $id)->update($data);

            return redirect()->route('peshkar.short.decision')->with('success', 'Short decision data updated successfully');
        } else {

            $crpc_implode = implode(",", $crpc);
            $data = [
                'case_short_decision'   => $request->case_short_decision,
                'law_sec_id'            => $crpc_implode,
            ];
            $datas = json_encode($data, true);
            $url = getapiManagerBaseUrl() . '/api/emc/peskar-short-decision-update/' . $id;
            $token = $this->verifySiModuleToken('WEB');
            $method = 'POST';

            $res = makeCurlRequestWithToken_update(
                $url,
                $method,
                $datas,
                $token
            );
            $res = json_decode($res, true);
            if ($res['status'] == false) {
                dd($res);
            }
            DB::table('peshkar_case_shortdecisions')->where('id', $id)->update($data);

            return redirect()->route('peshkar.short.decision')->with('success', 'Short decision data updated successfully');
        }
    }
}
