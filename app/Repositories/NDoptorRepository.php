<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class NDoptorRepository
{
    public static function DC_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $district = self::get_district($office_info);

        $division = DB::table('division')
            ->where('division_bbs_code', $district->division_bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_data = [
            'level' => 3,
            'parent' => null,
            'parent_name' => null,
            'office_name_bn' => $office_info->office_name_bn,
            'office_name_en' => $office_info->office_name_en,
            'unit_name_bn' => $office_info->unit_name_bn,
            'unit_name_en' => $office_info->unit_name_en,
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => null,
            'office_unit_organogram_id' => $ref_origin_unit_org_id,
            'is_gcc' => 0,
            'is_organization' => 0,
            'status' => 1,
            'is_dm_adm_em' => 1,
        ];

        $office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        if (isset($office_id)) {
            //dd('sdbds');
            // $office_id = DB::table('office')
            //     ->orderBy('id', 'desc')
            //     ->first();
            //dd($office_id);

            $role_id = 37;
            $designation = $office_info->designation . '(জেলা ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);

            $court_id = DB::table('court')->where('status', 1)->where('district_id', '=', $district_id)->where('division_id', '=', $division_id)
                ->where('level', '=', 2)->first();

            $user = [
                'name' => $response->data->employee_info->name_bng,
                'username' => $response->data->user->username,
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $response->data->employee_info->personal_mobile,
                'email' => $response->data->employee_info->personal_email,
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info->office_id,
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $court_id->id,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }
    public static function new_GCO_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email'] == '') {
            # code...
            $email = null;
        } else {
            $email = $employee_info_from_api['personal_email'];
        }
        // dd($email);
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);


        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 27;

                $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => 1,
                ];
            }
            $user_create_id = DB::table('users')->insertGetId($user);

            if ($user_create_id) {
                $data = [
                    'user_id' => $user_create_id,
                    'court_type_id' => $user_info_from_request['court_type_id'],
                    'court_id' => $user_info_from_request['court_id'],
                    'role_id' => $role_id,
                ];
            }
            $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);


            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();

            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
    }
    public static function GCO_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];


        $office_id = Self::OfficeExitsCheck($office_data);

        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        if (isset($office_id)) {

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function GCO_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];
        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);


        if ($updated_office == 1) {

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,
                'signature' => null,
                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }
    public static function new_GCO_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email'] == '') {
            # code...
            $email = null;
        } else {
            $email = $employee_info_from_api['personal_email'];
        }
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];
        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);


        if ($updated_office == 1) {
            DB::beginTransaction();
            try {
                $role_id = 27;

                $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');


                if ($user_info_from_request['court_id'] == 0) {
                    $doptor_user_active = 0;
                } else {
                    $doptor_user_active = 1;
                }


                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => 0
                ];

                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);

                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();
                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();
                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }


                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return false;
            }
        } elseif ($updated_office == 0) {


            $doptor_user_active = 1;

            DB::beginTransaction();
            try {
                $role_id = 27;

                $designation = $user_info_from_request['designation_bng'] . '(জিসিও)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => 0
                ];
                //    dd($user);
                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);


                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();

                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();

                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        // return $data;
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }



                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return redirect()
                    ->back()
                    ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
            }
        }
    }
    public static function certificate_assistent_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email'] == '') {
            # code...
            $email = null;
        } else {
            $email = $employee_info_from_api['personal_email'];
        }
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];


        $office_id = Self::OfficeExitsCheck($office_data);

        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 28;

                $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => 1,
                    'peshkar_active' => 1,
                ];
            }
            $user_create_id = DB::table('users')->insertGetId($user);

            if ($user_create_id) {
                $data = [
                    'user_id' => $user_create_id,
                    'court_type_id' => $user_info_from_request['court_type_id'],
                    'court_id' => $user_info_from_request['court_id'],
                    'role_id' => $role_id,
                ];
            }
            $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);


            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();

            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
    }
    public static function new_certificate_assistent_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        if ($employee_info_from_api['personal_email'] == '') {

            $email = null;
        } else {
            $email = $employee_info_from_api['personal_email'];
        }
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            DB::beginTransaction();
            try {
                $role_id = 28;

                $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                if ($user_info_from_request['court_id'] == 0) {
                    $doptor_user_active = 0;
                    $peshkar_active = 0;
                } else {
                    $doptor_user_active = 1;
                    $peshkar_active = 1;
                }



                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => $peshkar_active
                ];

                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);

                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();
                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();
                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }


                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return redirect()
                    ->back()
                    ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
            }
        } elseif ($updated_office == 0) {




            DB::beginTransaction();
            try {
                $role_id = 28;

                $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                if ($user_info_from_request['court_id'] == 0) {
                    $doptor_user_active = 0;
                    $peshkar_active = 0;
                } else {
                    $doptor_user_active = 1;
                    $peshkar_active = 1;
                }

                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => $peshkar_active
                ];

                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);

                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();
                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();
                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }


                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return redirect()
                    ->back()
                    ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
            }
        }
    }

    public static function emc_em_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);
    

        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 27;

                $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট))';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => 1,
                ];
       
            }
            $user_create_id = DB::table('users')->insertGetId($user);
    
            if ($user_create_id) {
                $data=[
                    'user_id' => $user_create_id,
                    'court_type_id' => $user_info_from_request['court_type_id'],
                    'court_id' => $user_info_from_request['court_id'],
                    'role_id' => $role_id,
                ];
             
            }
            $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);

            
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();
        
            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
        
    }
    public static function emc_em_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email'] == '') {
            # code...
            $email = null;
        } else {
            $email = $employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => null,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            DB::beginTransaction();
            try {

                $role_id = 27;

                $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট))';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');



                $doptor_user_active = 1;


                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => 0
                ];

                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);

                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();
                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();
                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }


                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return redirect()
                    ->back()
                    ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
            }
        } elseif ($updated_office == 0) {


            $doptor_user_active = 1;

            DB::beginTransaction();
            try {

                $role_id = 27;

                $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => 0
                ];

                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);

                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();
                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();
                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }


                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return redirect()
                    ->back()
                    ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
            }
        }
    }
    public static function emc_em_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);
    

        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 28;

                $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম)))';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => 1,
                    'peshkar_active'=>1
                ];
       
            }
            $user_create_id = DB::table('users')->insertGetId($user);
    
            if ($user_create_id) {
                $data=[
                    'user_id' => $user_create_id,
                    'court_type_id' => $user_info_from_request['court_type_id'],
                    'court_id' => $user_info_from_request['court_id'],
                    'role_id' => $role_id,
                ];
             
            }
            $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);

            
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();
        
            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
        
    }

    public static function emc_em_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => null,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

            if ($updated_office == 1) {
                DB::beginTransaction();
                try {

                    $role_id = 28;

                    $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম)))';
                    $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                   
                  
                    if ($user_info_from_request['court_id'] == 0) {
                        $doptor_user_active = 0;
                        $peshkar_active=0;
                    } else {
                        $doptor_user_active = 1;
                        $peshkar_active=1;
                    }
                    
                    
                    $user = [
                        'name' => $user_info_from_request['employee_name_bng'],
                        'username' => $user_info_from_request['username'],
                        'office_id' => $to_update_office_id->office_id,
                        'mobile_no' => $employee_info_from_api['personal_mobile'],
                        'email' => $email,
                        'profile_image' => null,
                        'email_verified_at' => null,
                        'password' => $password,
                        'profile_pic' => null,
                        'signature' => null,
                        'citizen_id' => null,
                        'designation' => $designation,
                        'organization_id' => null,
                        'remember_token' => null,
                        'doptor_office_id' => $office_info_from_request['office_id'],
                        'doptor_user_flag' => 1,
                        'doptor_user_active' => $doptor_user_active,
                        'peshkar_active'=>$peshkar_active
                        
                    ];
    
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->update($user);
                    
                        if ($updated_users) {
                            $updated_users = DB::table('users')
                            ->where('username', '=', $user_info_from_request['username'])
                            ->first();
                            $has_already_access=DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->first();
                            if (!empty($has_already_access)) {
                                $data=[
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->update($data);
                            } else {
                                $data=[
                                    'user_id' => $updated_users->id,
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
        
                            }
                            
                            
                        }
                
                    
                    DB::commit();
                    return true;
                } catch (\Throwable $e) {
                    dd($e);
                    DB::rollback();
                
                    $flag = 'false';
                    return redirect()
                        ->back()
                        ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
                    }
                
    
                
                
            } elseif ($updated_office == 0) {
               
                
                $doptor_user_active = 1;
                
                DB::beginTransaction();
                try {
                    
                    $role_id = 28;

                    $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম))';
                    $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                    $user = [
                        'name' => $user_info_from_request['employee_name_bng'],
                        'username' => $user_info_from_request['username'],
                        'office_id' => $to_update_office_id->office_id,
                        'mobile_no' => $employee_info_from_api['personal_mobile'],
                        'email' => $email,
                        'profile_image' => null,
                        'email_verified_at' => null,
                        'password' => $password,
                        'profile_pic' => null,
                        'signature' => null,
                        'citizen_id' => null,
                        'designation' => $designation,
                        'organization_id' => null,
                        'remember_token' => null,
                        'doptor_office_id' => $office_info_from_request['office_id'],
                        'doptor_user_flag' => 1,
                        'doptor_user_active' => $doptor_user_active,
                        'peshkar_active'=>1
                    ];
               
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->update($user);
    
                        if ($updated_users) {
                            $updated_users = DB::table('users')
                            ->where('username', '=', $user_info_from_request['username'])
                            ->first();
                            $has_already_access=DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->first();
                            if (!empty($has_already_access)) {
                                $data=[
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->update($data);
                            } else {
                                $data=[
                                    'user_id' => $updated_users->id,
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
        
                            }
                            
                            
                        }
                
                    
                    DB::commit();
                    return true;
                } catch (\Throwable $e) {
                    dd($e);
                    DB::rollback();
                
                    $flag = 'false';
                    return redirect()
                        ->back()
                        ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
                }
                
            }

           

    }
    public static function emc_courtlist_distrcit_all($district_id,$division_id)
    {
        $query = DB::table('emc_court')->where('status',1);

       
        if (!empty($district_id)) {
            $query->where('district_id', '=', $district_id);
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', $division_id);
        }
        $court = $query->get();

        return $court;


    }

    public static function emc_adm_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);
    

        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 39;

                $designation = $user_info_from_request['designation_bng'] . '(পেশকার (এ ডি এম))';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => 1,
                    'peshkar_active'=>1
                ];
       
            }
            $user_create_id = DB::table('users')->insertGetId($user);
    
            if ($user_create_id) {
                $data=[
                    'user_id' => $user_create_id,
                    'court_type_id' => $user_info_from_request['court_type_id'],
                    'court_id' => $user_info_from_request['court_id'],
                    'role_id' => $role_id,
                ];
             
            }
            $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);

            
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();
        
            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
        
    }
    public static function emc_adm_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => null,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

            if ($updated_office == 1) {
                DB::beginTransaction();
                try {

                    $role_id = 39;

                    $designation = $user_info_from_request['designation_bng'] . '(পেশকার (এ ডি এম))';
                    $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                   
                  
                    $doptor_user_active = 1;
                    
                    
                    $user = [
                        'name' => $user_info_from_request['employee_name_bng'],
                        'username' => $user_info_from_request['username'],
                        'office_id' => $to_update_office_id->office_id,
                        'mobile_no' => $employee_info_from_api['personal_mobile'],
                        'email' => $email,
                        'profile_image' => null,
                        'email_verified_at' => null,
                        'password' => $password,
                        'profile_pic' => null,
                        'signature' => null,
                        'citizen_id' => null,
                        'designation' => $designation,
                        'organization_id' => null,
                        'remember_token' => null,
                        'doptor_office_id' => $office_info_from_request['office_id'],
                        'doptor_user_flag' => 1,
                        'doptor_user_active' => $doptor_user_active,
                        'peshkar_active'=>1
                    ];
    
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->update($user);
                    
                        if ($updated_users) {
                            $updated_users = DB::table('users')
                            ->where('username', '=', $user_info_from_request['username'])
                            ->first();
                            $has_already_access=DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->first();
                            if (!empty($has_already_access)) {
                                $data=[
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->update($data);
                            } else {
                                $data=[
                                    'user_id' => $updated_users->id,
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
        
                            }
                            
                            
                        }
                
                    
                    DB::commit();
                    return true;
                } catch (\Throwable $e) {
                    dd($e);
                    DB::rollback();
                
                    $flag = 'false';
                    return redirect()
                        ->back()
                        ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
                    }
                
    
                
                
            } elseif ($updated_office == 0) {
               
                
                $doptor_user_active = 1;
                
                DB::beginTransaction();
                try {
                    
                    $role_id = 39;

                    $designation = $user_info_from_request['designation_bng'] . '(পেশকার (এ ডি এম))';
                    $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                    $user = [
                        'name' => $user_info_from_request['employee_name_bng'],
                        'username' => $user_info_from_request['username'],
                        'office_id' => $to_update_office_id->office_id,
                        'mobile_no' => $employee_info_from_api['personal_mobile'],
                        'email' => $email,
                        'profile_image' => null,
                        'email_verified_at' => null,
                        'password' => $password,
                        'profile_pic' => null,
                        'signature' => null,
                        'citizen_id' => null,
                        'designation' => $designation,
                        'organization_id' => null,
                        'remember_token' => null,
                        'doptor_office_id' => $office_info_from_request['office_id'],
                        'doptor_user_flag' => 1,
                        'doptor_user_active' => $doptor_user_active,
                        'peshkar_active'=>1
                    ];
               
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->update($user);
    
                        if ($updated_users) {
                            $updated_users = DB::table('users')
                            ->where('username', '=', $user_info_from_request['username'])
                            ->first();
                            $has_already_access=DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->first();
                            if (!empty($has_already_access)) {
                                $data=[
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->update($data);
                            } else {
                                $data=[
                                    'user_id' => $updated_users->id,
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
        
                            }
                            
                            
                        }
                
                    
                    DB::commit();
                    return true;
                } catch (\Throwable $e) {
                    dd($e);
                    DB::rollback();
                
                    $flag = 'false';
                    return redirect()
                        ->back()
                        ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
                }
                
            }

           

    }

    public static function emc_adm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;
        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => null,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

            if ($updated_office == 1) {
                DB::beginTransaction();
                try {

                    $role_id = 38;

                    $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক)';
                    $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                   
                  
                    $doptor_user_active = 1;
                    
                    
                    $user = [
                        'name' => $user_info_from_request['employee_name_bng'],
                        'username' => $user_info_from_request['username'],
                        'office_id' => $to_update_office_id->office_id,
                        'mobile_no' => $employee_info_from_api['personal_mobile'],
                        'email' => $email,
                        'profile_image' => null,
                        'email_verified_at' => null,
                        'password' => $password,
                        'profile_pic' => null,
                        'signature' => null,
                        'citizen_id' => null,
                        'designation' => $designation,
                        'organization_id' => null,
                        'remember_token' => null,
                        'doptor_office_id' => $office_info_from_request['office_id'],
                        'doptor_user_flag' => 1,
                        'doptor_user_active' => $doptor_user_active,
                        'peshkar_active'=>0
                    ];
    
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->update($user);
                    
                        if ($updated_users) {
                            $updated_users = DB::table('users')
                            ->where('username', '=', $user_info_from_request['username'])
                            ->first();
                            $has_already_access=DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->first();
                            if (!empty($has_already_access)) {
                                $data=[
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->update($data);
                            } else {
                                $data=[
                                    'user_id' => $updated_users->id,
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
        
                            }
                            
                            
                        }
                
                    
                    DB::commit();
                    return true;
                } catch (\Throwable $e) {
                    dd($e);
                    DB::rollback();
                
                    $flag = 'false';
                    return redirect()
                        ->back()
                        ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
                    }
                
    
                
                
            } elseif ($updated_office == 0) {
               
                
                $doptor_user_active = 1;
                
                DB::beginTransaction();
                try {
                    
                    $role_id = 38;

                    $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক)';
                    $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                    $user = [
                        'name' => $user_info_from_request['employee_name_bng'],
                        'username' => $user_info_from_request['username'],
                        'office_id' => $to_update_office_id->office_id,
                        'mobile_no' => $employee_info_from_api['personal_mobile'],
                        'email' => $email,
                        'profile_image' => null,
                        'email_verified_at' => null,
                        'password' => $password,
                        'profile_pic' => null,
                        'signature' => null,
                        'citizen_id' => null,
                        'designation' => $designation,
                        'organization_id' => null,
                        'remember_token' => null,
                        'doptor_office_id' => $office_info_from_request['office_id'],
                        'doptor_user_flag' => 1,
                        'doptor_user_active' => $doptor_user_active,
                        'peshkar_active'=>0
                    ];
               
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->update($user);
    
                        if ($updated_users) {
                            $updated_users = DB::table('users')
                            ->where('username', '=', $user_info_from_request['username'])
                            ->first();
                            $has_already_access=DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->first();
                            if (!empty($has_already_access)) {
                                $data=[
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id',$updated_users->id)->where('court_type_id',$user_info_from_request['court_type_id'])->update($data);
                            } else {
                                $data=[
                                    'user_id' => $updated_users->id,
                                    'court_type_id' => $user_info_from_request['court_type_id'],
                                    'court_id' => $user_info_from_request['court_id'],
                                    'role_id' => $role_id,
                                ];
                                $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
        
                            }
                            
                            
                        }
                
                    
                    DB::commit();
                    return true;
                } catch (\Throwable $e) {
                    dd($e);
                    DB::rollback();
                
                    $flag = 'false';
                    return redirect()
                        ->back()
                        ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
                }
                
            }

           

    }
    public static function emc_adm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;
        

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);
    

        //$office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 38;

                $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
    
                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => 1,
                ];
       
            }
            $user_create_id = DB::table('users')->insertGetId($user);
    
            if ($user_create_id) {
                $data=[
                    'user_id' => $user_create_id,
                    'court_type_id' => $user_info_from_request['court_type_id'],
                    'court_id' => $user_info_from_request['court_id'],
                    'role_id' => $role_id,
                ];
             
            }
            $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);

            
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();
        
            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
        
    }

    public static function Ad_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email'] == '') {
            # code...
            $email = null;
        } else {
            $email = $employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => null,
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 7;

                $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => 1,
                ];
            }
            $user_create_id = DB::table('users')->insertGetId($user);

            if ($user_create_id) {
                $data = [
                    'user_id' => $user_create_id,
                    'court_type_id' => $user_info_from_request['court_type_id'],
                    'court_id' => $user_info_from_request['court_id'],
                    'role_id' => $role_id,
                ];
            }
            $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);


            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollback();

            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
    }

    public static function Ad_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email'] == '') {
            # code...
            $email = null;
        } else {
            $email = $employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 51;

        $is_gcc = 1;
        $is_organization = 0;
        $status = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,

            'upazila_id' => null,
            'upa_name_bn' => null,
            'upa_name_en' => null,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => null,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            DB::beginTransaction();
            try {
                $role_id = 7;

                $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');



                $doptor_user_active = 1;


                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => 0
                ];

                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);

                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();
                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();
                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }


                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return redirect()
                    ->back()
                    ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
            }
        } elseif ($updated_office == 0) {


            $doptor_user_active = 1;

            DB::beginTransaction();
            try {
                $role_id = 7;

                $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক)';
                $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

                $user = [
                    'name' => $user_info_from_request['employee_name_bng'],
                    'username' => $user_info_from_request['username'],
                    'office_id' => $to_update_office_id->office_id,
                    'mobile_no' => $employee_info_from_api['personal_mobile'],
                    'email' => $email,
                    'profile_image' => null,
                    'email_verified_at' => null,
                    'password' => $password,
                    'profile_pic' => null,
                    'signature' => null,
                    'citizen_id' => null,
                    'designation' => $designation,
                    'organization_id' => null,
                    'remember_token' => null,
                    'doptor_office_id' => $office_info_from_request['office_id'],
                    'doptor_user_flag' => 1,
                    'doptor_user_active' => $doptor_user_active,
                    'peshkar_active' => 0
                ];

                $updated_users = DB::table('users')
                    ->where('username', '=', $user_info_from_request['username'])
                    ->update($user);

                if ($updated_users) {
                    $updated_users = DB::table('users')
                        ->where('username', '=', $user_info_from_request['username'])
                        ->first();
                    $has_already_access = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->first();
                    if (!empty($has_already_access)) {
                        $data = [
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info_update = DB::table('doptor_user_access_info')->where('user_id', $updated_users->id)->where('court_type_id', $user_info_from_request['court_type_id'])->update($data);
                    } else {
                        $data = [
                            'user_id' => $updated_users->id,
                            'court_type_id' => $user_info_from_request['court_type_id'],
                            'court_id' => $user_info_from_request['court_id'],
                            'role_id' => $role_id,
                        ];
                        $doptor_user_access_info = DB::table('doptor_user_access_info')->insert($data);
                    }
                }


                DB::commit();
                return true;
            } catch (\Throwable $e) {
                dd($e);
                DB::rollback();

                $flag = 'false';
                return redirect()
                    ->back()
                    ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
            }
        }
    }

    public static function all_user_list_from_doptor_segmented_for_dc($data)
    {
        $list_of_all = [];
        // dd($data);
        foreach ($data as $value) {
            $court_id = DB::table('users')
                ->select('court_id', 'role_id', 'doptor_user_active')
                ->where('username', '=', $value['username'])
                ->first();

            if (!empty($court_id)) {
                $value['court_id'] = $court_id->court_id;
                $value['role_id'] = $court_id->role_id;
                $value['doptor_user_active'] = $court_id->doptor_user_active;
            } else {
                $value['court_id'] = null;
                $value['role_id'] = null;
                $value['doptor_user_active'] = null;
            }
            array_push($list_of_all, $value);
        }

        return json_encode([
            'list_of_all' => $list_of_all,
        ]);
    }

    public static function gcc_courtlist_district_all($district_id, $division_id)
    {
        $query = DB::table('gcc_court');
        $query->where('level', '=', 1);
        if (!empty($district_id)) {
            $query->where('district_id', '=', $district_id);
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', $division_id);
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')
    }
    public static function Divisional_Commissioner_create($response, $office_info, $ref_origin_unit_org_id)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $district_id = null;
        $dis_name_bn = null;
        $dis_name_en = null;
        $district_bbs_code = null;
        $upazila_bbs_code = null;

        $division = self::get_division($office_info);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $office_data = [
            'level' => 2,
            'parent' => null,
            'parent_name' => null,
            'office_name_bn' => $office_info->office_name_bn,
            'office_name_en' => $office_info->office_name_en,
            'unit_name_bn' => $office_info->unit_name_bn,
            'unit_name_en' => $office_info->unit_name_en,
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,
            'office_unit_organogram_id' => $ref_origin_unit_org_id,
            'is_gcc' => 0,
            'is_organization' => 0,
            'status' => 1,
            'is_dm_adm_em' => 1,
        ];

        $office_id = DB::table('office')->insertGetId($office_data);

        //dd($office_create);
        if (isset($office_id)) {
            //dd('sdbds');
            // $office_id = DB::table('office')
            //     ->orderBy('id', 'desc')
            //     ->first();
            //dd($office_id);

            $role_id = 34;
            $designation = $office_info->designation;
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            $user = [
                'name' => $response->data->employee_info->name_bng,
                'username' => $response->data->user->username,
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $response->data->employee_info->personal_mobile,
                'email' => $response->data->employee_info->personal_email,
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info->office_id,
                'doptor_user_flag' => 1,
            ];
        }
        $user_create = DB::table('users')->insert($user);

        return $user_create;
    }

    public static function get_district($office_info)
    {
        $get_token_response = Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(DOPTOR_ENDPOINT() . '/api/client/login', [
                'client_id' => doptor_client_id(),
                'username' => 200000001311,
                'password' => doptor_password(),
            ])
            ->throw()
            ->json();

        //dd($get_token_response);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            //$office_list_endpoint='/'.;

            $get_office_response = Http::withHeaders([
                'api-version' => 1,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ])
                ->post(DOPTOR_ENDPOINT() . '/api/offices', [
                    'office_ids' => $office_info->office_id,
                    'type' => 'both',
                ])
                ->throw()
                ->json();

            // if ($get_office_response['status'] == 'success') {
            //     $get_office_response['data'][$office_info->office_id]['geo_district_id']
            // }

            if ($get_office_response['status'] == 'success') {
                $district_from_geo = DB::table('geo_districts')
                    ->where('id', '=', $get_office_response['data'][$office_info->office_id]['geo_district_id'])
                    ->first();

                $district = DB::table('district')
                    ->where('district_name_en', $district_from_geo->district_name_eng)
                    ->select('id', 'district_name_bn', 'district_name_en', 'division_bbs_code', 'district_bbs_code')
                    ->first();

                return $district;
            }
        }
    }
    public static function get_division($office_info)
    {
        $get_token_response = Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(DOPTOR_ENDPOINT() . '/api/client/login', [
                'client_id' => doptor_client_id(),
                'username' => 200000001311,
                'password' => doptor_password(),
            ])
            ->throw()
            ->json();

        //dd($get_token_response);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            //$office_list_endpoint='/'.;

            $get_office_response = Http::withHeaders([
                'api-version' => 1,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ])
                ->post(DOPTOR_ENDPOINT() . '/api/offices', [
                    'office_ids' => $office_info->office_id,
                    'type' => 'both',
                ])
                ->throw()
                ->json();

            if ($get_office_response['status'] == 'success') {
                $division_from_geo = DB::table('geo_divisions')
                    ->where('id', '=', $get_office_response['data'][$office_info->office_id]['geo_division_id'])
                    ->first();

                $division = DB::table('division')
                    ->where('division_name_en', $division_from_geo->division_name_eng)
                    ->first();

                return $division;
            }
        }
    }

    public static function verifyADC($data)
    {
        if ($data[0]['office_id'] != globalUserInfo()->doptor_office_id) {
            //return $data;

            $list_of_UNO = [];

            foreach ($data as $value) {
                if (str_contains($value['designation_eng'], 'UNO Officer')) {

                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                } else if (str_contains($value['designation_eng'], 'UNO')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                } else if (str_contains($value['designation_eng'], 'Uno')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                }
            }

            return json_encode([
                'list_of_UNO_flag' => 1,
                'list_of_UNO' => $list_of_UNO,
            ]);
        } else {
            $list_of_ADC = [];

            foreach ($data as $value) {
                if (str_contains($value['designation_eng'], 'ADC')) {

                    $court_id = DB::table('users')
                        ->select('court_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }
                    array_push($list_of_ADC, $value);
                } elseif (str_contains($value['designation_eng'], 'Additional Deputy Commissioner')) {
                    $court_id = DB::table('users')
                        ->select('court_id')
                        ->where('username', '=', $value['username'])
                        ->first();
                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_ADC, $value);
                } elseif (str_contains($value['unit_name_en'], 'Deputy Commissioner Office')) {
                    $court_id = DB::table('users')
                        ->select('court_id')
                        ->where('username', '=', $value['username'])
                        ->first();
                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                    } else {
                        $value['court_id'] = null;
                    }

                    array_push($list_of_ADC, $value);
                }
            }

            return json_encode([
                'list_of_ADC_flag' => 1,
                'list_of_ADC' => $list_of_ADC,
            ]);
        }
    }

    public static function verifyUNO($data)
    {
        if ($data[0]['office_id'] != globalUserInfo()->doptor_office_id) {
            //return $data;

            $list_of_UNO = [];

            foreach ($data as $value) {
                if (str_contains($value['designation_eng'], 'UNO Officer')) {

                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                        $value['role_id'] = $court_id->role_id;
                    } else {
                        $value['court_id'] = null;
                        $value['role_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                } else if (str_contains($value['designation_eng'], 'UNO')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                        $value['role_id'] = $court_id->role_id;
                    } else {
                        $value['court_id'] = null;
                        $value['role_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                } else if (str_contains($value['designation_eng'], 'Uno')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                        $value['role_id'] = $court_id->role_id;
                    } else {
                        $value['court_id'] = null;
                        $value['role_id'] = null;
                    }

                    array_push($list_of_UNO, $value);
                }
            }

            return json_encode([
                'list_of_UNO_flag' => 1,
                'list_of_UNO' => $list_of_UNO,
            ]);
        } else {
            $list_of_ADC = [];
            $list_of_others = [];
            foreach ($data as $value) {
                if (str_contains($value['designation_eng'], 'ADC')) {

                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();

                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                        $value['role_id'] = $court_id->role_id;
                    } else {
                        $value['court_id'] = null;
                        $value['role_id'] = null;
                    }
                    array_push($list_of_ADC, $value);
                } elseif (str_contains($value['designation_eng'], 'Additional Deputy Commissioner')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();
                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                        $value['role_id'] = $court_id->role_id;
                    } else {
                        $value['court_id'] = null;
                        $value['role_id'] = null;
                    }

                    array_push($list_of_ADC, $value);
                } elseif (str_contains($value['unit_name_en'], 'Deputy Commissioner Office')) {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();
                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                        $value['role_id'] = $court_id->role_id;
                    } else {
                        $value['court_id'] = null;
                        $value['role_id'] = null;
                    }

                    array_push($list_of_ADC, $value);
                } else {
                    $court_id = DB::table('users')
                        ->select('court_id', 'role_id')
                        ->where('username', '=', $value['username'])
                        ->first();
                    if (!empty($court_id)) {
                        $value['court_id'] = $court_id->court_id;
                        $value['role_id'] = $court_id->role_id;
                    } else {
                        $value['court_id'] = null;
                        $value['role_id'] = null;
                    }

                    array_push($list_of_others, $value);
                }
            }

            return json_encode([
                'list_of_DC_office_flag' => 1,
                'list_of_DC_office_users' => $list_of_others,
            ]);
        }
    }

    public static function courtlist_district()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court')->where('status', 1);
        $query->where('level', '=', 1);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')->where('status',1)
    }
    public static function gco_courtlist_district($office_id)
    {
        $office = DB::table('office')
            ->where('id', '=', $office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court');
        $query->where('status', '=', 2);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')->where('status',1)
    }
    public static function courtlist_district_dm_special()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court')->where('status', 1);
        $query->where('level', '=', 2);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->first();

        return $court;

        //$courtlist=DB::table('court')->where('status',1)
    }
    public static function courtlist_district_dm_adm()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court')->where('status', 1);
        $query->whereIN('level', [1, 2]);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')->where('status',1)
    }



    public static function courtlist_district_majistrate()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court')->where('status', 1);
        $query->where('level', '=', 2);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;
    }
    public static function courtlist_upazila()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        //district_id
        //status
        $query = DB::table('court')->where('status', 1);
        $query->where('level', '=', 0);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;
    }

    public static function courtlist_distrcit_all()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $query = DB::table('court')->where('status', 1);

        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;
    }

    public static function courtlist_distrcit_by_role()
    {
        $office = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $query = DB::table('court')->where('status', 1);
        $query->whereIn('level', [0, 1]);
        if (!empty($office->district_id)) {
            $query->where('district_id', '=', $office->district_id);
        }
        if (!empty($office->division_id)) {
            $query->where('division_id', '=', $office->division_id);
        }
        $court = $query->get();

        return $court;
    }

    public static function rolelist_district($user_role_arr = null)
    {
        return DB::table('role')->whereIn('id', [27, 28, 37, 38, 39])->get();
    }
    public static function rolelist_upazila()
    {
        return DB::table('role')->whereIn('id', [27, 28])->get();
    }

    public static function ADM_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {

            $role_id = 38;

            $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function ADM_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 38;

            $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $role_id = 38;
            $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function EM_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 37)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],

            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }

    public static function EM_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 37)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],

            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $role_id = 27;
            $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function EM_DC_Office_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {

            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function EM_DC_Office_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 27;

            $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $role_id = 27;
            $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function peshkar_dm_adm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {

            $role_id = 39;

            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (এ ডি এম) )';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'peshkar_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function peshkar_dm_adm_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {

            $role_id = 39;

            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (এ ডি এম))';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
            }
            $role_id = 39;
            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (এ ডি এম))';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function peshkar_em_dc_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {

            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম) )';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'peshkar_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function peshkar_em_dc_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {

            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম))';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
            }
            $role_id = 28;
            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম))';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function peshkar_em_uno_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 37)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {

            $role_id = 28;
            $designation = $user_info_from_request['designation_bng'] . '( পেশকার (ইএম) )';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
                'peshkar_active' => 1,
                'court_id' => $user_info_from_request['court_id'],
            ];
        }
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function peshkar_em_uno_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {

        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;

        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila = self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = $upazila->id;
        $upa_name_bn = $upazila->upazila_name_bn;
        $upa_name_en = $upazila->upazila_name_en;

        $parent_office_data = DB::table('users')
            ->select('office.id', 'office.office_name_bn')
            ->join('office', 'users.office_id', '=', 'office.id')
            ->where('users.role_id', '=', 37)
            ->where('office.district_id', '=', $district_id)
            ->where('office.division_id', '=', $division_id)
            ->whereNotNull('users.doptor_office_id')
            ->first();

        $office_label = 4;
        $parent = $parent_office_data->id;
        $parent_name = $parent_office_data->office_name_bn;
        $upazila_bbs_code = $upazila->upazila_bbs_code;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],

            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,

        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম) )';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['court_id'] == 0) {
                $doptor_user_active = 0;
                $peshkar_active = 0;
            } else {
                $doptor_user_active = 1;
                $peshkar_active = 1;
            }
            $role_id = 28;

            $designation = $user_info_from_request['designation_bng'] . '(পেশকার (ইএম) )';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'court_id' => $user_info_from_request['court_id'],
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => $peshkar_active,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }

    public static function ADC_DC_Office_Appeal_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $office_id = Self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {

            $role_id = 7;

            $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক (এডিসি))';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => 1,
            ];
        }
        /* appeal_id */

        $user_create = DB::table('users')->insertGetId($user);

        LogManagementRepository::assign_ADC($user_info_from_request['appeal_id'], $user);

        if ($user_create) {

            DB::table('em_appeals')->where('id', '=', $user_info_from_request['appeal_id'])
                ->update([
                    'is_assigned' => 1,
                    'assigned_adc_id' => $user_create,
                ]);

            return true;
        }
    }
    public static function ADC_DC_Office_Appeal_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        $upazila_id = null;
        $upa_name_bn = null;
        $upa_name_en = null;
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];

        $district = self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_division_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
        $upazila_bbs_code = null;
        $office_unit_organogram_id = null;

        $is_gcc = 0;
        $is_organization = 0;
        $status = 1;
        $is_dm_adm_em = 1;

        $office_data = [
            'level' => $office_label,
            'parent' => $parent,
            'parent_name' => $parent_name,
            'office_name_bn' => $office_info_from_request['office_name_bn'],
            'office_name_en' => $office_info_from_request['office_name_en'],
            'unit_name_bn' => $office_info_from_request['unit_name_bn'],
            'unit_name_en' => $office_info_from_request['unit_name_en'],
            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,

            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'division_id' => $division_id,
            'div_name_bn' => $div_name_bn,
            'div_name_en' => $div_name_en,
            'district_bbs_code' => $district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,

            'office_unit_organogram_id' => $office_unit_organogram_id,
            'is_gcc' => $is_gcc,
            'is_organization' => $is_organization,
            'status' => $status,
            'is_dm_adm_em' => $is_dm_adm_em,
        ];

        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 7;
            $doptor_user_active = 0;
            $is_assigned = 0;
            $assigned_adc_id = 0;

            $updated_users_id = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->first();

            $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক (এডিসি))';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            if ($user_info_from_request['appeal_id'] == 0) {
                $doptor_user_active = 0;
                $is_assigned = 0;
                $assigned_adc_id = 0;
            } else {
                $is_assigned = 1;
                $assigned_adc_id = $updated_users_id->id;
                $doptor_user_active = 1;
            }
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {

                if ($user_info_from_request['appeal_id'] == 0) {
                    LogManagementRepository::remove_assign_ADC($user_info_from_request['real_appeal_id_where_assign'], $user);
                } else {
                    LogManagementRepository::assign_ADC($user_info_from_request['real_appeal_id_where_assign'], $user);
                }

                DB::table('em_appeals')->where('id', '=', $user_info_from_request['real_appeal_id_where_assign'])
                    ->update([
                        'is_assigned' => $is_assigned,
                        'assigned_adc_id' => $assigned_adc_id,
                    ]);
                return true;
            }
        } elseif ($updated_office == 0) {

            $role_id = 7;

            $doptor_user_active = 0;
            $is_assigned = 0;
            $assigned_adc_id = 0;

            $updated_users_id = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->first();

            if ($user_info_from_request['appeal_id'] == 0) {
                $doptor_user_active = 0;
                $is_assigned = 0;
                $assigned_adc_id = 0;
            } else {
                $doptor_user_active = 1;
                $assigned_adc_id = $updated_users_id->id;
                $is_assigned = 1;
                $doptor_user_active = 1;
            }

            $role_id = 7;
            $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা প্রশাসক (এডিসি))';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $employee_info_from_api['personal_email'],
                'profile_image' => null,
                'email_verified_at' => null,
                'password' => $password,
                'profile_pic' => null,

                'citizen_id' => null,
                'designation' => $designation,
                'organization_id' => null,
                'remember_token' => null,
                'doptor_office_id' => $office_info_from_request['office_id'],
                'doptor_user_flag' => 1,
                'doptor_user_active' => $doptor_user_active,
                'peshkar_active' => 0,
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {

                if ($user_info_from_request['appeal_id'] == 0) {
                    LogManagementRepository::remove_assign_ADC($user_info_from_request['real_appeal_id_where_assign'], $user);
                } else {
                    LogManagementRepository::assign_ADC($user_info_from_request['real_appeal_id_where_assign'], $user);
                }

                DB::table('em_appeals')->where('id', '=', $user_info_from_request['real_appeal_id_where_assign'])
                    ->update([
                        'is_assigned' => $is_assigned,
                        'assigned_adc_id' => $assigned_adc_id,
                    ]);
                return true;
            }
        }
    }

    public static function getToken($username)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(DOPTOR_ENDPOINT() . '/api/client/login', [
                'client_id' => doptor_client_id(),
                'username' => $username,
                'password' => doptor_password(),
            ])
            ->throw()
            ->json();
    }
    public static function getAllOffice($token)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ])
            ->post(DOPTOR_ENDPOINT() . '/api/offices/relation-offices', [
                'office_ids' => globalUserInfo()->doptor_office_id,
                'type' => 'both',
            ])
            ->throw()
            ->json();
    }
    public static function get_employee_list_by_office($token, $office_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => DOPTOR_ENDPOINT() . '/api/get_employee_list_by_office/' . $office_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $token],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);



        return json_decode($response, true);
    }
    public static function current_desk($username)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(DOPTOR_ENDPOINT() . '/api/user/current_desk', [
                'username' => $username,
            ])
            ->throw()
            ->json();
    }
    public static function get_office_basic_info($token, $office_id)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ])
            ->post(DOPTOR_ENDPOINT() . '/api/offices', [
                'office_ids' => $office_id,
            ])
            ->throw()
            ->json();
    }


    public static function GcoOfficeExitsCheck($office_data)
    {

        $office_id = DB::table('office')
            ->where('level', '=', $office_data['level'])
            ->where('parent', '=', $office_data['parent'])
            ->where('parent_name', '=', $office_data['parent_name'])
            ->where('office_name_bn', '=', $office_data['office_name_bn'])
            ->where('office_name_en', '=', $office_data['office_name_en'])
            ->where('unit_name_bn', '=', $office_data['unit_name_bn'])
            ->where('unit_name_en', '=', $office_data['unit_name_en'])
            ->where('upazila_id', '=', $office_data['upazila_id'])
            ->where('upa_name_bn', '=', $office_data['upa_name_bn'])
            ->where('upa_name_en', '=', $office_data['upa_name_en'])
            ->where('district_id', '=', $office_data['district_id'])
            ->where('dis_name_bn', '=', $office_data['dis_name_bn'])
            ->where('dis_name_en', '=', $office_data['dis_name_en'])
            ->where('division_id', '=', $office_data['division_id'])
            ->where('div_name_bn', '=', $office_data['div_name_bn'])
            ->where('div_name_en', '=', $office_data['div_name_en'])
            ->where('district_bbs_code', '=', $office_data['district_bbs_code'])
            ->where('upazila_bbs_code', '=', $office_data['upazila_bbs_code'])
            ->where('office_unit_organogram_id', '=', $office_data['office_unit_organogram_id'])
            ->where('is_gcc', '=', $office_data['is_gcc'])
            ->where('is_organization', '=', $office_data['is_organization'])
            ->where('status', '=', $office_data['status'])
            ->first();

        if (empty($office_id)) {
            $office_id = DB::table('office')->insertGetId($office_data);

            return $office_id;
        } else {
            return $office_id->id;
        }
    }

    public static function OfficeExitsCheck($office_data)
    {

        $office_id = DB::table('office')
            ->where('level', '=', $office_data['level'])
            ->where('parent', '=', $office_data['parent'])
            ->where('parent_name', '=', $office_data['parent_name'])
            ->where('office_name_bn', '=', $office_data['office_name_bn'])
            ->where('office_name_en', '=', $office_data['office_name_en'])
            ->where('unit_name_bn', '=', $office_data['unit_name_bn'])
            ->where('unit_name_en', '=', $office_data['unit_name_en'])
            ->where('upazila_id', '=', $office_data['upazila_id'])
            ->where('upa_name_bn', '=', $office_data['upa_name_bn'])
            ->where('upa_name_en', '=', $office_data['upa_name_en'])
            ->where('district_id', '=', $office_data['district_id'])
            ->where('dis_name_bn', '=', $office_data['dis_name_bn'])
            ->where('dis_name_en', '=', $office_data['dis_name_en'])
            ->where('division_id', '=', $office_data['division_id'])
            ->where('div_name_bn', '=', $office_data['div_name_bn'])
            ->where('div_name_en', '=', $office_data['div_name_en'])
            ->where('district_bbs_code', '=', $office_data['district_bbs_code'])
            ->where('upazila_bbs_code', '=', $office_data['upazila_bbs_code'])
            ->where('office_unit_organogram_id', '=', $office_data['office_unit_organogram_id'])
            ->where('is_gcc', '=', $office_data['is_gcc'])
            ->where('is_organization', '=', $office_data['is_organization'])
            ->where('status', '=', $office_data['status'])
            // ->where('is_dm_adm_em', '=', $office_data['is_dm_adm_em'])
            ->first();

        if (empty($office_id)) {
            $office_id = DB::table('office')->insertGetId($office_data);

            return $office_id;
        } else {
            return $office_id->id;
        }
    }

    public static function signature()
    {
        // if(globalUserInfo()->doptor_user_flag == 1)
        // {
        //     $username=globalUserInfo()->username;
        //     $token=self::getToken($username);
        //     //dd($token) ;
        //     if($token['status'] == 'success')
        //     {
        //         $parse_token=$token['data']['token'];
        //         $signature= Http::withHeaders([
        //              'api-version' => 1,
        //              'Content-Type' => 'application/json',
        //              'Accept' => 'application/json',
        //              'Authorization' => "Bearer {$parse_token}",
        //          ])
        //              ->post(DOPTOR_ENDPOINT().'/api/user/signatures/', [
        //                  'usernames' => $username,
        //                  'encode' => 'base64',
        //              ])
        //              ->throw()
        //              ->json();

        //              //dd($signature);

        //              if($signature['status']=='success')
        //              {
        //                 DB::table('users')
        //                 ->where('username','=',$username)
        //                 ->update(['signature'=>$signature['data'][0]['signature']]);

        //              }
        //     }

        // }

        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
            $token = self::getToken($username);
            //dd($token) ;
            if ($token['status'] == 'success') {
                $parse_token = $token['data']['token'];
                $signature = Http::withHeaders([
                    'api-version' => 1,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$parse_token}",
                ])
                    ->post(DOPTOR_ENDPOINT() . '/api/user/signatures/', [
                        'usernames' => $username,
                        'encode' => '1',
                    ])
                    ->throw()
                    ->json();

                if ($signature['status'] == 'error') {
                    $signature_with_url = Http::withHeaders([
                        'api-version' => 1,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer {$parse_token}",
                    ])
                        ->post(DOPTOR_ENDPOINT() . '/api/user/signatures/', [
                            'usernames' => $username,
                            'encode' => 'base64',
                        ])
                        ->throw()
                        ->json();

                    //dd($signature);

                    if ($signature_with_url['status'] == 'success') {
                        DB::table('users')
                            ->where('username', '=', $username)
                            ->update(['signature' => $signature_with_url['data'][0]['signature']]);
                    }
                } else {
                    $doptor_image_photo = $signature['data'][0]['signature'];

                    if (!empty($doptor_image_photo)) {
                        $base64_str = substr($doptor_image_photo, strpos($doptor_image_photo, ',') + 1);

                        $extension = isset(explode('/', explode(';', $doptor_image_photo)[0])[1]) ? explode('/', explode(';', $doptor_image_photo)[0])[1] : explode('/', explode(';', $doptor_image_photo)[1])[1];

                        $image_data = base64_decode($base64_str); // decode the image

                        //dd($image_data);

                        $imageName = 'Doptor_' . $signature['data'][0]['username'] . '.' . $extension;
                        $upload_path = '/uploads/signature/';
                        file_put_contents(public_path() . $upload_path . $imageName, $image_data);
                        $singnature_path = '/uploads/signature/' . $imageName;

                        DB::table('users')
                            ->where('username', '=', $username)
                            ->update(['signature' => $singnature_path]);
                    }
                }
            }
        }
    }

    public static function profilePicture()
    {
        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
            $token = self::getToken($username);
            //dd($token) ;

            $currentdesk = self::current_desk($username);

            if ($currentdesk['status'] == 'success') {
                $employee_record_ids = $currentdesk['data']['employee_info']['id'];
            }

            if ($token['status'] == 'success') {
                $parse_token = $token['data']['token'];
                $profile_pic = Http::withHeaders([
                    'api-version' => 1,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$parse_token}",
                ])
                    ->post(DOPTOR_ENDPOINT() . '/api/user/images/', [
                        'employee_record_ids' => $employee_record_ids,
                        'encode' => 'base64',
                    ])
                    ->throw()
                    ->json();

                //dd($signature);

                if ($profile_pic['status'] == 'success') {
                    DB::table('users')
                        ->where('username', '=', $username)
                        ->update(['profile_pic' => $profile_pic['data'][0]['image']]);
                }
            }
        }
    }

    public static function all_user_list_from_doptor_segmented($data)
    {
        $list_of_all = [];
        // return $data;
        foreach ($data as $value) {

            $court_id = DB::table('users')
                ->select('court_id', 'role_id')
                ->where('username', '=', $value['username'])
                ->first();
            // return $court_id;
            if (!empty($court_id)) {
                $value['court_id'] = $court_id->court_id;
                $value['role_id'] = $court_id->role_id;
            } else {
                $value['court_id'] = null;
                $value['role_id'] = null;
            }
            array_push($list_of_all, $value);
        }

        return json_encode([
            'list_of_all' => $list_of_all,

        ]);
    }

    public static function gcc_all_user_list_from_doptor_segmented($data)
    {
        $list_of_all = [];
        // dd($court_type_id = $_POST['court_type_id'] ?? null);
        // $court_type_id = $_GET['court_type_id'];
        foreach ($data as $value) {
            $court_id = DB::table('users')
                ->select('id', 'doptor_user_active')
                ->where('username', '=', $value['username'])
                ->first();
            // dd($court_id, $_GET['court_type_id']);
            if (isset($court_id)) {
                $basic_user_info = DB::table('doptor_user_access_info')->where('user_id', $court_id->id)->where('court_type_id', 2)->first();
            } else {

                $basic_user_info = null;
            }

            // echo "<pre>";
            // print_r($court_id->id);

            //   dd($basic_user_info);
            if (!empty($basic_user_info)) {
                $value['court_id'] = $basic_user_info->court_id;
                $value['role_id'] = $basic_user_info->role_id;
                $value['court_type_id'] = $basic_user_info->court_type_id;
                $value['doptor_user_active'] = $court_id->doptor_user_active;
            } else {
                $value['court_id'] = null;
                $value['role_id'] = null;
                $value['court_type_id'] = null;
                $value['doptor_user_active'] = null;
            }
            array_push($list_of_all, $value);
        }

        return json_encode([
            'list_of_all' => $list_of_all,
        ]);
    }
    public static function emc_all_user_list_from_doptor_segmented($data)
    {
        $list_of_all = [];
        // dd($court_type_id = $_POST['court_type_id'] ?? null);
        // $court_type_id = $_GET['court_type_id'];
        foreach ($data as $value) {
            $court_id = DB::table('users')
                ->select('id', 'doptor_user_active')
                ->where('username', '=', $value['username'])
                ->first();
            // dd($court_id, $_GET['court_type_id']);
            if (isset($court_id)) {
                $basic_user_info = DB::table('doptor_user_access_info')->where('user_id', $court_id->id)->where('court_type_id', 3)->first();
            } else {

                $basic_user_info = null;
            }

            // echo "<pre>";
            // print_r($court_id->id);

            //   dd($basic_user_info);
            if (!empty($basic_user_info)) {
                $value['court_id'] = $basic_user_info->court_id;
                $value['role_id'] = $basic_user_info->role_id;
                $value['court_type_id'] = $basic_user_info->court_type_id;
                $value['doptor_user_active'] = $court_id->doptor_user_active;
            } else {
                $value['court_id'] = null;
                $value['role_id'] = null;
                $value['court_type_id'] = null;
                $value['doptor_user_active'] = null;
            }
            array_push($list_of_all, $value);
        }

        return json_encode([
            'list_of_all' => $list_of_all,
        ]);
    }

    public static function all_user_list_from_doptor_for_adc($data, $appeal_id)
    {
        $list_of_all = [];

        foreach ($data as $value) {

            $court_id = DB::table('users')
                ->select('court_id', 'role_id')
                ->where('username', '=', $value['username'])
                ->first();

            if (!empty($court_id)) {
                $value['court_id'] = $court_id->court_id;
                $value['role_id'] = $court_id->role_id;
            } else {
                $value['court_id'] = null;
                $value['role_id'] = null;
            }
            $appeal_data = DB::table('users')
                ->join('em_appeals', 'users.id', '=', 'em_appeals.assigned_adc_id')
                ->where('em_appeals.is_assigned', '=', 1)
                ->where('users.username', '=', $value['username'])
                ->where('em_appeals.id', '=', $appeal_id)
                ->select('users.username', 'em_appeals.id')
                ->first();
            if (!empty($appeal_data)) {
                $value['appeal_id'] = $appeal_data->id;
            } else {
                $value['appeal_id'] = null;
            }
            array_push($list_of_all, $value);
        }

        return json_encode([
            'list_of_all' => $list_of_all,

        ]);
    }

    public static function get_district_from_geo_distcrict_with_district($geo_district_id)
    {

        $query = DB::table('district')
            ->join('geo_districts', 'district.district_bbs_code', '=', 'geo_districts.bbs_code')
            ->where('geo_districts.id', '=', $geo_district_id)
            ->select('district.id', 'geo_districts.district_name_bng', 'district.district_name_en', 'district.district_bbs_code', 'district.district_name_bn')
            ->first();

        return $query;
    }

    public static function get_division_from_geo_division_with_division($geo_division_id)
    {
        $query = DB::table('division')
            ->join('geo_divisions', 'division.division_bbs_code', '=', 'geo_divisions.bbs_code')
            ->where('geo_divisions.id', '=', $geo_division_id)
            ->select('division.id', 'geo_divisions.division_name_bng', 'division.division_name_en', 'division.division_name_bn')
            ->first();

        return $query;
    }
    public static function get_upazila_from_geo_upazila_with_upazila($geo_upazila_id)
    {
        $geo_upazila = DB::table('geo_upazilas')->where('id', '=', $geo_upazila_id)->first();

        $district = self::get_district_from_geo_distcrict_with_district($geo_upazila->geo_district_id);
        $division = self::get_division_from_geo_division_with_division($geo_upazila->geo_division_id);

        $upazila = DB::table('upazila')
            ->where('upazila_name_en', '=', $geo_upazila->upazila_name_eng)
            ->where('district_id', '=', $district->id)
            ->where('division_id', '=', $division->id)
            ->first();

        return $upazila;
    }

    public static function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null)
    {
        // This function will search the revisions for a certain value
        // related to the associative key you are looking for.
        $keys = array();
        foreach ($dataArray as $key => $cur_value) {
            if (str_contains($cur_value[$key_to_search], $search_value)) {
                if (isset($other_matching_key) && isset($other_matching_value)) {
                    if ($cur_value[$other_matching_key] == $other_matching_value) {
                        $keys[] = $key;
                    }
                } else {
                    // I must keep in mind that some searches may have multiple
                    // matches and others would not, so leave it open with no continues.
                    $keys[] = $key;
                }
            }
        }

        return $keys;
    }

    public static function getAllOfficeBangladesh($token, $lavel)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
        ])
            ->post(DOPTOR_ENDPOINT() . '/api/offices/relation-offices', [
                'office_ids' => $lavel,
                'type' => 'both',
            ])
            ->throw()
            ->json();
    }
    public static function verifyDoptorUser($username, $password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => DOPTOR_ENDPOINT() . '/api/user/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['username' => $username, 'password' => $password],
            CURLOPT_HTTPHEADER => ['api-version: 1'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
    public static function verifyCurrentDesk($username)
    {
        if (empty($username)) {
            return ['status' => false, 'role_id' => null];
        } else {
            $data = self::current_desk($username);
            if ($data['status'] != "success") {
                return ['status' => false, 'role_id' => null, 'level' => null];
            } else { //doptor_office_id

                $find_by_username = DB::table('users')->where('username', $username)->first();
                if (!empty($find_by_username)) {
                    if ($find_by_username->doptor_office_id != $data['data']['office_info'][0]['office_id']) {
                        if ($find_by_username->role_id != 28) {
                            return ['status' => true, 'role_id' => $find_by_username->role_id, 'level' => null];
                        } else {
                            $office = DB::table('office')->where('id', '=', $find_by_username->office_id)->first();

                            return ['status' => true, 'role_id' => $find_by_username->role_id, 'level' => $office->level];
                        }
                    } else {
                        return ['status' => false, 'role_id' => null, 'level' => null];
                    }
                } else {
                    return ['status' => false, 'role_id' => null, 'level' => null];
                }
            }
        }
    }
}
