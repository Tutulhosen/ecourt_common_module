<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CitizenNIDVerifyRepository
{
    public static function verify_citizen_by_nid($requestInfo, $citizen_type_id)
    {
        $data = [
            'citizen_name' => $requestInfo->name,
            'citizen_type_id' =>$citizen_type_id,
            'citizen_phone_no' => globalUserInfo()->mobile_no,
            'citizen_NID' => $requestInfo->citizen_nid,
            'citizen_gender' => $requestInfo->citizen_gender,
            'present_address' => $requestInfo->presentAddress,
            'permanent_address' => $requestInfo->permanentAddress,
            'dob' => str_replace('/', '-', $requestInfo->dob),
            'email' => globalUserInfo()->email,
            'father' => $requestInfo->father,
            'mother' => $requestInfo->mother,
            'designation'=>globalUserInfo()->designation,
            'organization_id'=>globalUserInfo()->organization_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by'=>globalUserInfo()->id
        ];
        $nid_exits = DB::table('ecourt_citizens')
            ->where('citizen_NID', $requestInfo->citizen_nid)
            ->where('citizen_type_id', $citizen_type_id)
            ->first();

        if (!empty($nid_exits)) {
            DB::table('ecourt_citizens')
                ->where('citizen_NID', $requestInfo->citizen_nid)
                ->where('citizen_type_id', $citizen_type_id)
                ->update($data);
            $ID = $nid_exits->id;
        } else {
            $ID = DB::table('ecourt_citizens')->insertGetId($data);
        }

        User::where('id', globalUserInfo()->id)->update(
            [
                'citizen_id' => $ID,
                'is_verified_account'=>1,
                'name'=>$requestInfo->name,
                'citizen_nid'=>$requestInfo->citizen_nid,
                'updated_at'=>date('Y-m-d H:i:s')
           ]);

    }
    public static function getAdditionalInfoFromCitizen($requestInfo)
    {
        $exit_citizen = DB::table('ecourt_citizens')->where('citizen_NID', $requestInfo->nid_number)->first();
        
        //dd($exit_citizen->email);
        if (!empty($exit_citizen)) {
           
            $data['email']=$exit_citizen->email;
            $data['designation']=$exit_citizen->designation;
            $data['organization']=$exit_citizen->organization;
            $data['organization_id']=$exit_citizen->organization_id;
           
        }else{
            $data['email']=null;
            $data['designation']=null;
            $data['organization']=null;
            $data['organization_id']=null;
        }

       return $data;
    }

}
