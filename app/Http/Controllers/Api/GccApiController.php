<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;

class GccApiController extends BaseController
{
    //store organization
    public function organization_store(Request $request){
        $data_get = $request->getContent();
        $json_data = json_decode($data_get, true);
        $data= $json_data['body_data'];


        $office['level']=4;
        $office['parent']=$data['parent'];
        $office['parent_name']=$data['parent_name'];
        $office['office_name_bn']=$data['office_name_bn'];
        $office['office_name_en']=$data['office_name_en'];
        $office['division_id']=$data['division_id'];
        $office['district_id']=$data['district_id'];
        $office['upazila_id']=$data['upazila_id'];
        $office['organization_type']=$data['organization_type'];
        $office['organization_physical_address']=$data['organization_physical_address'];
        $office['organization_routing_id']=$data['organization_routing_id'];
        $office['is_organization']=$data['is_organization'];
        $office['is_varified_org']=$data['is_varified_org'];

        // $office_id=45965;
        $office_id=DB::table('office')->insertGetId($office);
        if($office_id)
        {
            return $this->sendResponse($office_id, 'প্রতিষ্ঠান সঠিকভাবে যুক্ত হয়েছে');
      
        }
    }

    //update organization
    public function organization_update(Request $request){
        $data_get = $request->getContent();
        $json_data = json_decode($data_get, true);
        $data= $json_data['body_data'];
       

        
        $office['parent']=$data['parent'];
        $office['parent_name']=$data['parent_name'];
        $office['office_name_bn']=$data['office_name_bn'];
        $office['office_name_en']=$data['office_name_en'];
        $office['organization_type']=$data['organization_type'];
        $office['organization_physical_address']=$data['organization_physical_address'];
        $office['organization_routing_id']=$data['organization_routing_id'];
        $office['is_organization']=$data['is_organization'];
        $office['is_varified_org']=$data['is_varified_org'];
        $office_id_for_update=$data['office_id'];
 

        $office_id=DB::table('office')->where([
            'id'=>$office_id_for_update
        ])->update($office);
     
        if($office_id==0 || $office_id==1)
        {
            return $this->sendResponse(null, 'প্রতিষ্ঠান সঠিকভাবে আপডেট হয়েছে');
      
        }
    }

    public static function pass_user_data_for_gcc_court(Request $request)
    {
        // return 'from common';
        $data_get = $request->getContent();
        $json_data = json_decode($data_get, true);
        $datas = $json_data['body_data'];
        return $datas;
        $list_of_UNO = [];
        $list_of_GCO_DC_office = [];
        $list_of_others = [];

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
                array_push($list_of_others, $value);
            
        }

        //dd($list_of_others);

        return json_encode([
            'list_of_UNO' => $list_of_UNO,
            'list_of_GCO_DC_office' => $list_of_GCO_DC_office,
            'list_of_others' => $list_of_others,

        ]);

    }

    public static function certificate_copy_payment_data(Request $request)
    {
        // return 'from common';
        $data_get = $request->getContent();
        $json_data = json_decode($data_get, true);
        $datas = $json_data['body_data'];
        $appeal_id=$datas['appeal_id'];
        $total_page=$datas['total_page'];
        $cost_total=$datas['cost_total'];

        db::table('certify_copy')->where('appeal_id',$appeal_id)->update([
            'total_page' => $total_page,
            'cost_total' => $cost_total,
            'certify_copy_fee' => 'REQUEST_FOR_FEE',
        ]);


    }
}
