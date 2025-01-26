<?php

namespace App\Http\Controllers\mobilecourt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\MobileCourtRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Traits\TokenVerificationTrait;
use Nette\Utils\Json;

class MobileCourtController extends Controller
{
    use TokenVerificationTrait;
    public function index(){
      
        return view('mobile_court.court.openclose');
     }

    //  public function create_events(Request $request){
       
    //     $magistrate = Auth::user()->id;
        
    //     $date =  $request->start;
        
    //     $status =  $request->status; //  open
        
    //     if($status == "1"){
    //     $phql1 = 'SELECT *
    //             FROM mobile_court
    //             WHERE
    //             mobile_court.magistrate_id = "'.$magistrate.'"  AND (mobile_court.date =  "'.$date.'" OR mobile_court.status = 1)';
    //     $exist_court=DB::table('mobile_court')->where('magistrate_id', $magistrate)->where('data', $date)->where('status',1)->first();
       

    //     $query = $this->modelsManager->createQuery($phql1);
    //     $exist_court = $query->execute();

    //     if(count($exist_court) > 0){
    //         $response = new \Phalcon\Http\Response();
    //         $response->setContentType('application/json', 'UTF-8');
    //         $response->setContent(json_encode("একাধিক কর্মসূচি  প্রণয়ন করা যাবে না [আপনার পূর্বের একটি কোর্ট খোলা রয়েছে ]। "));
    //         return $response;
    //     }
    //     }
    //     elseif ($status == "2"){

    //     $response = new \Phalcon\Http\Response();
    //     $response->setContentType('application/json', 'UTF-8');
    //     $response->setContent(json_encode("এই তারিখে এখনো কোনো কোর্ট খোলা হয়নি,অতএব কোর্ট বন্ধ করা যাচ্ছে না।"));
    //     return $response;

    //     }
    //     DB::table('court')->insertGetId([
    //         'date' =>   $request->start,
    //         'status' => $request->status,
    //         'title' =>  $request->title,
    //         'court_id' =>  "test",
    //         // 'status_court' =>  2,
    //         'magistrate_id' =>1,
    //         'created_by' =>  'Jafrin',
    //         'created_date' => date('Y-m-d') ,
    //         'update_by' =>  'Jafrin',
    //         'update_date' => date('Y-m-d'),
    //         'delete_status' =>  1
    //     ]);
    //     $str_message = "";
    //     if($request->status == 1){  // open
    //         $str_message = "আপনার কোর্টের কর্মসূচি খোলা করা হয়েছে ।";
    //     }else if($request->status == 2){ //  close
    //         $str_message = "আপনার কোর্টের কর্মসূচি বন্ধ করা হয়েছে ।";
    //     }else{ // initiate
    //         $str_message = "আপনার কোর্টের কর্মসূচি প্রণয়ন করা হয়েছে ।";
    //     }
    //     return response()->json($str_message, 200);      
        
    //  }

    public function create_events(Request $request){
       


        $status=$request->status;
        $date=$request->start;
        $userinfo=globalUserInfo();  // gobal user
     
        $str_message = "";
        if($status == "1"){
            $exist_court = DB::table('court')
            ->where('magistrate_id', $userinfo->id)
            ->where(function ($query) use ($date) {
                $query->where('date', $date)
                      ->orWhere('status', 1);
            })
            ->get();
            if(count($exist_court) > 0){
                $str_message =  "একাধিক কর্মসূচি  প্রণয়ন করা যাবে না [আপনার পূর্বের একটি কোর্ট খোলা রয়েছে ]। ";
            }
        }elseif($status == "2"){
            $str_message = "এই তারিখে এখনো কোনো কোর্ট খোলা হয়নি,অতএব কোর্ট বন্ধ করা যাচ্ছে না।";
        }
 
        DB::table('court')->insertGetId([
           'date' =>   $request->start,
           'status' => $request->status,
           'title' =>  $request->title,
           'court_id' =>  "test",
           // 'status_court' =>  2,
           'magistrate_id' =>$userinfo->id,
           'created_by' =>   $userinfo->name,
           'created_date' => date('Y-m-d') ,
           'update_by' =>   $userinfo->name,
           'update_date' => date('Y-m-d'),
           'delete_status' =>  1
        ]);


        if($request->status == 1){  // open
            $str_message = "আপনার কোর্টের কর্মসূচি খোলা  হয়েছে ।";
        }else if($request->status == 2){ //  close
            $str_message = "আপনার কোর্টের কর্মসূচি বন্ধ করা হয়েছে ।";
        }else{ // initiate
            $str_message = "আপনার কোর্টের কর্মসূচি প্রণয়ন করা হয়েছে ।";
        }
        return response()->json($str_message, 200);      
          
       }
     public function getcourtdataAll(){
        $userinfo=globalUserInfo();  // gobal user
        $court =   DB::table('court')->where('magistrate_id', $userinfo->id)->get();
        $className = "";
        $childs = array();
        foreach ($court as $value) {
            if($value->status == 1){
                $className = 'opencourt'; // court open
            }elseif($value->status == 2){
                $className = 'colsedcourt'; // court open
            }else{
                $className = "";
            }

            $childs[] = array(
                'id'        =>$value->id,
                'start'     =>$value->date,
                'end'       =>$value->date,
                'title'     =>$value->title,
                'status'    =>  $value->status,
                'className' => $className,

            );
        }

        return response()->json($childs);
     }

    public function update_events(Request $request){
            $userinfo=globalUserInfo();  // gobal user
            $id = $request->id;
           $court =DB::table('court')->find($id);
            if (!$court) {
                $childs[] = array(
                    'msg' => "Court was not found"
                );
                return response()->json( $childs );
            }

            if($request->status == 1){
                $date=date('Y-m-d');
              
                // if($request->start==$date){
                    // $phql1 =  DB::table('court')->where('magistrate_id', $userinfo->id)->where('date',$request->start)->where('status',1)->get();
                    $phql1 =  DB::table('court')->where('magistrate_id', $userinfo->id)->where('status',1)->get();
                    $exist_court = $phql1;
                    if(count($exist_court) > 0){
                        return response()->json("একাধিক কর্মসূচি  প্রণয়ন করা যাবে না ।");
                    }
                // }
                // else{
                //     $phql1 =  DB::table('court')->where('magistrate_id',$userinfo->id)->where('status',1)->get();
                //     $exist_court = $phql1;
                //     if(count($exist_court) > 0){
                //         return response()->json("একাধিক কর্মসূচি  প্রণয়ন করা যাবে না ।   ");
                //     }
                // }
            }

        $data=array(
            'id' => $id,
            'date' => $request->start,
            'title' => $request->title,
            'status' => $request->status,
            'magistrate_id'=>$userinfo->id
        );
         $update=   DB::table('court')->where('id', $id)->update($data);
        if(!$update) {
            return response()->json("কর্মসূচি  পরিবর্তন  করা যাবে না । ");
        }else{
            $str_message='';
            
            if($request->status == 1){  // open
                $str_message = "আপনার কোর্টের কর্মসূচি খোলা  হয়েছে ।";
            }else if($request->status == 2){ //  close
                $str_message = "আপনার কোর্টের কর্মসূচি বন্ধ করা হয়েছে ।";
            }else{ // initiate
                $str_message = "আপনার কোর্টের কর্মসূচি প্রণয়ন করা হয়েছে ।";
            }
            return response()->json( $str_message);
        }
        return response()->json("Court Update successfully ");
       
    }

    public function delete_events(Request $request){
    
        
        $id =  $request->id;
        $court =DB::table('court')->where('id',$id)->first();
        $is_use = null;

        //    $dd= MobileCourtRepository::prosecutionbyId($court->id);
        // $token = $this->verifySiModuleToken('WEB');
      
        if($court){

            // $is_use = DB::table('prosecution')->where('court_id',$court->id)->first();//Prosecution::findFirstBycourt_id($court->id);
        }
        $childs[] = array();
        if (!$court) {
            $childs = array(
                'msg' => "User was not found"
            );
        }
        if(!$is_use){
            $delete=DB::table('court')->where('id', $id)->delete();
            if (!$delete) {
                $childs = array(
                    'msg' => "কোর্ট বাতিল করা যাবে না "
                );
            } else {
                $childs = array(
                    'msg' => "কোর্ট বাতিল "
                );
            }
        }else{
            $childs = array(
                'msg' => "কোর্ট বাতিল করা যাবে না। ইতমধ্যে মোবাইল কোর্ট কার্যক্রম পরিচালনা হয়েছে।"
            );
        }
        return response()->json($childs);
    }

     

     public function prosecution_create_page(){

        $data['case_type'] = DB::table('mc_law_type')->get();
        $data['seizureitem_type'] = DB::table('seizureitem_type')->get();
        $data['jail'] = DB::table('mc_jail')->get();
        $data['division'] = DB::table('geo_divisions')
        ->select('id', 'division_name_bng')
        ->get();

        return view('mobile_court.appeals.suomotucourt')->with($data);
     }

     public function getDependentDistrict($id)
    {
       
        // $subcategories = DB::table("district")->where("division_id",$id)->pluck("district_name_bn","id");
        $subcategories = DB::table("geo_districts")->where("geo_division_id",$id)->pluck("district_name_bng","id");
        return json_encode($subcategories);
    }

    public function getDependentUpazila($id)
    {
         
        // $subcategories = DB::table("upazila")->where("district_id",$id)->pluck("upazila_name_bn","id");
        $subcategories = DB::table("geo_upazilas")->where("geo_district_id",$id)->pluck("upazila_name_bng","id");
        return json_encode($subcategories);
    }

    public function getDependentCitycorporation($id){
        // citycorporation
        
        $subcategories = DB::table("geo_city_corporations")->where("geo_district_id",$id)->pluck("city_corporation_name_bng","id");
        return json_encode($subcategories);
    
    }
    public function getDependentMetropolitan($id){
        // citycorporation
        
        $subcategories = DB::table("geo_metropolitan")->where("geo_district_id",$id)->pluck("metropolitan_name_bng","id");
        return json_encode($subcategories);
    }
    public function getDependentMetropolitanThana($id){
        // citycorporation
 
        $subcategories = DB::table("geo_thanas")->where("geo_district_id",$id)->pluck("thana_name_bng","id");
        return json_encode($subcategories);
    }

    public function prosecution_store(Request $request){
        $userinfo=globalUserInfo();  // gobal user
        $office_id=globalUserInfo()->office_id;  // gobal user
        $officeinfo= DB::table('office')->where('id',$office_id)->first();
        $date = date('Y-m-d'); // today date
        // login magistate court info 
        $court = DB::table('court')->select('id as court_id')->where('magistrate_id',$userinfo->id)->where('date', $date)->where('status',1)->get();
        $court_id = $court[0]->court_id;

        $case_no = $this->generateCaseNo();
        $token = $this->verifySiModuleToken('WEB');
        
        if( $token){
            $isSuomoto=1;
            

            // if($loginUserInfo['profile']=="Prosecutor"){
                // $magistrateId = $this->request->getPost("data")["selectMagistrateId"];
                // $magistrateCourtId=$this->request->getPost("data")["selectMagistrateCourtId"];
                // $loginUserInfo=$this->utilityService->processLoginUserInfo($magistrateId,$loginUserInfo);
                // $magistrate=Magistrate:: findFirst("id=" . $magistrateId);
                // $isSuomoto=0;
            // }
            $userinfo =array(       
                'id' =>$userinfo->id,
                'magistrate-id' => $userinfo->id,
                'courtname' => $userinfo->name,
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'profile' =>'Magistrate',   // P
                'divid'=> $officeinfo->division_id,
                'zillaid' =>$officeinfo->district_id,
                'upozilaid' => $officeinfo->upazila_id,
                'divname' =>  $officeinfo->div_name_bn,
                'zillaname' =>$officeinfo->dis_name_bn,
                'upozillaname' =>$officeinfo->dis_name_bn ,
                'serviceid'=> $officeinfo->upa_name_bn,
                'office' =>$officeinfo->office_name_bn,
                'officeType' =>$officeinfo->organization_type,
                'joblocation'=>$officeinfo->dis_name_bn,
                'mobile' =>$userinfo->mobile_no,
                'designation'=> $userinfo->designation,
                'role_id'=> $userinfo->role_id,
                'court_id'=> $court_id,
                'case_no'=> $case_no,
            );

          
           $userinfo = json_encode($userinfo);
 
           $data = $request->all();
           $jsonData = json_encode($data['data']);
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL =>getapiManagerBaseUrl().'/api/v1/store_procecution',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'jss'=>$jsonData,
                    'loginuserinfo'=>$userinfo
                    ) ,
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:mobile-court" ,
                    "Authorization: Bearer $token",
                ),
            ));
  
            $response = curl_exec($curl);
            curl_close($curl);
            $dd= json_decode($response,true);
            
            $prosecutionID = $request->prosecutionID;
        
            if($prosecutionID != null && $prosecutionID > 0) {
                // let go, not a valid case
            }
            else {
                // $prosecution = prosecutionService::createProsecutionShell($isSuomoto,$loginUserInfo,$magistrateCourtId,true);
                // $prosecutionID = $prosecution->id;
                // $case_no = prosecutionService::utilityService->getDigitalCaseNumber();
            }
            if($dd['success']==true){
                $msg["flag"] = "true";
                $msg["message"] = "মামলার আসামির তথ্য এট্রি করা হয়েছে ।";
                $msg["step"] = 2;  
                $msg["caseInfo"] =  $dd['data'];  
                $msg["case_no"] =$case_no;//$dd['data']['case_no'];  
                $msg["no_criminal_punish"] = 0;
                return json_encode($msg);
            }
          
            
        }
      
    }

    public function createProsecutionWitness(Request $request){
        $userinfo=globalUserInfo();  // gobal user
        $office_id=globalUserInfo()->office_id;  // gobal user
        $officeinfo= DB::table('office')->where('id',$office_id)->first();
        $date = date('Y-m-d'); // today date
        // login magistate court info 
        $court = DB::table('court')->select('id as court_id')->where('magistrate_id',$userinfo->id)->where('date', $date)->where('status',1)->get();
        $court_id = $court[0]->court_id;

        $case_no = $this->generateCaseNo();


        $token = $this->verifySiModuleToken('WEB');
        if( $token){
            $flag=false;
            $isSuomoto=1;
            $prosecutionId=  $request['data']['prosecutionID'];

            
            $userinfo =array(       
                'id' =>$userinfo->id,
                'magistrate-id' => $userinfo->id,
                'courtname' => $userinfo->name,
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'profile' =>'Magistrate',   // P
                'divid'=> $officeinfo->division_id,
                'zillaid' =>$officeinfo->district_id,
                'upozilaid' => $officeinfo->upazila_id,
                'divname' =>  $officeinfo->div_name_bn,
                'zillaname' =>$officeinfo->dis_name_bn,
                'upozillaname' =>$officeinfo->dis_name_bn ,
                'serviceid'=> $officeinfo->upa_name_bn,
                'office' =>$officeinfo->office_name_bn,
                'officeType' =>$officeinfo->organization_type,
                'joblocation'=>$officeinfo->dis_name_bn,
                'mobile' =>$userinfo->mobile_no,
                'designation'=> $userinfo->designation,
                'role_id'=> $userinfo->role_id,
                'court_id'=> $court_id,
                'case_no'=> $case_no,
            );
           $userinfo = json_encode($userinfo);

            $data = $request->all();
            $jsonData = json_encode($data['data']);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/createProsecutionWitness',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'jss'=>$jsonData,
                    
                    ) ,
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    "secrate_key:mobile-court" ,
                    "Authorization: Bearer $token",
                ),
            ));
  
            $response = curl_exec($curl);
            curl_close($curl);
            $witnessinfo= json_decode($response,true);
            // dd($witnessinfo['data']['updatedProsecution']);
          
            $msg["flag"] =true;
            $msg["prosecution"] = $witnessinfo['data']['updatedProsecution'];
            $msg["case_no"] = $case_no;
            $msg["magistrateInfo"]='';
            $msg["message"] = "সাক্ষীর তথ্য  সফলভাবে সংরক্ষণ করা হয়েছে ।";
            $msg["step"] = 3; // for witness
            $msg["prosecutionId"] =$prosecutionId;
            $msg["no_criminal_punish"] = 0;
        }else{
            $msg["flag"] =false;
            $msg["prosecution"] = '';
            $msg["case_no"] = '';
            $msg["magistrateInfo"]='';
            $msg["message"] = "hy nai";
            $msg["no_criminal_punish"] = 0;
        }
        return json_encode($msg); 
    }

    public function  getLaw()
    {
        
        $data =[];
        $subcategories = DB::table("mc_law")->select('title','id')->get();
        foreach ($subcategories as $t) {
            $data[] = array('id' => $t->id, 'name' => $t->title);
        }
        return json_encode($data);
    }

    public function getSectionByLawId(Request $request)
    {
      
        $id=$request->id;
        $data =[];
        $subcategories = DB::table("mc_section")->where('law_id',$id)->get();
        foreach ($subcategories as $t) {
            $data[] = array('id' => $t->id, 'sec_description' => 'ধারা :' . $t->sec_number . '-' . $t->sec_description);
        }
        return json_encode($data);

    }

    public function getPunishmentBySectionId(Request $request){
     

     $id=$request->id;
        $data ="";
        $subcategories = DB::table("mc_section")->where('id',$id)->get();
 
        foreach ($subcategories as $t) {
            $data = array('name' =>$t->punishment_des ,'sectiondes' =>$t->punishment_sec_number );
        }
        return json_encode($data);
    }
    public function createProsecution(){

     
        $userinfo=globalUserInfo();  // gobal user
        $office_id=globalUserInfo()->office_id;  // gobal user
        $officeinfo= DB::table('office')->where('id',$office_id)->first();
        $date = date('Y-m-d'); // today date
        // login magistate court info 
        $court = DB::table('court')->select('id as court_id')->where('magistrate_id',$userinfo->id)->where('date', $date)->where('status',1)->get();
        $court_id = $court[0]->court_id;


        $prosecutionInfo = $_POST;


        $token = $this->verifySiModuleToken('WEB');
        if( $token){
        $msg = '';
        $data['prosecutionInfo'] = $_POST;  //geting Form data
        //  $brokenLawsArray = $prosecutionInfo['brokenLaws'];   //geting prosecution ID
        $data['prosecutionId'] = $prosecutionInfo['prosecutionId'];   //geting prosecution ID
     
        $jsonData = json_encode($data);
       
        $userinfo =array(       
            'id' =>$userinfo->id,
            'magistrate-id' => $userinfo->id,
            'courtname' => $userinfo->name,
            'name' => $userinfo->name,
            'email' => $userinfo->email,
            'profile' =>'Magistrate',   // P
            'divid'=> $officeinfo->division_id,
            'zillaid' =>$officeinfo->district_id,
            'upozilaid' => $officeinfo->upazila_id,
            'divname' =>  $officeinfo->div_name_bn,
            'zillaname' =>$officeinfo->dis_name_bn,
            'upozillaname' =>$officeinfo->dis_name_bn ,
            'serviceid'=> $officeinfo->upa_name_bn,
            'office' =>$officeinfo->office_name_bn,
            'officeType' =>$officeinfo->organization_type,
            'joblocation'=>$officeinfo->dis_name_bn,
            'mobile' =>$userinfo->mobile_no,
            'designation'=> $userinfo->designation,
            'role_id'=> $userinfo->role_id,
            'court_id'=> $court_id,
        );
       $userinfo = json_encode($userinfo);
       
      
       
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/createProsecution',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'jss'=>$jsonData,
                'loginuserinfo'=>$userinfo
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $prosecution_create= json_decode($response,true);

        // $sections=DB::table('mc_section')->get();
        // $mc_laws=DB::table('mc_law')->get();
          
          
        $msg=[];
 
        if( $prosecution_create['data']['flag']== false){
      
            $msg["flag"] = $prosecution_create['data']['flag'];
            $msg["message"] = $prosecution_create['data']['message'];
            return json_encode($msg);
        }else{
           
            $lawsBrokenList= $prosecution_create['data']['lawsBrokenList'];
            $tablesContent=array();
             if(count($lawsBrokenList)>0){
                 foreach ($lawsBrokenList as $b3) {
                     $sections=DB::table('mc_section')->where('id',$b3['section_id'])->where('law_id',$b3['law_id'])->first();
                     $laws=DB::table('mc_law')->where('id',$b3['law_id'])->first();
                     $sectitle=array(
                         "LawID"=>$b3['law_id'],
                         "LawsBrokenID" => $b3['id'],
                         "ProsecutionID" => $b3['prosecution_id'],
                         "SectionID" => $b3['section_id'],
                         "sec_title" => $sections->sec_title,
                         "sec_number" => $sections->sec_number,
                         "sec_description" => $sections->sec_description,
                         "punishment_sec_number" => $sections->punishment_sec_number,
                         "punishment_des" => $sections->punishment_des,
                         "punishment_type_des" => $sections->punishment_type_des,
                         "max_jell" => $sections->max_jell,
                         "min_jell" => $sections->min_jell,
                         "max_fine" => $sections->max_fine,
                         "min_fine" => $sections->min_fine,
                         "next_jail" => $sections->next_jail,
                         "next_fine" => $sections->next_fine,
                         "bd_law_link"=>$laws->bd_law_link,
                         "Description"=>$laws->description
 
                     );
                     $tablesContent['lawsBrokenList'][] = $sectitle;
                 }
             }else{
                 $tablesContent['lawsBrokenList'] = null;
             }
          
           
 
            $msg["flag"] = $prosecution_create['data']['flag'];
            $msg["message"] =$prosecution_create['data']['message'];
            $msg["case_no"] = $prosecution_create['data']['case_no'];
            $msg["caseInfo"] = $prosecution_create['data']['caseInfo'];
            $msg["lawbroken"] =  $tablesContent;
            $msg["step"] = 4; // for seizure list
            $msg["no_criminal"] = $prosecution_create['data']['no_criminal'];
            $msg["no_criminal_punish"] = 0;
            $msg["isSuomoto"] =$prosecution_create['data']['isSuomoto'];
        }

       
         return json_encode($msg);
        
        }
        // $msg["isSuomoto"] = $prosecution->is_suomotu;
    }

    public function savelist(){
    
        $token = $this->verifySiModuleToken('WEB');
        if( $token){
        $prosecution_id = json_encode($_POST['prosecutionId']);
        $seizure_data = json_encode($_POST['seizure']);
        $seisureitem_types = DB::table('seizureitem_type')->get();
        $seizureitem_type=json_encode($seisureitem_types);
         
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/savelist',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'seizure_data'=>$seizure_data,
                'prosecution_id'=>$prosecution_id,
                'seizureitem_type'=>$seizureitem_type,
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $seizure_create= json_decode($response,true);
        
  
            $msg["seizureOrderContext"] = $seizure_create['data']['seizureOrderContext'];
            $msg["flag"] = "true";
            $msg["prosecutionInfo"] = $seizure_create['data']['prosecution'];
            $msg["step"] = 5; // for ordersheet
            $msg["message"] = "জব্দতালিকা  সফলভাবে সংরক্ষণ করা হয়েছে ।";
            return json_encode($msg);
      }
    }

    public function saveCriminalConfessionSuomotu(Request $request){
        $userinfo=globalUserInfo();  // gobal user
        $office_id=globalUserInfo()->office_id;  // gobal user
        $officeinfo= DB::table('office')->where('id',$office_id)->first();
        $date = date('Y-m-d'); // today date
        // login magistate court info 
        $court = DB::table('court')->select('id as court_id')->where('magistrate_id',$userinfo->id)->where('date', $date)->where('status',1)->get();
        $court_id = $court[0]->court_id;
        $token = $this->verifySiModuleToken('WEB');
        if( $token){

        
        $Data = $request->modelData;
        $modelData= json_decode(json_encode(json_decode($Data)),true);
        $isSuomotoFlag=1;
        // $loginUserInfo = $this->auth->getIdentity();
        $prosecutionID = json_encode($modelData['prosecutionID']);
        $confessionDetails = json_encode($modelData['criminalConfessionDetails']);

      
        $userinfo =array(       
            'id' =>$userinfo->id,
            'magistrate-id' => $userinfo->id,
            'courtname' => $userinfo->name,
            'name' => $userinfo->name,
            'email' => $userinfo->email,
            'profile' =>'Magistrate',   // P
            'divid'=> $officeinfo->division_id,
            'zillaid' =>$officeinfo->district_id,
            'upozilaid' => $officeinfo->upazila_id,
            'divname' =>  $officeinfo->div_name_bn,
            'zillaname' =>$officeinfo->dis_name_bn,
            'upozillaname' =>$officeinfo->dis_name_bn ,
            'serviceid'=> $officeinfo->upa_name_bn,
            'office' =>$officeinfo->office_name_bn,
            'officeType' =>$officeinfo->organization_type,
            'joblocation'=>$officeinfo->dis_name_bn,
            'mobile' =>$userinfo->mobile_no,
            'designation'=> $userinfo->designation,
            'role_id'=> $userinfo->role_id,
            'court_id'=> $court_id,
        );
       $userinfo = json_encode($userinfo);



       $curl = curl_init();
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt_array($curl, array(
           CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/saveCriminalConfessionSuomotu',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_POSTFIELDS => array(
               'logininfo'=>$userinfo,
               'prosecution_id'=>$prosecutionID,
               'confessionDetails'=>$confessionDetails,
               ) ,
           CURLOPT_HTTPHEADER => array(
               'Accept: application/json',
               "secrate_key:mobile-court" ,
               "Authorization: Bearer $token",
           ),
       ));
       $response = curl_exec($curl);
       curl_close($curl);
       $response= json_decode($response,true);
 
        $msg["isSuomoto"]=$response['data']['isSuomotoFlag'];
        $msg["flag"] = "true";
        $msg["message"] = "জবানবন্দী সংরক্ষণ করা হয়েছে ।";
        $msg["step"] = 6; // for ordersheet
        return json_encode($msg);
     }
    
    }
    
    public function saveJimmaderInformation(Request $request){

        $token = $this->verifySiModuleToken('WEB');
        if( $token){

            $Data = $request->modelData;
            $jimmaderInfo= json_decode(json_encode(json_decode($Data)),true);

            $jimadarinfo= json_encode($jimmaderInfo[0]);
            
        // $successMsg=$this->prosecutionService->saveJimmaderInformation($jimmaderInfo[0]);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/saveJimmaderInformation',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                // 'logininfo'=>$userinfo,
                // 'prosecution_id'=>$prosecutionID,
                'jimmaderInfo'=>$jimadarinfo,
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response= json_decode($response,true);
        $msg["flag"] = $response['data'];
        $prosecutionID = $jimmaderInfo['0'];

        // $entityID = $prosecutionID['prosecutionid'];
        // $appName = 'Mobile';
        // $fileCategory = 'OrderSheet';
        // $fileCaption = 'No Caption';
        // $baseUrl = $this->imageUploadUri;

        // $parameter=array(
        //     "entityID"=>$entityID,
        //     "baseUrl"=>$baseUrl,
        //     "appName"=>$appName,
        //     "fileCategory"=>$fileCategory,
        //     "fileCaption"=>$fileCaption,
        // );

        // if ($this->request->hasFiles() == true) {
        //     $this->fileContentService->fileSave($parameter);
        // }

        return json_encode($msg);
        }

        // $msg["flag"] = true;
    }
     
    public function getOrderListByProsecutionId(Request $request){
        $token = $this->verifySiModuleToken('WEB');
        if( $token){
        $response=array();
        $prosecutionId = $request->data;
        $prosecution_id = json_encode( $prosecutionId );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/getOrderListByProsecutionId',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'prosecution_id'=>$prosecution_id,
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response= json_decode($response,true);
    
        $lawsBrokenList= $response['data']['lawsBrokenList'];
        $tablesContent=array();
         if(count($lawsBrokenList)>0){
             foreach ($lawsBrokenList as $b3) {
                 $sections=DB::table('mc_section')->where('id',$b3['section_id'])->where('law_id',$b3['law_id'])->first();
                 $laws=DB::table('mc_law')->where('id',$b3['law_id'])->first();
                 $sectitle=array(
                     "LawID"=>$b3['law_id'],
                     "LawsBrokenID" => $b3['id'],
                     "ProsecutionID" => $b3['prosecution_id'],
                     "SectionID" => $b3['section_id'],
                     "sec_title" => $sections->sec_title,
                     "sec_number" => $sections->sec_number,
                     "sec_description" => $sections->sec_description,
                     "punishment_sec_number" => $sections->punishment_sec_number,
                     "punishment_des" => $sections->punishment_des,
                     "punishment_type_des" => $sections->punishment_type_des,
                     "max_jell" => $sections->max_jell,
                     "min_jell" => $sections->min_jell,
                     "max_fine" => $sections->max_fine,
                     "min_fine" => $sections->min_fine,
                     "next_jail" => $sections->next_jail,
                     "next_fine" => $sections->next_fine,
                     "bd_law_link"=>$laws->bd_law_link,
                     "Description"=>$laws->description

                 );
                 $tablesContent['lawsBrokenList'][] = $sectitle;
             }
         }else{
             $tablesContent['lawsBrokenList'] = null;
         }

       // prepare response message
       $msg["flag"] = "true";
       $msg["message"] = "ডাটা পাওয়া গেছে";
       $msg["punishmentList"] =$response['data']['punishmentList']; 
       $msg["lawsBroken"] =$tablesContent; 
       $value=json_encode($msg);
       return $value;
       
      
        
        
    
        // $response=array(
        //     "punishmentConfessionByLaw"=>null,
        //     "orderList"=>null,
        //     "caseInfo"=>$response['data']['caseInfo'],
        //     "lawsBroken"=>$tablesContent,
        // );
        // $msg["flag"] = "true";
        // $msg["message"] = " রেকর্ডটি";
        // $msg["info"] = $response; //
        // // $msg["flag"] = true;
        // return json_encode($msg);


        
        }
    }
  
    public function getCaseInfoByProsecutionId(Request $request) {

        
        $token = $this->verifySiModuleToken('WEB');
        if( $token){

        $prosecution_id = json_encode($request->prosecutionId);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/getCaseInfoByProsecutionId',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'prosecution_id'=>$prosecution_id ,
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response= json_decode($response,true);
        
        if($response['data']['caseInfo']['prosecution']['case_no'] !='অভিযোগ গঠন হয়নি'){
            $case_no = $response['data']['caseInfo']['prosecution']['case_no'];
        }else{
            $case_no = $this->generateCaseNo();
        }

     
        $lawsBrokenList= $response['data']['lawsBrokenList'];
        $tablesContent=array();
         if(count($lawsBrokenList)>0){
             foreach ($lawsBrokenList as $b3) {
                 $sections=DB::table('mc_section')->where('id',$b3['section_id'])->where('law_id',$b3['law_id'])->first();
                 $laws=DB::table('mc_law')->where('id',$b3['law_id'])->first();
                 $sectitle=array(
                     "LawID"=>$b3['law_id'],
                     "LawsBrokenID" => $b3['id'],
                     "ProsecutionID" => $b3['prosecution_id'],
                     "SectionID" => $b3['section_id'],
                     "sec_title" => $sections->sec_title,
                     "sec_number" => $sections->sec_number,
                     "sec_description" => $sections->sec_description,
                     "punishment_sec_number" => $sections->punishment_sec_number,
                     "punishment_des" => $sections->punishment_des,
                     "punishment_type_des" => $sections->punishment_type_des,
                     "max_jell" => $sections->max_jell,
                     "min_jell" => $sections->min_jell,
                     "max_fine" => $sections->max_fine,
                     "min_fine" => $sections->min_fine,
                     "next_jail" => $sections->next_jail,
                     "next_fine" => $sections->next_fine,
                     "bd_law_link"=>$laws->bd_law_link,
                     "Description"=>$laws->description

                 );
                 $tablesContent['lawsBrokenList'][] = $sectitle;
             }
         }else{
             $tablesContent['lawsBrokenList'] = null;
         }

        $msg["flag"] = "true";
        $msg["caseInfo"] = $response['data']['caseInfo'];   // $prosecution->no_criminal
        $msg["case_no"] = $case_no;   // Send Case no
        $msg["lawsBroken"] = $tablesContent;   // Send Case no

        $ddd=json_encode($msg);
        return $ddd ;


      }
    }

    public function section(){
 
      
        $data =[];
        $mc_section = DB::table("mc_section")->get();
      
         return 'alskdfasd';
     
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/get-section',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'test'=>$mc_section
            ],
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                // "Authorization: Bearer $token",
                "secrate_key: gcc-court-key"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return  json_decode($response);
    }


    public function isPunishmentExist(Request $request){
        $token = $this->verifySiModuleToken('WEB');
        if( $token){
        $msgExistOrder=null;
        $data = json_encode($request->data);
        $flag="false";
        // $isPunishmentExist=$this->punishmentService->isPunishmentExist($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/isPunishmentExist',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'data'=>$data,
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $isPunishmentExist= json_decode($response,true);

        if($isPunishmentExist['data']==1){
            $msgExistOrder='আসামি কে ইতিমধ্যে এই আইনে  আদেশ প্রদান করা হয়েছে। ';
            $flag = "true";
        }
        
        $msg["msgExistOrder"]=$msgExistOrder;
        $msg["flag"] = $flag;
         $response=json_encode($msg);
         return $response;
        }
    }
    public   function generateCaseNo($appealId=null){
        $userinfo=globalUserInfo();
        $court = DB::table('court')->select('id as court_id','title')->where('magistrate_id',$userinfo->id)->where('status',1)->first();
      
       
        // if ($court_details->level == 0) {
        //     $upazila_name_en = $appeal->upazila->upazila_name_en;
        //     $upazila_name_en_exploded = explode(' ', $appeal->upazila->upazila_name_en);
        //     if (!empty($upazila_name_en_exploded[1])) {
        //         $upazilla_name = $upazila_name_en_exploded[1];
        //     } else {
        //         $upazilla_name = $upazila_name_en;
        //     }

        //     $part_1 = strtoupper(substr($appeal->district->district_name_en, 0, 3)) . '-' . strtoupper(substr($upazilla_name, 0, 3)) . '-GCC';
        // } else {
        //     $part_1 = strtoupper(substr($appeal->district->district_name_en, 0, 3)) . '-GCC';
        // }
        $part_1 = strtoupper(substr($court->title, 0, 3)) . '-MC';
        $case_postition = DB::table('court')
            ->selectRaw('count(*) as case_postition')
            ->where('id', $court->court_id)
            ->where('id', '<=',$court->court_id)
            ->first()->case_postition;
        $case_no = $part_1 . '-' . $case_postition .'-' . date('Y') . '-' . $court->court_id.'-'.rand(10,100);
        

        return  $case_no;
     }

     public function getThanaByUsersZillaId(){
      
        $thanaArray = array();
        // $user = $this->auth->getUserLocation();
        $userinfo=globalUserInfo();  // gobal user
        $office_id=globalUserInfo()->office_id;  // gobal user
        $officeinfo= DB::table('office')->where('id',$office_id)->first();
        $date = date('Y-m-d'); // today date
        // login magistate court info 
        $court = DB::table('court')->select('id as court_id')->where('magistrate_id',$userinfo->id)->where('date', $date)->where('status',1)->get();
        $court_id = $court[0]->court_id;
        
        $userinfo =array(       
            'id' =>$userinfo->id,
            'magistrate-id' => $userinfo->id,
            'courtname' => $userinfo->name,
            'name' => $userinfo->name,
            'email' => $userinfo->email,
            'profile' =>'Magistrate',   // P
            'divid'=> $officeinfo->division_id,
            'zillaid' =>$officeinfo->district_id,
            'upozilaid' => $officeinfo->upazila_id,
            'divname' =>  $officeinfo->div_name_bn,
            'zillaname' =>$officeinfo->dis_name_bn,
            'upozillaname' =>$officeinfo->dis_name_bn ,
            'serviceid'=> $officeinfo->upa_name_bn,
            'office' =>$officeinfo->office_name_bn,
            'officeType' =>$officeinfo->organization_type,
            'joblocation'=>$officeinfo->dis_name_bn,
            'mobile' =>$userinfo->mobile_no,
            'designation'=> $userinfo->designation,
            'role_id'=> $userinfo->role_id,
            'court_id'=> $court_id,
        );
        
        $tmp = array();
        if ($userinfo['zillaid']) {
    
            $tmp = DB::table('geo_thanas')->where('geo_district_id', $userinfo['zillaid'])->get();
          
        }

        foreach ($tmp as $t) {
            $thanaArray[] = array('id' => $t->id, 'name' => $t->thana_name_bng );

        }


        
       return  json_encode($thanaArray);
     }
     
    public function saveOrderBylaw(Request $request){
        $userinfo=globalUserInfo();  // gobal user
        $office_id=globalUserInfo()->office_id;  // gobal user
        $officeinfo= DB::table('office')->where('id',$office_id)->first();
        $date = date('Y-m-d'); // today date
        // login magistate court info 
        $court = DB::table('court')->select('id as court_id')->where('magistrate_id',$userinfo->id)->where('date', $date)->where('status',1)->get();
        $court_id = $court[0]->court_id;
        
        

        $token = $this->verifySiModuleToken('WEB');
        if( $token){
            $msg = '';
            $msgExistOrder=null;
            $data =$request->all();
            $punishment = json_encode( $data['data']);
           
            $userinfo =array(       
                'id' =>$userinfo->id,
                'magistrate-id' => $userinfo->id,
                'courtname' => $userinfo->name,
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'profile' =>'Magistrate',   // P
                'divid'=> $officeinfo->division_id,
                'zillaid' =>$officeinfo->district_id,
                'upozilaid' => $officeinfo->upazila_id,
                'divname' =>  $officeinfo->div_name_bn,
                'zillaname' =>$officeinfo->dis_name_bn,
                'upozillaname' =>$officeinfo->dis_name_bn ,
                'serviceid'=> $officeinfo->upa_name_bn,
                'office' =>$officeinfo->office_name_bn,
                'officeType' =>$officeinfo->organization_type,
                'joblocation'=>$officeinfo->dis_name_bn,
                'mobile' =>$userinfo->mobile_no,
                'designation'=> $userinfo->designation,
                'role_id'=> $userinfo->role_id,
                'court_id'=> $court_id,
            );  
            $userinfo = json_encode($userinfo);
           
         
           $curl = curl_init();
           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt_array($curl, array(
               CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/saveOrderBylaw',
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => '',
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 0,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => 'POST',
               CURLOPT_POSTFIELDS => array(
                   'loginuserinfo'=>$userinfo,
                   'punishmentinfo'=>$punishment,
                   ) ,
               CURLOPT_HTTPHEADER => array(
                   'Accept: application/json',
                   "secrate_key:mobile-court" ,
                   "Authorization: Bearer $token",
               ),
           ));
           $response = curl_exec($curl);
           curl_close($curl);
           $punishments= json_decode($response,true);
         
           if(!$punishments){
               $msgExistOrder='আসামি কে ইতিমধ্যে এই আইনে  আদেশ প্রদান করা হয়েছে। ';
           }
        
           $msg=[];
           // prepare response message
           $msg["flag"] = "true";
           $msg["message"] = "আদেশ সম্পন্ন হয়েছে।";
           $msg["punishment"] = $punishments; //
           $msg["msgExistOrder"]=$msgExistOrder;
           $response =json_encode( $msg);
         
           return $response;
        }
    }

    public function deleteOrder(Request $request){

        $orderId= $request->orderId;
        $prosecutionId=$request->prosecutionId;
        $token = $this->verifySiModuleToken('WEB');
        if( $token){
        $curl = curl_init();
           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt_array($curl, array(
               CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/deleteOrder',
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => '',
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 0,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => 'POST',
               CURLOPT_POSTFIELDS => array(
                    'orderId'=>$orderId,
                    'prosecutionId'=>$prosecutionId
                   ) ,
               CURLOPT_HTTPHEADER => array(
                   'Accept: application/json',
                   "secrate_key:mobile-court" ,
                   "Authorization: Bearer $token",
               ),
           ));
           $response = curl_exec($curl);
           curl_close($curl);
           $punishment= json_decode($response,true);

            // prepare response message
            if($punishment['data']=='success'){
            $msg["flag"] = "true";
            $msg["message"] = "রেকর্ডটি";
            $msg["punishment"] = $punishment['data']; //
            $response= json_encode($msg);
            }else{
                $msg["flag"] = "false";
                $msg["message"] = "রেকর্ডটি";
                $msg["punishment"] ='error'; 
                $response= json_encode($msg);
            }
            return $response;
        }
    }

    public function previewOrderSheet(Request $request){   
        // orderSheetLayout
       $prosecutionId=$request->prosecutionId;
      
       return view('mobile_court.appeals.partials.orderSheetLayout',['prosecutionId' => $prosecutionId]);
    }
    public function getOrderSheetInfo(Request $request){

         $prosecutionId = $request->data;

        $token = $this->verifySiModuleToken('WEB');
        if( $token){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/getOrderSheetInfo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'prosecutionId'=>$prosecutionId,
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $allresponse= json_decode($response,true);
     
        $lawsBrokenList= $allresponse['data']['lawsBrokenList'];
        $tablesContent=array();
         if(count($lawsBrokenList)>0){
             foreach ($lawsBrokenList as $b3) {
                 $sections=DB::table('mc_section')->where('id',$b3['section_id'])->where('law_id',$b3['law_id'])->first();
                 $laws=DB::table('mc_law')->where('id',$b3['law_id'])->first();
                 $sectitle=array(
                     "LawID"=>$b3['law_id'],
                     "LawsBrokenID" => $b3['id'],
                     "ProsecutionID" => $b3['prosecution_id'],
                     "SectionID" => $b3['section_id'],
                     "sec_title" => $sections->sec_title,
                     "sec_number" => $sections->sec_number,
                     "sec_description" => $sections->sec_description,
                     "punishment_sec_number" => $sections->punishment_sec_number,
                     "punishment_des" => $sections->punishment_des,
                     "punishment_type_des" => $sections->punishment_type_des,
                     "max_jell" => $sections->max_jell,
                     "min_jell" => $sections->min_jell,
                     "max_fine" => $sections->max_fine,
                     "min_fine" => $sections->min_fine,
                     "next_jail" => $sections->next_jail,
                     "next_fine" => $sections->next_fine,
                     "bd_law_link"=>$laws->bd_law_link,
                     "Description"=>$laws->description

                 );
                 $tablesContent['lawsBrokenList'][] = $sectitle;
             }
         }else{
             $tablesContent['lawsBrokenList'] = null;
         }
       
        $response=array(
            "punishmentConfessionByLaw"=>$allresponse['data']['punishmentConfessionByLaw'],
            "orderList"=>$allresponse['data']['orderList'],
            "caseInfo"=>$allresponse['data']['caseInfo'],
            "lawsBroken"=>$tablesContent
        );
      
        $msg["flag"] = "true";
        $msg["message"] = " রেকর্ডটি";
        $msg["info"] = $response; //
        $ddd= json_encode($msg);
        return $ddd;
    }
  }


  public function saveOrdersheet(Request $request){


    $token = $this->verifySiModuleToken('WEB');
    if( $token){
        $header=json_encode($request->header);
        $tableBody=json_encode($request->tableBody);
        $prosecutionId=json_encode($request->prosecutionId);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/saveOrdersheet',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'header'=>$header,
                'tableBody'=>$tableBody,
                'prosecutionId'=>$prosecutionId,
                ) ,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "secrate_key:mobile-court" ,
                "Authorization: Bearer $token",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $allresponse= json_decode($response,true);
       
        $successMsg= $allresponse['data'];
        //  dd($allresponse);
        $msg["flag"] = $successMsg;
        $response = json_encode($msg);
        return $response;
     }

  }
}
