<?php

namespace App\Http\Controllers\mobilecourt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\MobileCourtRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Traits\TokenVerificationTrait;


class CriminalController extends Controller
{
    //
    use TokenVerificationTrait;
    public function getCriminalPreviousCrimeDetails(Request $request){
    
        $prosecutionId = $request->prosecutionId;
        $criminalId = $request->criminalId;
        $token = $this->verifySiModuleToken('WEB');
        if( $token){

            $prosecution_id = json_encode( $prosecutionId);
            $criminal_id  = json_encode( $criminalId );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => getapiManagerBaseUrl().'/api/v1/getCriminalPreviousCrimeDetails',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'prosecution_id'=>$prosecution_id,
                    'criminal_id'=>$criminal_id,
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
           return  json_encode($seizure_create['data']);
          
        }

    }

}
