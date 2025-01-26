<?php

namespace App\Repositories;

use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Traits\TokenVerificationTrait;

class NDoptorRepositoryAdmin
{
    use TokenVerificationTrait;
    public static function getToken($username)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(DOPTOR_ENDPOINT().'/api/client/login', [
                'client_id' => doptor_client_id(),
                'username' => $username,
                'password' => doptor_password(),
            ])
            ->throw()
            ->json();
    }

    //create doptor office tabel
    public static function get_list_of_office($token, $office_id)
    {
        $token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE3MzMxMTUxMzUsImp0aSI6Ik1UY3pNekV4TlRFek5RPT0iLCJpc3MiOiJodHRwczpcL1wvbi1kb3B0b3ItYXBpLm5vdGhpLmdvdi5iZFwvIiwibmJmIjoxNzMzMTE1MTM1LCJleHAiOjE3MzMyMDE1MzUsImRhdGEiOiJ7XCJjbGllbnRfbmFtZVwiOlwiU21hcnQgR2VuZXJhbCBDZXJ0aWZpY2F0ZSBjb3VydFwiLFwidXNlcm5hbWVcIjpcIjIwMDAwMDAwODk1MFwifSJ9.4Cto6kkBngjBbHPyo5JoJrXA6_rjP7fNldX_53lNY-ogw8wKHGTYRM68oNpzO8iixPndehaH6g7MDujp8fNEQg';
        // dd(DOPTOR_ENDPOINT() . '/api/custom-layer-level');
        $curl = curl_init();
      
       
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://n-doptor-api.nothi.gov.bd/api/office-origins',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $token],
        ]);
        
        $response = curl_exec($curl);
        // dd($token, $office_id, $response);

  
        curl_close($curl);

        return json_decode($response, true);
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
        // dd($token, $office_id, $response);

  
        curl_close($curl);

        return json_decode($response, true);
    }
    public static function all_user_list_from_doptor_segmented($data)
    {
        $list_of_all = [];
   
        // dd($court_type_id = $_POST['court_type_id'] ?? null);
        $court_type_id=$_GET['court_type_id'];
        foreach ($data as $value) {
            $court_id = DB::table('users')
                ->select('id', 'doptor_user_active')
                ->where('username', '=', $value['username'])
                ->first();  
            if(isset($court_id)) {
                $basic_user_info = DB::table('doptor_user_access_info')->where('user_id', $court_id->id)->where('court_type_id', $court_type_id)->first();
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

    public static function all_user_list_from_doptor_segmented_search($data)
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
            array_push($list_of_all, $value);
        }

        //dd($list_of_others);

        return json_encode([
            'list_of_all' => $list_of_all,
        ]);
    }

    public static function rolelist_district()
    {
       
        return DB::table('gcc_role')
                ->whereIn('id', [6,7,9,10,11,12,27,28])->orderBy('id', 'ASC')
                ->get();
    }

    public static function emc_rolelist_district()
    {
        return DB::table('emc_role')
                ->whereIn('id', [27,28,37,38,39])
                ->get();
    }

    public static function mc_rolelist_district()
    {
        return DB::table('mc_role')
                ->whereIn('id', [25,26,27,37,38])
                ->get();
    }

    public static function gcc_rolelist_upa()
    {
       
        return DB::table('gcc_role')
                ->whereIn('id', [27,28])->orderBy('id', 'ASC')
                ->get();
    }

    public static function emc_rolelist_upa()
    {
        return DB::table('emc_role')
                ->whereIn('id', [27,28])
                ->get();
    }

    public static function mc_rolelist_upa()
    {
        return DB::table('mc_role')
                ->whereIn('id', [25,26])
                ->get();
        
    }

    public static function rolelist_upazila()
    {
        return DB::table('role')
            ->whereIn('id', [27, 28])
            ->get();
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

    public static function gcc_courtlist_district_all($district_id,$division_id)
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

    public static function mc_courtlist_distrcit_all($district_id,$division_id)
    {
        $query = DB::table('mobile_court');

        $query->where('level', '=', 0);
        if (!empty($district_id)) {
            $query->where('district_id', '=', '100');
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', '100');
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')
    }

    

    public static function district_majistrate_court($district_id,$division_id)
    {
        $query = DB::table('court')->where('status',1);
        $query->where('level', '=', 2);
        if (!empty($district_id)) {
            $query->where('district_id', '=', $district_id);
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', $division_id);
        }
        $court = $query->get();

        return $court;

        //$courtlist=DB::table('court')->where('status',1)
    }


    public static function courtlist_upazila($district_id,$division_id)
    {
        $query = DB::table('court')->where('status',1);

        $query->where('level', '=', 0);
        if (!empty($district_id)) {
            $query->where('district_id', '=', $district_id);
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', $division_id);
        }
        $court = $query->get();

        return $court;

        
    }
    public static function courtlist_distrcit_all($district_id,$division_id)
    {
        $query = DB::table('court')->where('status',1);

       
        if (!empty($district_id)) {
            $query->where('district_id', '=', $district_id);
        }
        if (!empty($division_id)) {
            $query->where('division_id', '=', $division_id);
        }
        $court = $query->get();

        return $court;


    }
    public static function rolelist_division()
    {
        return DB::table('role')
            ->where('id', '=', 34)
            ->get();
    }
    public static function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null)
    {
        // This function will search the revisions for a certain value
        // related to the associative key you are looking for.
        $keys = [];
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
    public static function current_desk($username)
    {
        return Http::withHeaders([
            'api-version' => 1,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->post(DOPTOR_ENDPOINT().'/api/user/current_desk', [
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
            ->post(DOPTOR_ENDPOINT().'/api/offices', [
                'office_ids' => $office_id,
            ])
            ->throw()
            ->json();
    }

    public static function OfficeExitsCheck($office_data)
    {
        
         $office_id=DB::table('office')
                    ->where('level','=',$office_data['level'])
                    ->where('parent','=',$office_data['parent'])
                     ->where('parent_name','=',$office_data['parent_name'])
                     ->where('office_name_bn','=',$office_data['office_name_bn'])
                     ->where('office_name_en','=',$office_data['office_name_en'])
                     ->where('unit_name_bn','=',$office_data['unit_name_bn'])
                     ->where('unit_name_en','=',$office_data['unit_name_en'])
                     ->where('upazila_id','=',$office_data['upazila_id'])
                     ->where('upa_name_bn','=',$office_data['upa_name_bn'])
                     ->where('upa_name_en','=',$office_data['upa_name_en'])
                     ->where('district_id','=',$office_data['district_id'])
                     ->where('dis_name_bn','=',$office_data['dis_name_bn'])
                     ->where('dis_name_en','=',$office_data['dis_name_en'])
                     ->where('division_id','=',$office_data['division_id'])
                     ->where('div_name_bn','=',$office_data['div_name_bn'])
                     ->where('div_name_en','=',$office_data['div_name_en'])
                     ->where('district_bbs_code','=',$office_data['district_bbs_code'])
                     ->where('upazila_bbs_code','=',$office_data['upazila_bbs_code'])
                     ->where('office_unit_organogram_id','=',$office_data['office_unit_organogram_id'])
                     ->where('is_gcc','=',$office_data['is_gcc'])
                     ->where('is_organization','=',$office_data['is_organization'])
                     ->where('status','=',$office_data['status'])
                    //  ->where('is_dm_adm_em','=',$office_data['is_dm_adm_em'])
                     ->first();

         if(empty($office_id))
         {
            $office_id = DB::table('office')->insertGetId($office_data);

            return $office_id;
         }
         else
         {
            return $office_id->id;
         }            
    }
   

    public static function get_district_from_geo_distcrict_with_district($geo_district_id)
    {
       
        $query = DB::table('district')
            ->join('geo_districts', 'district.district_bbs_code', '=', 'geo_districts.bbs_code')
            ->where('geo_districts.id', '=', $geo_district_id)
            ->select('district.id', 'geo_districts.district_name_bng','district.district_name_en','district.district_bbs_code','district.district_name_bn')
            ->first();
          
        return $query;
    }

    public static function get_division_from_geo_division_with_division($geo_division_id)
    {
        $query = DB::table('division')
            ->join('geo_divisions', 'division.division_bbs_code', '=', 'geo_divisions.bbs_code')
            ->where('geo_divisions.id', '=', $geo_division_id)
            ->select('division.id', 'geo_divisions.division_name_bng','division.division_name_en','division.division_name_bn')
            ->first();

        return $query;
    }

    public static function get_upazila_from_geo_upazila_with_upazila_new($geo_upazila_id)
    {
        $query = DB::table('upazila')
            ->join('geo_upazilas', 'upazila.upazila_bbs_code', '=', 'geo_upazilas.bbs_code')
            ->where('geo_upazilas.id', '=', $geo_upazila_id)
            ->select('upazila.id', 'geo_upazila.upazila_name_bng','upazila.upazila_name_en','upazila.upazila_name_bn')
            ->first();

        return $query;
    }
    
    public static function get_upazila_from_geo_upazila_with_upazila($geo_upazila_id)
    {
        if($geo_upazila_id == 0)
        {
            return null;
        }
       $geo_upazila=DB::table('geo_upazilas')->where('id','=',$geo_upazila_id)->first();

       

       $district=self::get_district_from_geo_distcrict_with_district($geo_upazila->geo_district_id);
       $division=self::get_division_from_geo_division_with_division($geo_upazila->geo_division_id);

       $upazila=DB::table('upazila')
       ->where('upazila_name_en','=',$geo_upazila->upazila_name_eng)
       ->where('district_id','=',$district->id)
       ->where('division_id','=',$division->id)
       ->first();

       return $upazila;

    }

    //divisional commissioner for all court
    public static function Div_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];

        $division_from_geo = DB::table('geo_divisions')
            ->where('id', '=', $geo_division_id)
            ->first();

        $division = DB::table('division')
            ->where('division_bbs_code', $division_from_geo->bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $office_label = 2;
        $parent = null;
        $parent_name = null;

        $office_unit_organogram_id = 533;

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
            'district_id' => null,
            'dis_name_bn' => null,
            'dis_name_en' => null,
            'district_bbs_code' => null,
            'upazila_bbs_code' => null,
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        if (isset($office_id)) {
            $role_id = 34;

            $designation = $user_info_from_request['designation_bng'] . '(বিভাগীয় কমিশনার)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $email,
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
        $user_create = DB::table('users')->insert($user);

        if ($user_create) {
            return true;
        }
    }
    public static function Div_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];

        $division_from_geo = DB::table('geo_divisions')
            ->where('id', '=', $geo_division_id)
            ->first();

        $division = DB::table('division')
            ->where('division_bbs_code', $division_from_geo->bbs_code)
            ->first();

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $office_label = 2;
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
            'district_id' => null,
            'dis_name_bn' => null,
            'dis_name_en' => null,
            'district_bbs_code' => null,
            'upazila_bbs_code' => null,
        ];
        $to_update_office_id = DB::table('users')
            ->where('username', '=', $user_info_from_request['username'])
            ->first();

        $updated_office = DB::table('office')
            ->where('id', '=', $to_update_office_id->office_id)
            ->update($office_data);

        if ($updated_office == 1) {
            $role_id = 34;

            $designation = $user_info_from_request['designation_bng'] . '(বিভাগীয় কমিশনার)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');

            //dd($office_id->id);
            if ($user_info_from_request['role_id'] == 0) {
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
                'email' => $email,
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
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        } elseif ($updated_office == 0) {
            if ($user_info_from_request['role_id'] == 0) {
                $doptor_user_active = 0;
            } else {
                $doptor_user_active = 1;
            }

            $role_id = 34;

            $designation = $user_info_from_request['designation_bng'] . '(বিভাগীয় কমিশনার)';
            $password = Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C');
            $user = [
                'name' => $user_info_from_request['employee_name_bng'],
                'username' => $user_info_from_request['username'],
                'role_id' => $role_id,
                'office_id' => $to_update_office_id->office_id,
                'mobile_no' => $employee_info_from_api['personal_mobile'],
                'email' => $email,
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
            ];

            $updated_users = DB::table('users')
                ->where('username', '=', $user_info_from_request['username'])
                ->update($user);

            if ($updated_users) {
                return true;
            }
        }
    }


    //gcc court user management


    public static function GCO_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        // dd($email);
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

    public static function GCO_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
                    'peshkar_active'=>0
                ];
            //    dd($user);
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

    public static function certificate_assistent_DC_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
                    'peshkar_active'=>1,
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
    public static function certificate_assistent_DC_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        
        if ($employee_info_from_api['personal_email']=='') {
        
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
               
                
                
                
                DB::beginTransaction();
                try {
                    $role_id = 28;

                    $designation = $user_info_from_request['designation_bng'] . '(সার্টিফিকেট সহকারি)';
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
                
            }

       
 
    }

    public static function Gcc_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
        ];

        $office_id = self::OfficeExitsCheck($office_data);
        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 6;

                $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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

    public static function Gcc_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
                    $role_id = 6;
    
                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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
                    $role_id = 6;
    
                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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

    public static function Gcc_pasker_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
        ];

        $office_id = self::OfficeExitsCheck($office_data);
        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 9;

                $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক (পেশকার))';
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

    public static function Gcc_pasker_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
                    $role_id = 9;
    
                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক (পেশকার))';
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
                    $role_id = 9;
    
                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক (পেশকার))';
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


    public static function Ad_Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
   
    
    public static function Ad_Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

    public static function Ad_Dis_Commissioner_pasker_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 10;

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
   
    
    public static function Ad_Dis_Commissioner_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
                    $role_id = 10;

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
                    $role_id = 10;

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

    public static function deputy_collector_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 11;

                $designation = $user_info_from_request['designation_bng'] . '(রেকর্ডরুম ডেপুটি কালেক্টর)';
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

    public static function deputy_collector_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
                    $role_id = 11;

                    $designation = $user_info_from_request['designation_bng'] . '(রেকর্ডরুম ডেপুটি কালেক্টর)';
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
                    $role_id = 11;

                    $designation = $user_info_from_request['designation_bng'] . '(রেকর্ডরুম ডেপুটি কালেক্টর)';
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

    public static function record_keeper_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
        ];

        $office_id = self::OfficeExitsCheck($office_data);

        DB::beginTransaction();
        try {
            if (isset($office_id)) {

                $role_id = 12;

                $designation = $user_info_from_request['designation_bng'] . '(রেকর্ড কিপার)';
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
    
    public static function record_keeper_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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
                    $role_id = 12;

                    $designation = $user_info_from_request['designation_bng'] . '(রেকর্ড কিপার)';
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
                    $role_id = 12;

                    $designation = $user_info_from_request['designation_bng'] . '(রেকর্ড কিপার)';
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


    //emc court user management

    public static function emc_dm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                $role_id = 37;

                $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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

    public static function emc_dm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                    $role_id = 37;

                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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
                    
                    $role_id = 37;

                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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


    //mobile court
    public static function mc_dm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                $role_id = 37;

                $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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

    public static function mc_dm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                    $role_id = 37;

                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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
                    
                    $role_id = 37;

                    $designation = $user_info_from_request['designation_bng'] . '(জেলা প্রশাসক)';
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

    public static function mc_adm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                $role_id = 38;

                $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)';
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

    public static function mc_adm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                    $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)';
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

                    $designation = $user_info_from_request['designation_bng'] . '(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)';
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

    public static function mc_acgm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                $designation = $user_info_from_request['designation_bng'] . '(এসিজিএম)';
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

    public static function mc_acgm_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
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

                    $designation = $user_info_from_request['designation_bng'] . '(এসিজিএম)';
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
                    
                    $role_id = 27;

                    $designation = $user_info_from_request['designation_bng'] . '(এসিজিএম)';
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

    public static function mc_em_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }

        
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];
        // dd($geo_upazila_id);
        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);


        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = isset($upazila) ? $upazila->id : null;
        $upa_name_bn = isset($upazila) ? $upazila->upazila_name_bn : null;
        $upa_name_en = isset($upazila) ? $upazila->upazila_name_en : null;
        $upazila_bbs_code = isset($upazila) ? $upazila->upazila_bbs_code : null;
        // dd($upa_name_bn);
        $office_label = 3;
        $parent = null;
        $parent_name = null;
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

                $role_id = 26;

                $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
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

    public static function mc_em_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];

        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = isset($upazila) ? $upazila->id : null;
        $upa_name_bn = isset($upazila) ? $upazila->upazila_name_bn : null;
        $upa_name_en = isset($upazila) ? $upazila->upazila_name_en : null;
        $upazila_bbs_code = isset($upazila) ? $upazila->upazila_bbs_code : null;

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

            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,
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

                    $role_id = 26;

                    $designation = $user_info_from_request['designation_bng'] . '(এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
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
                    
                    $role_id = 26;

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

    public static function mc_pasker_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {
            # code...
            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];


        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);

        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = isset($upazila) ? $upazila->id : null;
        $upa_name_bn = isset($upazila) ? $upazila->upazila_name_bn : null;
        $upa_name_en = isset($upazila) ? $upazila->upazila_name_en : null;
        $upazila_bbs_code = isset($upazila) ? $upazila->upazila_bbs_code : null;

        $office_label = 3;
        $parent = null;
        $parent_name = null;
      
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

                $role_id = 25;

                $designation = $user_info_from_request['designation_bng'] . '(প্রসিকিউটর)';
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

    public static function mc_pasker_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info)
    {
        if ($employee_info_from_api['personal_email']=='') {

            $email=null;
        }else {
            $email=$employee_info_from_api['personal_email'];
        }
        $geo_division_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_division_id'];
        $geo_district_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_district_id'];
        $geo_upazila_id = $get_office_basic_info['data'][$office_info_from_request['office_id']]['geo_upazila_id'];
        
        $district=self::get_district_from_geo_distcrict_with_district($geo_district_id);
        $division=self::get_division_from_geo_division_with_division($geo_division_id);
        $upazila=self::get_upazila_from_geo_upazila_with_upazila($geo_upazila_id);
        
        $division_id = $division->id;
        $div_name_bn = $division->division_name_bn;
        $div_name_en = $division->division_name_en;

        $dis_name_bn = $district->district_name_bn;
        $district_id = $district->id;
        $dis_name_en = $district->district_name_en;
        $district_bbs_code = $district->district_bbs_code;

        $upazila_id = isset($upazila) ? $upazila->id : null;
        $upa_name_bn = isset($upazila) ? $upazila->upazila_name_bn : null;
        $upa_name_en = isset($upazila) ? $upazila->upazila_name_en : null;
        $upazila_bbs_code = isset($upazila) ? $upazila->upazila_bbs_code : null;
        
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

            'upazila_id' => $upazila_id,
            'upa_name_bn' => $upa_name_bn,
            'upa_name_en' => $upa_name_en,
            'district_id' => $district_id,
            'dis_name_bn' => $dis_name_bn,
            'dis_name_en' => $dis_name_en,
            'district_bbs_code' =>$district_bbs_code,
            'upazila_bbs_code' => $upazila_bbs_code,
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

                    $role_id = 25;

                    $designation = $user_info_from_request['designation_bng'] . '(প্রসিকিউটর)';
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
                    
                    $role_id = 25;

                    $designation = $user_info_from_request['designation_bng'] . '(প্রসিকিউটর)';
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


}
