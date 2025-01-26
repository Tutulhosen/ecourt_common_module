<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserListController extends Controller
{
    //gcc user list
    public function gcc_user_list(){
        $data['divisions']=DB::table('division')->get();
        $data['gcc_role']=DB::table('gcc_role')->whereIn('id', [6,7,9,10,11,12,27,28])->orderBy('id', 'ASC')->get();
        $data['all_gcc_user']=DB::table('users')->join('doptor_user_access_info', 'users.id', 'doptor_user_access_info.user_id')->where('doptor_user_access_info.court_type_id', 2)->paginate(15);
        // dd($data);
        return view('userList.gccUserList')->with($data);
    }

    //gcc use list by search
    public function gcc_user_list_search(Request $request){
        $all_user=DB::table('users')
        ->join('doptor_user_access_info', 'users.id', 'doptor_user_access_info.user_id')
        ->join('office', 'users.office_id', 'office.id')
        ->where('doptor_user_access_info.court_type_id', 2);
        if (!empty($request->divisoin)) {
            $all_user=$all_user->where('office.division_id', $request->division);
        }
        if (!empty($request->district)) {
            $all_user=$all_user->where('office.district_id', $request->district);
        }
        if (!empty($request->upazila)) {
            $all_user=$all_user->where('office.upazila_id', $request->upazila);
        }
        if (!empty($request->role)) {
            $all_user=$all_user->where('doptor_user_access_info.role_id', $request->role);
        }
        if (!empty($request->user_name)) {
            $all_user=$all_user->where('users.username', $request->user_name);
        }
        if (!empty($request->mobile_no)) {
            $all_user=$all_user->where('users.mobile_no', $request->mobile_no);
        }
        $all_user= $all_user->paginate(15);

        // dd($all_user);
        $data['divisions']=DB::table('division')->get();
        $data['gcc_role']=DB::table('gcc_role')->whereIn('id', [6,7,9,10,11,12,27,28])->orderBy('id', 'ASC')->get();
        $data['all_gcc_user']=$all_user;
        // dd($data);
        return view('userList.gccUserListSearch')->with($data);
        

    }

    //gcc user list
    public function emc_user_list(){
        $data['divisions']=DB::table('division')->get();
        $data['emc_role']=DB::table('emc_role')->whereIn('id', [27,28,37,38,39])->orderBy('id', 'ASC')->get();
        $data['all_emc_user']=DB::table('users')->join('doptor_user_access_info', 'users.id', 'doptor_user_access_info.user_id')->where('doptor_user_access_info.court_type_id', 3)->paginate(15);
        // dd($data);
        return view('userList.emcUserList')->with($data);
    }

    //gcc use list by search
    public function emc_user_list_search(Request $request){
        $all_user=DB::table('users')
        ->join('doptor_user_access_info', 'users.id', 'doptor_user_access_info.user_id')
        ->join('office', 'users.office_id', 'office.id')
        ->where('doptor_user_access_info.court_type_id', 3);
        if (!empty($request->divisoin)) {
            $all_user=$all_user->where('office.division_id', $request->division);
        }
        if (!empty($request->district)) {
            $all_user=$all_user->where('office.district_id', $request->district);
        }
        if (!empty($request->upazila)) {
            $all_user=$all_user->where('office.upazila_id', $request->upazila);
        }
        if (!empty($request->role)) {
            $all_user=$all_user->where('doptor_user_access_info.role_id', $request->role);
        }
        if (!empty($request->user_name)) {
            $all_user=$all_user->where('users.username', $request->user_name);
        }
        if (!empty($request->mobile_no)) {
            $all_user=$all_user->where('users.mobile_no', $request->mobile_no);
        }
        $all_user= $all_user->paginate(15);

        // dd($all_user);
        $data['divisions']=DB::table('division')->get();
        $data['emc_role']=DB::table('emc_role')->whereIn('id', [27,28,37,38,39])->orderBy('id', 'ASC')->get();
        $data['all_emc_user']=$all_user;
        // dd($data);
        return view('userList.emcUserListSearch')->with($data);
        

    }

    //gcc user list
    public function mc_user_list(){
        $data['divisions']=DB::table('division')->get();
        $data['mc_role']=DB::table('mc_role')->whereIn('id', [25,26,27,37,38])->orderBy('id', 'ASC')->get();
        $data['all_mc_user']=DB::table('users')->join('doptor_user_access_info', 'users.id', 'doptor_user_access_info.user_id')->where('doptor_user_access_info.court_type_id', 1)->paginate(15);
        // dd($data);
        return view('userList.mcUserList')->with($data);
    }

    //gcc use list by search
    public function mc_user_list_search(Request $request){
        $all_user=DB::table('users')
        ->join('doptor_user_access_info', 'users.id', 'doptor_user_access_info.user_id')
        ->join('office', 'users.office_id', 'office.id')
        ->where('doptor_user_access_info.court_type_id', 1);
        if (!empty($request->divisoin)) {
            $all_user=$all_user->where('office.division_id', $request->division);
        }
        if (!empty($request->district)) {
            $all_user=$all_user->where('office.district_id', $request->district);
        }
        if (!empty($request->upazila)) {
            $all_user=$all_user->where('office.upazila_id', $request->upazila);
        }
        if (!empty($request->role)) {
            $all_user=$all_user->where('doptor_user_access_info.role_id', $request->role);
        }
        if (!empty($request->user_name)) {
            $all_user=$all_user->where('users.username', $request->user_name);
        }
        if (!empty($request->mobile_no)) {
            $all_user=$all_user->where('users.mobile_no', $request->mobile_no);
        }
        $all_user= $all_user->paginate(15);

        // dd($all_user);
        $data['divisions']=DB::table('division')->get();
        $data['mc_role']=DB::table('mc_role')->whereIn('id', [25,26,27,37,38])->orderBy('id', 'ASC')->get();
        $data['all_mc_user']=$all_user;
        // dd($data);
        return view('userList.mcUserListSearch')->with($data);
        

    }
}
