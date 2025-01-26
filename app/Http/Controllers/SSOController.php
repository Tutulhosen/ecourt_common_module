<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SSOController extends Controller
{


    // ==============for service==================//
    public function getLogin(Request $request){
        
        $response = Http::asForm()->post(
            "https://idp-devsso.land.gov.bd/oauth/token",
            [
            "grant_type" => "authorization_code",
            "client_id" => "9a61f625-8ddc-4f28-a4aa-d048884daec8",
            "client_secret" => "VEnEKErYjI32IR1SS0C3wjVA0CSFySepR0EIozYE",
            "redirect_uri" => "http://localhost:8000/callback",
            "code" =>$request->code
        ]);
        $request->session()->put($response->json());

 
        return redirect("http://localhost:7878/getCallback");
    }
    // ==============for service==================//

    // ================= for Common ==========//

    public function getCallback(Request $request){
        $state = $request->session()->pull("state");
        // dd($request->all());
        // throw_unless(strlen($state) > 0 && $state == $request->start,
        // InvalidArgumentException::class);
        
        $response = Http::asForm()->post(
            "https://idp-devsso.land.gov.bd/oauth/token",
            [
            "grant_type" => "authorization_code",
            "client_id" => "9a61f625-8ddc-4f28-a4aa-d048884daec8",
            "client_secret" => "VEnEKErYjI32IR1SS0C3wjVA0CSFySepR0EIozYE",
            "redirect_uri" => "http://localhost:8000/callback",
            "code" =>$request->code
        ]);

        $request->session()->put($response->json());

        return redirect(route("sso.connect")); 
    }
    // =================End for Common ==========//

    // ==========================for Service====================//
    public function connectUser(Request $request){
        $access_token =$request->session()->get("access_token");
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $access_token
        ])->get("https://idp-devsso.land.gov.bd/api/user");
        $userAray = $response->json();

        try {
            $email =$userAray['email'];
        } catch (\Throwable $th) {
            return redirect("login")->withError("Faild to get login. Plz try again.");
        }
        $user = User::where("email",  $email)->first();
        if(!$user){
            $user =new User;
            $user->name=$userAray['name'];
            $user->email=$userAray['email'];
            $user->email_verified_at=$userAray['email_verified_at'];
            $user->save();
        }
        Auth::login($user);
        return redirect(route("home"));
    }


    public function showLoginForm()
    {
        return view('auth.login'); // Ensure you have a login view
    }
}
