<?php

namespace App\Http\Controllers\AppsApi;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;

class EmcCitizenController extends BaseController
{
    //citizen appeal create
    public function emc_citizen_appeal_create()
    {
  
        $user = globalUserInfo();
         
        $citizen_info = DB::table('ecourt_citizens')
                  ->where('id', '=', $user->citizen_id)
                  ->where('citizen_type_id', $user->citizen_type_id)
                  ->first();
        
          $office_id = $user->office_id;
          $roleID = $user->role_id;
          $officeInfo = user_office_info();
          $divisions = DB::table('division')
              ->select('division.*')
              ->get();
        if ($user->office_id) {
             $gcoList = User::where('office_id', $user->office_id)
              ->where('id', '!=', $user->id)
              ->get();
        }else {
             $gcoList=null;
        }
         
    
          $appealId = null;
          $laws = DB::table('crpc_sections')
              ->select('crpc_sections.*')
              ->where('status', 1)
              ->get();
          $law_details = DB::table('crpc_section_details')
              ->select('crpc_section_details.*')
              ->get();
          if (globalUserInfo()->is_cdap_user == 1) {
              $mobile_int_2_str = (string) globalUserInfo()->mobile_no;
    
              $mobile_number_reshaped = '0' . $mobile_int_2_str;
          } else {
              $mobile_number_reshaped = globalUserInfo()->mobile_no;
          }
    
          
          $data = [
              'divisionId' => $divisions,
              'office_id' => $office_id,
              'appealId' => $appealId,
              'gcoList' => $gcoList,
              'lawSections' => $laws,
              'law_details' => $law_details,
              'office_name' => $officeInfo->office_name_bn,
              'applicant_name' => $user->name,
              'citizen_gender' => isset($citizen_info->citizen_gender) ? $citizen_info->citizen_gender : null,
              'father' => isset($citizen_info->father) ? $citizen_info->father :null,
              'mother' => isset($citizen_info->mother) ? $citizen_info->mother :null,
              'present_address' => isset($citizen_info->present_address) ? $citizen_info->present_address :null,
              'mobile_number_reshaped' => globalUserInfo()->mobile_no,
              'citizen_id'=>globalUserInfo()->citizen_id,
              "email"=>(!empty($citizen_info->email)?$citizen_info->email:null),
              "citizen_NID"=>$citizen_info->citizen_NID
          ];

          return $this->sendResponse($data, 'citizen appeal create');
    }

    
}
