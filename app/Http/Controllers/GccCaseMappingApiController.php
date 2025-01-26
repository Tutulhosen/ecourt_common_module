<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GccCaseMappingApiController extends Controller
{
    public function store(Request $request)
    {
        $requestData = $request->all();
        $requestInfo = $requestData['body_data'];
        $assignedupzilla = DB::table('case_mapping')->where('court_id', $requestInfo['court_id'])->where('district_id', $requestInfo['officeInfo']['district_id'])->where('status', 1)->select('upazilla_id')->get();
        $assignedipzilla = array();

        foreach ($assignedupzilla as $assignedupzilla) {
            array_push($assignedipzilla, $assignedupzilla->upazilla_id);
        }


        $requestupzill = array();
        if (!empty($requestInfo['upzilla_case_mapping'])) {

            foreach ($requestInfo['upzilla_case_mapping'] as $up_id) {
                array_push($requestupzill, $up_id);

                if (!in_array($up_id, $assignedipzilla)) {
                    
                    $active_court = DB::table('case_mapping')->select('court_id')->where('district_id',  $requestInfo['officeInfo']['district_id'])->where('upazilla_id', $up_id)->where('status', 1)->first();
                    
                    $upname = DB::table('upazila')->select('upazila_name_bn')->where('id', $up_id)->first();
                    if ($active_court) {
                        return ['active_court' => $active_court];
                        $active_court = DB::table('court')->where('id', $active_court->court_id)->first();

                        return response()->json([
                            'status' => 'error',
                            'upname' => $upname->upazila_name_bn,
                            'active_court' => $active_court->court_name

                        ]);
                    }

                    DB::table('case_mapping')->insert([
                        'court_id' =>  $requestInfo['court_id'],
                        'district_id' =>  $requestInfo['officeInfo']['district_id'],
                        'upazilla_id' => $up_id,
                        'status' => 1,
                    ]);
                }
            }
        }

        foreach ($assignedipzilla as $up_id) {

            if (!in_array($up_id, $requestupzill)) {

                DB::table('case_mapping')->where('upazilla_id', $up_id)
                    ->where('court_id', $requestInfo['court_id'])
                    ->where('district_id', $requestInfo['officeInfo']['district_id'])
                    ->update(array('status' => 0));

                //echo $up_id;

            }
        }

        return response()->json([
            'status' => 'success',
        ]);
    }
}