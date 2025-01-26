<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EmcCaseMappingApiController extends Controller
{
    public function store(Request $request)
    {

        $requestData = $request->all();
        $requestInfo = $requestData['body_data'];
        $court_type = $requestInfo['court_type']['level'];
        if ($court_type == 0) {
            $officeInfo = $requestInfo['officeInfo'];

            $assignedupzilla = DB::table('case_mapping')->where('court_id', $requestInfo['court_id'])->where('district_id', $officeInfo['district_id'])->where('status', 1)->where('lavel', 0)->select('upazilla_id')->get();
            $assignedipzilla = array();

            foreach ($assignedupzilla as $assignedupzilla) {
                array_push($assignedipzilla, $assignedupzilla->upazilla_id);
            }

            $requestupzill = array();

            if (!empty($requestInfo['upzilla_case_mapping'])) {

                foreach ($requestInfo['upzilla_case_mapping'] as $up_id) {
                    array_push($requestupzill, $up_id);

                    if (!in_array($up_id, $assignedipzilla)) {

                        $active_court = DB::table('case_mapping')->select('court_id')->where('district_id', $officeInfo['district_id'])->where('upazilla_id', $up_id)->where('status', 1)->where('lavel', 0)->first();

                        $upname = DB::table('upazila')->select('upazila_name_bn')->where('id', $up_id)->first();
                        if ($active_court) {
                            $active_court = DB::table('court')->where('id', $active_court->court_id)->first();

                            return response()->json([
                                'status' => 'error',
                                'upname' => $upname->upazila_name_bn,
                                'active_court' => $active_court->court_name

                            ]);
                        }

                        $court_case_mapping_exits = DB::table('case_mapping')
                            ->where('court_id', $requestInfo['court_id'])
                            ->where('district_id', $officeInfo['district_id'])
                            ->where('upazilla_id', $up_id)
                            ->where('court_id', $requestInfo['court_id'])
                            ->where('status', 0)
                            ->where('lavel', 0)
                            ->first();
                        if (!empty($court_case_mapping_exits)) {
                            DB::table('case_mapping')
                                ->where('court_id', $requestInfo['court_id'])
                                ->where('district_id', $officeInfo['district_id'])
                                ->where('upazilla_id', $up_id)
                                ->where('court_id', $requestInfo['court_id'])
                                ->where('lavel', 0)
                                ->update([
                                    'status' => 1
                                ]);
                        } else {

                            DB::table('case_mapping')->insert([
                                'court_id' => $requestInfo['court_id'],
                                'district_id' => $officeInfo['district_id'],
                                'upazilla_id' => $up_id,
                                'status' => 1,
                                'lavel' => 0,
                            ]);
                        }
                    }
                }
            }

            //var_dump($assignedipzilla);
            //var_dump($requestupzill);

            foreach ($assignedipzilla as $up_id) {

                if (!in_array($up_id, $requestupzill)) {
                    DB::table('case_mapping')->where('upazilla_id', $up_id)
                        ->where('court_id', $requestInfo['court_id'])
                        ->where('district_id', $officeInfo['district_id'])
                        ->where('lavel', 0)
                        ->update(array('status' => 0));
                }
            }

            return response()->json([
                'status' => 'success',

            ]);
        } else {
            $officeInfo = $requestInfo['officeInfo'];

            $assignedupzilla = DB::table('case_mapping')->where('court_id', $requestInfo['court_id'])->where('district_id', $officeInfo['district_id'])->where('status', 1)->where('lavel', 1)->select('upazilla_id')->get();
            $assignedipzilla = array();

            foreach ($assignedupzilla as $assignedupzilla) {
                array_push($assignedipzilla, $assignedupzilla->upazilla_id);
            }

            $requestupzill = array();
            if (!empty($request->upzilla_case_mapping)) {

                foreach ($request->upzilla_case_mapping as $up_id) {
                    array_push($requestupzill, $up_id);

                    if (!in_array($up_id, $assignedipzilla)) {

                        $active_court = DB::table('case_mapping')->select('court_id')->where('district_id', $officeInfo['district_id'])->where('upazilla_id', $up_id)->where('status', 1)->where('lavel', 1)->first();

                        $upname = DB::table('upazila')->select('upazila_name_bn')->where('id', $up_id)->first();
                        if ($active_court) {
                            $active_court = DB::table('court')->where('id', $active_court->court_id)->first();

                            return response()->json([
                                'status' => 'error',
                                'upname' => $upname->upazila_name_bn,
                                'active_court' => $active_court->court_name

                            ]);
                        }


                        $court_case_mapping_exits = DB::table('case_mapping')
                            ->where('court_id', $requestInfo['court_id'])
                            ->where('district_id', $officeInfo['district_id'])
                            ->where('upazilla_id', $up_id)
                            ->where('court_id', $requestInfo['court_id'])
                            ->where('status', 0)
                            ->where('lavel', 1)
                            ->first();
                        if (!empty($court_case_mapping_exits)) {
                            DB::table('case_mapping')
                                ->where('court_id', $requestInfo['court_id'])
                                ->where('district_id', $officeInfo['district_id'])
                                ->where('upazilla_id', $up_id)
                                ->where('court_id', $requestInfo['court_id'])
                                ->where('lavel', 1)
                                ->update([
                                    'status' => 1
                                ]);
                        } else {

                            DB::table('case_mapping')->insert([
                                'court_id' => $requestInfo['court_id'],
                                'district_id' => $officeInfo['district_id'],
                                'upazilla_id' => $up_id,
                                'status' => 1,
                                'lavel' => 1,
                            ]);
                        }
                    }
                }
            }

            //var_dump($assignedipzilla);
            //var_dump($requestupzill);

            foreach ($assignedipzilla as $up_id) {

                if (!in_array($up_id, $requestupzill)) {

                    DB::table('case_mapping')->where('upazilla_id', $up_id)
                        ->where('court_id', '=', $requestInfo['court_id'])
                        ->where('district_id', '=', $officeInfo['district_id'])
                        ->where('lavel', '=', 1)
                        ->update(array('status' => 0));
                }
            }

            return response()->json([
                'status' => 'success',

            ]);
        }
    }
}