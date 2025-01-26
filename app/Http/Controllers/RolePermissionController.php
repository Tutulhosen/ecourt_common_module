<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index()
    {
        // dd($_GET['court_type_id']);
        $mc_role = DB::table('mc_role')->whereIn('id', [25, 26, 27, 37, 38])->get();
        $mc_permission = DB::table('mc_permission')->where('status', 1)->get();
        $gcc_role = DB::table('gcc_role')->whereIn('id', [6, 7, 10,11,12,27, 28])->orderBy('id', 'ASC')->get();
        $gcc_permission = DB::table('gcc_permission')->where('status', 1)->get();
        $emc_role = DB::table('emc_role')->whereIn('id', [27, 28, 37, 38, 39])->get();
        $emc_permission = DB::table('emc_permission')->where('status', 1)->get();
        // $has_mc_permission=DB::table('role_permission')->where();
        $data['page_title'] = 'রোল পারমিশন ফর্ম';
        $data['mc_role'] = $mc_role;
        $data['mc_permission'] = $mc_permission;
        $data['gcc_role'] = $gcc_role;
        $data['gcc_permission'] = $gcc_permission;
        $data['emc_role'] = $emc_role;
        $data['emc_permission'] = $emc_permission;
        return view('role_permission.index')->with($data);
    }
    public function show_permission(Request $request)
    {



        $assigned_permission = DB::table('role_permission')->where('role_id', $request->role_id)->where('court_type_id', $request->court_type)->where('status', 1)->select('permission_id')->get();
        if ($assigned_permission->count() > 0) {

            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }

            if ($request->court_type == 1) {
                $mc_permission = DB::table('mc_permission')->where('status', 1)->get();

                $html = ' ';
                $html .= '<table class="table table-hover mb-6 font-size-h6">
                <thead class="thead-light">
                    <tr>
                        <!-- <th scope="col" width="30">#</th> -->
                        <th scope="col">
                            সিলেক্ট করুণ
                        </th>
                        <th scope="col">নাম</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($mc_permission as $permissions) {

                    $checked = in_array($permissions->id, $assigned_permissions) ? 'checked' : '';

                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<div class="checkbox-inline">';
                    $html .= '<label class="checkbox">';
                    $html .= '<label class="checkbox">';
                    $html .= '<input type="checkbox" name="role_permisson[]"
                                        value="' . $permissions->id . '" class="role_permission_check" ' . $checked . '/><span></span>';
                    $html .= '</div>
                        </td>
                        <td>' . $permissions->name . '</td>';
                    $html .= '<tr>';
                }
                $html .= '</tbody>
                        </table>';
            }

            if ($request->court_type == 2) {
                $mc_permission = DB::table('gcc_permission')->where('status', 1)->get();

                $html = ' ';
                $html .= '<table class="table table-hover mb-6 font-size-h6">
                <thead class="thead-light">
                    <tr>
                        <!-- <th scope="col" width="30">#</th> -->
                        <th scope="col">
                            সিলেক্ট করুণ
                        </th>
                        <th scope="col">নাম</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($mc_permission as $permissions) {

                    $checked = in_array($permissions->id, $assigned_permissions) ? 'checked' : '';
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<div class="checkbox-inline">';
                    $html .= '<label class="checkbox">';
                    $html .= '<label class="checkbox">';
                    $html .= '<input type="checkbox" name="role_permisson[]"
                                        value="' . $permissions->id . '" class="role_permission_check" ' . $checked . '/><span></span>';
                    $html .= '</div>
                        </td>
                        <td>' . $permissions->name . '</td>';
                    $html .= '<tr>';
                }
                $html .= '</tbody>
                        </table>';
            }

            if ($request->court_type == 3) {
                $mc_permission = DB::table('emc_permission')->where('status', 1)->get();

                $html = ' ';
                $html .= '<table class="table table-hover mb-6 font-size-h6">
                <thead class="thead-light">
                    <tr>
                        <!-- <th scope="col" width="30">#</th> -->
                        <th scope="col">
                            সিলেক্ট করুণ
                        </th>
                        <th scope="col">নাম</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($mc_permission as $permissions) {

                    $checked = in_array($permissions->id, $assigned_permissions) ? 'checked' : '';
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<div class="checkbox-inline">';
                    $html .= '<label class="checkbox">';
                    $html .= '<label class="checkbox">';
                    $html .= '<input type="checkbox" name="role_permisson[]"
                                        value="' . $permissions->id . '" class="role_permission_check" ' . $checked . '/><span></span>';
                    $html .= '</div>
                        </td>
                        <td>' . $permissions->name . '</td>';
                    $html .= '<tr>';
                }
                $html .= '</tbody>
                        </table>';
            }
        } else {
            if ($request->court_type == 1) {
                $mc_permission = DB::table('mc_permission')->where('status', 1)->get();

                $html = ' ';
                $html .= '<table class="table table-hover mb-6 font-size-h6">
                    <thead class="thead-light">
                        <tr>
                            <!-- <th scope="col" width="30">#</th> -->
                            <th scope="col">
                                সিলেক্ট করুণ
                            </th>
                            <th scope="col">নাম</th>
                        </tr>
                    </thead>
                    <tbody>';

                foreach ($mc_permission as $permissions) {


                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<div class="checkbox-inline">';
                    $html .= '<label class="checkbox">';
                    $html .= '<label class="checkbox">';
                    $html .= '<input type="checkbox" name="role_permisson[]"
                                            value="' . $permissions->id . '" class="role_permission_check" /><span></span>';
                    $html .= '</div>
                            </td>
                            <td>' . $permissions->name . '</td>';
                    $html .= '<tr>';
                }
                $html .= '</tbody>
                            </table>';
            }
            if ($request->court_type == 2) {
                $mc_permission = DB::table('gcc_permission')->where('status', 1)->get();

                $html = ' ';
                $html .= '<table class="table table-hover mb-6 font-size-h6">
                    <thead class="thead-light">
                        <tr>
                            <!-- <th scope="col" width="30">#</th> -->
                            <th scope="col">
                                সিলেক্ট করুণ
                            </th>
                            <th scope="col">নাম</th>
                        </tr>
                    </thead>
                    <tbody>';

                foreach ($mc_permission as $permissions) {


                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<div class="checkbox-inline">';
                    $html .= '<label class="checkbox">';
                    $html .= '<label class="checkbox">';
                    $html .= '<input type="checkbox" name="role_permisson[]"
                                            value="' . $permissions->id . '" class="role_permission_check" /><span></span>';
                    $html .= '</div>
                            </td>
                            <td>' . $permissions->name . '</td>';
                    $html .= '<tr>';
                }
                $html .= '</tbody>
                            </table>';
            }
            if ($request->court_type == 3) {
                $mc_permission = DB::table('emc_permission')->where('status', 1)->get();

                $html = ' ';
                $html .= '<table class="table table-hover mb-6 font-size-h6">
                    <thead class="thead-light">
                        <tr>
                            <!-- <th scope="col" width="30">#</th> -->
                            <th scope="col">
                                সিলেক্ট করুণ
                            </th>
                            <th scope="col">নাম</th>
                        </tr>
                    </thead>
                    <tbody>';

                foreach ($mc_permission as $permissions) {


                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<div class="checkbox-inline">';
                    $html .= '<label class="checkbox">';
                    $html .= '<label class="checkbox">';
                    $html .= '<input type="checkbox" name="role_permisson[]"
                                            value="' . $permissions->id . '" class="role_permission_check" /><span></span>';
                    $html .= '</div>
                            </td>
                            <td>' . $permissions->name . '</td>';
                    $html .= '<tr>';
                }
                $html .= '</tbody>
                            </table>';
            }
        }
        return response()->json([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function store(Request $request)
    {

        $if_already_has = DB::table('role_permission')->where('role_id', $request->role_id)->where('court_type_id', $request->court_type_id)->get();
        // dd($if_already_has);

        
        if ($if_already_has->count() > 0) {

            if (!empty($request->permission_arr)) {
                $delete_first = DB::table('role_permission')->where('role_id', $request->role_id)->where('court_type_id', $request->court_type_id)->delete();
                foreach ($request->permission_arr as $role_permisson) {
                    DB::table('role_permission')->insert([
                        'role_id' => $request->role_id,
                        'permission_id' => $role_permisson,
                        'court_type_id' => $request->court_type_id,
                        'status' => 1,
                    ]);
                }
            } else {
                $delete_first = DB::table('role_permission')->where('role_id', $request->role_id)->where('court_type_id', $request->court_type_id)->delete();
                DB::table('role_permission')->insert([
                    'role_id' => $request->role_id,
                    'permission_id' => null,
                    'court_type_id' => $request->court_type_id,
                    'status' => 1,
                ]);
            }
        } else {
            if (!empty($request->permission_arr)) {

                foreach ($request->permission_arr as $role_permisson) {
                    DB::table('role_permission')->insert([
                        'role_id' => $request->role_id,
                        'permission_id' => $role_permisson,
                        'court_type_id' => $request->court_type_id,
                        'status' => 1,
                    ]);
                }
            } else {
                DB::table('role_permission')->insert([
                    'role_id' => $request->role_id,
                    'permission_id' => null,
                    'court_type_id' => $request->court_type_id,
                    'status' => 1,
                ]);
            }
        }

        $data = [];
        $data['permission_arr'] = $request->permission_arr;
        $data['role_id'] = $request->role_id;
        // Send data to emc court
        if ($request->court_type_id == 3) {
            $url = getEmcBaseUrl() . '/api/emc/v2/store-role-permission';
            $data = json_encode($data);
            $res = makeCurlRequest($url, "POST", $data);  
            if ($res->status == 'success') {
                return response()->json([
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'status' => 'role_set_error',
                ]);
            }
        }elseif($request->court_type_id == 2){
            $url = getGccBaseUrl() . '/api/gcc/v2/store-role-permission';
            $data = json_encode($data);
            $res = makeCurlRequest($url, "POST", $data);
    
            if ($res->status == 'success') {
                return response()->json([
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'status' => 'role_set_error',
                ]);
            }
        }
    }
}