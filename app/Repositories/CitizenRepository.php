<?php

namespace App\Repositories;


use App\Models\Appeal;
use App\Models\EmAppealCitizen;
use App\Models\EcourtCitizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CitizenRepository
{
    public static function storeCitizen($appealInfo){
       
        $user = globalUserInfo();
        $data['defaulter'] = $appealInfo->defaulter;
        $data['applicants'] = $appealInfo->applicant;
        $data['user']=$user;
        $data['user_office_info']= user_office_info();
        
        return $data;

    }

    public static function storeCtgFromEmc($appealInfo,$appealId){
     
        $user = globalUserInfo();
        $data['victim']=null;
        if (isset($appealInfo->lawyer)) {
           $citizenList['lawyer'] = $appealInfo->lawyer;
           $data['lawyer']=$citizenList['lawyer'];
        }
        // dd($user);
        if($appealInfo->caseEntryType == 'others'){
            // dd(1);
            $citizenList['applicants'] = $appealInfo->applicant;
            $data['applicants']=$citizenList['applicants'];
        }
        if($appealInfo->lawSection == 1){
            $citizenList['victim'] = $appealInfo->victim;
            $data['victim']=$citizenList['victim'];
        }
        
        // $citizenList['defaulter'] = $appealInfo->defaulter;
        $multiCtz['defaulter'] = $appealInfo->defaulter;
        $multiCtz['witness'] = $appealInfo->witness;
        $data['defaulter']=$appealInfo->defaulter;
        $data['witness']=$appealInfo->witness;
        function storeCtgs_new($appealId, $reqCitizen){
            $user = globalUserInfo();
            $citizen = CitizenRepository::checkCitizenExist($reqCitizen['phn'],$reqCitizen['nid']);
           

            $citizen->citizen_name = $reqCitizen['name'];
            $citizen->citizen_phone_no = $reqCitizen['phn'];
            $citizen->citizen_NID = $reqCitizen['nid'];
            $citizen->citizen_gender = isset($reqCitizen['gender']) ? $reqCitizen['gender'] : null;
            $citizen->father = $reqCitizen['father'];
            $citizen->mother = $reqCitizen['mother'];
            $citizen->designation = $reqCitizen['designation'];
            $citizen->organization = $reqCitizen['organization'];
            $citizen->organization_id = $reqCitizen['organization_id'];
            $citizen->present_address = $reqCitizen['presentAddress'];
            $citizen->email = $reqCitizen['email'];
            $citizen->thana = $reqCitizen['thana'];
            $citizen->upazilla = $reqCitizen['upazilla'];
            $citizen->age = $reqCitizen['age'];
            $citizen->created_at = date('Y-m-d H:i:s');
            $citizen->updated_at = date('Y-m-d H:i:s');
            $citizen->created_by = $user->id;
            $citizen->updated_by = $user->id;
            return $citizen;
        }


        $insert_defaulter_witness_info_arr=[];
        $citizen_data=[];
        $multiCtz_data=[];

        $i=1;
        foreach ($citizenList as $reqCitizen) {
            
            // $citizen = storeCtgs_new($appealId,  $reqCitizen);
            $user = globalUserInfo();
            $citizen = CitizenRepository::checkCitizenExist($reqCitizen['phn'],$reqCitizen['nid']);
           

            $citizen->citizen_name = $reqCitizen['name'];
            $citizen->citizen_phone_no = $reqCitizen['phn'];
            $citizen->citizen_NID = $reqCitizen['nid'];
            $citizen->citizen_gender = isset($reqCitizen['gender']) ? $reqCitizen['gender'] : null;
            $citizen->father = $reqCitizen['father'];
            $citizen->mother = $reqCitizen['mother'];
            $citizen->designation = $reqCitizen['designation'];
            $citizen->organization = $reqCitizen['organization'];
            $citizen->organization_id = $reqCitizen['organization_id'];
            $citizen->present_address = $reqCitizen['presentAddress'];
            $citizen->email = $reqCitizen['email'];
            $citizen->thana = $reqCitizen['thana'];
            $citizen->upazilla = $reqCitizen['upazilla'];
            $citizen->age = $reqCitizen['age'];
            $citizen->created_at = date('Y-m-d H:i:s');
            $citizen->updated_at = date('Y-m-d H:i:s');
            $citizen->created_by = $user->id;
            $citizen->updated_by = $user->id;
            $citizen->save();

            //data sent to emc court
            $insert_citizen_info['id']=$citizen->id;
            $insert_citizen_info['citizen_name']=$citizen->citizen_name;
            $insert_citizen_info['citizen_phone_no']=$citizen->citizen_phone_no;
            $insert_citizen_info['citizen_NID']=$citizen->citizen_NID;
            $insert_citizen_info['citizen_gender']=$citizen->citizen_gender;
            $insert_citizen_info['father']=$citizen->father;
            $insert_citizen_info['mother']=$citizen->mother;
            $insert_citizen_info['designation']=$citizen->designation;
            $insert_citizen_info['organization']=$citizen->organization;
            $insert_citizen_info['organization_id']=$citizen->organization_id;
            $insert_citizen_info['present_address']=$citizen->present_address;
            $insert_citizen_info['email']=$citizen->email;
            $insert_citizen_info['thana']=$citizen->thana;
            $insert_citizen_info['upazilla']=$citizen->upazilla;
            $insert_citizen_info['age']=$citizen->age;
            $insert_citizen_info['type']=$reqCitizen['type'];
            $insert_citizen_info['created_at']=date('Y-m-d H:i:s');
            $insert_citizen_info['updated_at']=date('Y-m-d H:i:s');
            $insert_citizen_info['created_by']=$citizen->created_by;
            $insert_citizen_info['updated_by']=$citizen->updated_by;

            array_push($citizen_data, $insert_citizen_info);
         
            
        }

        // dd($multiCtz);
        // return $multiCtz;
        foreach($multiCtz as $nominees){
            for ($i=0; $i<sizeof($nominees['name']); $i++) {
                $citizen = CitizenRepository::checkCitizenExist($nominees['phn'][$i],$nominees['nid'][$i]);
 
                // $citizen = new EcourtCitizen();

                $citizen->citizen_name = isset($nominees['name'][$i]) ? $nominees['name'][$i] : NULL ;
                $citizen->citizen_phone_no = isset($nominees['phn'][$i]) ? $nominees['phn'][$i] : NULL;
                $citizen->citizen_NID = isset($nominees['nid'][$i]) ? $nominees['nid'][$i] : NULL;
                $citizen->citizen_gender = isset($nominees['gender'][$i]) ? $nominees['gender'][$i] : NULL;
                $citizen->father = isset($nominees['father'][$i]) ? $nominees['father'][$i] : NULL;
                $citizen->mother = isset($nominees['mother'][$i]) ? $nominees['mother'][$i] : NULL;
                // $citizen->designation = isset($nominees['designation'][$i]);
                // $citizen->organization = isset($nominees['organization'][$i]);
                $citizen->present_address = isset($nominees['presentAddress'][$i]) ? $nominees['presentAddress'][$i] : NULL;
                $citizen->email = isset($nominees['email'][$i]) ? $nominees['email'][$i] : NULL;
                $citizen->thana = isset($nominees['thana'][$i]) ? $nominees['thana'][$i] : NULL;
                $citizen->upazilla = isset($nominees['upazilla'][$i]) ? $nominees['upazilla'][$i] : NULL;
                $citizen->age = isset($nominees['age'][$i]) ? $nominees['age'][$i] : NULL;

                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                $citizen->created_by =  $citizen->created_by = $user->id;
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $user->id;
                $citizen->save();
                 
                $insert_citizen_info['id']=$citizen->id;
                $insert_citizen_info['citizen_name']=$citizen->citizen_name;
                $insert_citizen_info['citizen_phone_no']=$citizen->citizen_phone_no;
                $insert_citizen_info['citizen_NID']=$citizen->citizen_NID;
                $insert_citizen_info['citizen_gender']=$citizen->citizen_gender;
                $insert_citizen_info['father']=$citizen->father;
                $insert_citizen_info['mother']=$citizen->mother;
                $insert_citizen_info['present_address']=$citizen->present_address;
                $insert_citizen_info['email']=$citizen->email;
                $insert_citizen_info['thana']=$citizen->thana;
                $insert_citizen_info['upazilla']=$citizen->upazilla;
                $insert_citizen_info['type']=$nominees['type'][$i];
                $insert_citizen_info['age']=$citizen->age;
                $insert_citizen_info['created_at']=date('Y-m-d H:i:s');
                $insert_citizen_info['updated_at']=date('Y-m-d H:i:s');
                $insert_citizen_info['created_by']=$citizen->created_by;
                $insert_citizen_info['updated_by']=$citizen->updated_by;

                array_push($multiCtz_data, $insert_citizen_info);
            }
        }
        $data['insert_defaulter_witness_info_arr']= $insert_defaulter_witness_info_arr;
        $data['citizen_data']= $citizen_data;
        $data['multiCtz_data']= $multiCtz_data;
        // dd($data['multiCtz_data']);
        $data['auth_user_and_necessary_data']=[
            'auth_user_id' =>globalUserInfo()->id,
            'username' =>globalUserInfo()->username,
            'caseEntryType' =>$appealInfo->caseEntryType,
            'lawSection' =>$appealInfo->lawSection,
        ];
        return $data;
    }

    public static function getCitizenByCitizenId($citizenId){
        $citizen=EcourtCitizen::find($citizenId);
        return $citizen;
    }
    public static function getAppealCitizenByCitizenId($citizenId){
        $appealCitizen=EmAppealCitizen::find($citizenId);
        return $appealCitizen;
    }
    public static function getCitizenByAppealId($appealId){

        // $citizen=DB::connection('appeal')
        //     ->select(DB::raw(
        //         "SELECT * FROM citizens
        //          JOIN appeal_citizens ac ON ac.citizen_id=citizens.id
        //          WHERE ac.appeal_id =$appealId"
        //     ));

        $citizens = DB::table('em_citizens')
        ->join('em_appeal_citizens as ac', 'ac.citizen_id', '=', 'em_citizens.id')
        ->where('ac.appeal_id', $appealId)
        ->get();

        return $citizens;
    }

    public static function destroyCitizen($citizenIds){

        foreach ($citizenIds as $citizenId){
            $citizen=EcourtCitizen::where('id',$citizenId);
            $citizen->delete();
        }

        return;
    }

    public static function getOffenderLawyerCitizen($appealId){
        $lawerCitizen=[];
        $offenderCitizen=[];

        $appeal = Appeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens=$appeal->appealCitizens;
        foreach ($citizens as $citizen){
            $citizenTypes = $citizen->citizenType;
            foreach ($citizenTypes as $citizenType){
                if($citizenType->id==1){
                    $offenderCitizen=$citizen;
                }
                if($citizenType->id==4){
                    $lawerCitizen=$citizen;
                }
            }
        }

        return ['offenderCitizen'=>$offenderCitizen,
                'lawerCitizen'=>$lawerCitizen ];

    }
    public static function checkCitizenExist($citizen_id,$nid){
        
        if(isset($citizen_id)){
            $citizen=EcourtCitizen::where('citizen_phone_no',$citizen_id)->first();
        }
        elseif(isset($nid))
        {
            $citizen=EcourtCitizen::where('citizen_NID',$nid)->first();
            
        }

        if(isset($citizen))
        {
            return $citizen;
        } 
        else{
            $citizen=new EcourtCitizen();
            return $citizen;
        }
         //dd($citizen);
    }

    

}