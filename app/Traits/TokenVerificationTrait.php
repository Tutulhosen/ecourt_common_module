<?php
// TokenVerificationTrait.php

namespace App\Traits;

use App\Models\CustomToken;
use App\Traits\SiModuleTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

trait TokenVerificationTrait
{
    use SiModuleTrait;

    public function verifySiModuleToken($request_type)
    {
        $currentTime = \Carbon\Carbon::now();
        $thresholdTime = $currentTime->subHours(12);

        $expirationTime = DB::table('custom_tokens_api')->where('token_name', 'ProductModule')
            ->where('updated_at', '>=', $thresholdTime)
            ->first();

        // $expirationTime = CustomToken::all();

        if (empty($expirationTime)) {
            $idpData = self::getSiModule();


            $login_token = $this->CallLoginAPI(
                $idpData['idp_url'],
                $idpData['idp_email'],
                $idpData['idp_password'],
                $idpData['idp_api_key']
            );
            // dd($login_token);
            DB::table('custom_tokens_api')->where('token_name', 'ProductModule')->update([
                'token' => $login_token->data->token,
                'request_type' => $request_type,
            ]);

            return $login_token->data->token;
        } else {

            return $expirationTime->token;
        }
    }




    protected function CallLoginAPI($idp_url, $idp_email, $idp_password, $idp_api_key)
    {
        // dd($idp_url.'api/login', $idp_email,  $idp_password, $idp_api_key);
        $curl = curl_init();
        // dd($curl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $idp_url . 'api/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'email' => "$idp_email",
                'password' => "$idp_password",
                'api_secret' => "$idp_api_key"
            ),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json'
            ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        $login_token = json_decode($response);
        // dd($login_token->data->token);
        return $login_token;
    }
}
