<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\McApiController;
use App\Http\Controllers\AppsApi\CitizenCaseListController;
use App\Http\Controllers\EmcCaseMappingApiController;
use App\Http\Controllers\AppsApi\EmcCitizenController;
use App\Http\Controllers\EmcUserManagementApiController;
use App\Http\Controllers\citizen\CitizenAppealController;
use App\Http\Controllers\AppsApi\CitizenRegisterController;
use App\Http\Controllers\mobilecourt\MobileCourtController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/get-section', [MobilecourtController::class, 'section']);




Route::middleware('auth:api', 'scope:view-user')->get('/user', function (Request $request) {
    $data['user_info']=DB::table('users as U')
    ->where('U.id', $request->user()->id)
    ->join('doptor_user_access_info as D', 'U.id', 'D.user_id')
    ->where('D.court_type_id', 2)
    ->select('U.id as id','U.name as name' ,'U.username as username','U.office_id as office_id','U.doptor_office_id as doptor_office_id' ,'U.doptor_user_flag as doptor_user_flag','U.doptor_user_active as doptor_user_active','U.peshkar_active as peshkar_active','U.court_id as court_id','U.mobile_no as mobile_no','U.profile_image as profile_image','U.signature as signature','U.designation as designation','U.email as email','U.email_verified_at as email_verified_at','U.is_verified_account as is_verified_account','U.profile_pic as profile_pic','U.created_at as created_at','U.updated_at as updated_at','D.id as user_access_id','D.court_type_id as user_access_court_type_id','D.role_id as user_access_role_id','D.court_id as user_access_court_id','D.created_at as user_access_created_at')
    ->first();
    $get_user_office=DB::table('users')->where('id', $request->user()->id)->select('office_id')->first();
    $data['office_data']=DB::table('office')->where('id', $get_user_office->office_id)->first();
    return $data;
});
Route::middleware('auth:api', 'scope:view-user')->get('/getuser', function (Request $request) {
    $data['user_info']=DB::table('users as U')
    ->where('U.id', $request->user()->id)
    ->join('doptor_user_access_info as D', 'U.id', 'D.user_id')
    ->where('D.court_type_id', 3)
    ->select('U.id as id','U.name as name' ,'U.username as username','U.office_id as office_id','U.doptor_office_id as doptor_office_id' ,'U.doptor_user_flag as doptor_user_flag','U.doptor_user_active as doptor_user_active','U.peshkar_active as peshkar_active','U.court_id as court_id','U.mobile_no as mobile_no','U.profile_image as profile_image','U.signature as signature','U.designation as designation','U.email as email','U.email_verified_at as email_verified_at','U.is_verified_account as is_verified_account','U.profile_pic as profile_pic','U.created_at as created_at','U.updated_at as updated_at','D.id as user_access_id','D.court_type_id as user_access_court_type_id','D.role_id as user_access_role_id','D.court_id as user_access_court_id','D.created_at as user_access_created_at')
    ->first();
    $get_user_office=DB::table('users')->where('id', $request->user()->id)->select('office_id')->first();
    $data['office_data']=DB::table('office')->where('id', $get_user_office->office_id)->first();
    return $data;
});
Route::middleware('auth:api', 'scope:view-user')->get('/mcgetuser', function (Request $request) {
    $data['user_info']=DB::table('users as U')
    ->where('U.id', $request->user()->id)
    ->join('doptor_user_access_info as D', 'U.id', 'D.user_id')
    ->where('D.court_type_id', 1)
    ->select('U.id as id','U.name as name' ,'U.username as username','U.office_id as office_id','U.doptor_office_id as doptor_office_id' ,'U.doptor_user_flag as doptor_user_flag','U.doptor_user_active as doptor_user_active','U.peshkar_active as peshkar_active','U.court_id as court_id','U.mobile_no as mobile_no','U.profile_image as profile_image','U.signature as signature','U.designation as designation','U.email as email','U.email_verified_at as email_verified_at','U.is_verified_account as is_verified_account','U.profile_pic as profile_pic','U.created_at as created_at','U.updated_at as updated_at','D.id as user_access_id','D.court_type_id as user_access_court_type_id','D.role_id as user_access_role_id','D.court_id as user_access_court_id','D.created_at as user_access_created_at')
    ->first();
    $get_user_office=DB::table('users')->where('id', $request->user()->id)->select('office_id')->first();
    $data['office_data']=DB::table('office')->where('id', $get_user_office->office_id)->first();
    return $data;
});

Route::middleware('auth:api')->get('/logmeout', function (Request $request) {
    $user = $request->user();
    $accessToken = $user->token();
    DB::table("oauth_refresh_tokens")->where("access_token_id", $accessToken->id)->delete();
    $accessToken->delete();
    return response()->json([
    	"message" => "Revoked"
    ]);
});

Route::get('/mysoft-widgets', function (Request $request) {

    $accessToken = $request->header('Widget');
    $data = DB::table("oauth_clients")->where("id","!=", $accessToken)->get()->toArray();
    return response()->json([
        "clients" => $data
    ]);
});

Route::middleware('cors')->group(function () {
    Route::post('/test', function (Request $request) {

        return response()->json([
            "clients" => 'test'
        ]);
    });
});

Route::middleware('auth:api')->get('/logmeout', function (Request $request) {
    $user = $request->user();
    $accessToken = $user->token();
    DB::table("oauth_refresh_tokens")->where("access_token_id", $accessToken->id)->delete();
    $accessToken->delete();
    return response()->json([
    	"message" => "Revoked"
    ]);
});

Route::post('/emc/case-mapping/store', [EmcCaseMappingApiController::class, 'store']);

Route::post('/emc/adm/user/management/all_user_list', [EmcUserManagementApiController::class, 'get_adm_user_list']);
Route::post('/emc/adm/user/management/store/em/dc', [EmcUserManagementApiController::class, 'store_em_dc']);
Route::post('/emc/adm/user/management/store/em/paskar', [EmcUserManagementApiController::class, 'store_em_paskar_dc']);
Route::post('/emc/adm/user/management/store/em/adm', [EmcUserManagementApiController::class, 'store_em_adm_dc']);
Route::post('/emc/adm/user/management/store/em/adm/paskar', [EmcUserManagementApiController::class, 'store_em_a dm_paskar_dc']);



//! Mobile court api
Route::post('/mc/law/section', [McApiController::class, 'mc_law_section']);

Route::middleware('auth:api')->group(function () {
    //emc citizen appeal route
    Route::get('emc/citizen/appeal/create', [EmcCitizenController::class, 'emc_citizen_appeal_create']);
    
    //citizen dashboard 
    Route::post('/citizen_dashboard', [CitizenRegisterController::class, 'citizen_dashboard']);
    Route::post('/citizen_dashboard_data_for_gcc', [CitizenRegisterController::class, 'citizen_dashboard_data_for_gcc']);

    //citizen case list
    Route::post('/case_for_emc_citizen', [CitizenCaseListController::class, 'case_for_emc_citizen']);
    Route::post('/case_for_gcc_citizen', [CitizenCaseListController::class, 'case_for_gcc_citizen']);
    Route::post('/case_for_gcc_org_rep', [CitizenCaseListController::class, 'case_for_gcc_org_rep']);

    //citizen case details
    Route::post('/case_details_for_emc_citizen', [CitizenCaseListController::class, 'case_details_for_emc_citizen']);
    Route::post('/case_details_for_gcc_citizen', [CitizenCaseListController::class, 'case_details_for_gcc_citizen']);
    Route::post('/case_details_for_gcc_org_rep', [CitizenCaseListController::class, 'case_details_for_gcc_org_rep']);

    //citizen case tracking
    Route::post('/case_tracking_for_emc_citizen', [CitizenCaseListController::class, 'case_tracking_for_emc_citizen']);
    Route::post('/case_tracking_for_gcc_citizen', [CitizenCaseListController::class, 'case_tracking_for_gcc_citizen']);
    Route::post('/case_tracking_for_gcc_org_rep', [CitizenCaseListController::class, 'case_tracking_for_gcc_org_rep']);


});

//citizen registration process
Route::post('citizen_registration', [CitizenRegisterController::class, 'citizen_registration']);
Route::post('citizen_registration_opt_verify', [CitizenRegisterController::class, 'citizen_registration_opt_verify']);
Route::post('registration_otp_resend', [CitizenRegisterController::class, 'registration_otp_resend']);
Route::post('password_set_for_citizen', [CitizenRegisterController::class, 'password_set_for_citizen']);
Route::post('password_set_for_org', [CitizenRegisterController::class, 'password_set_for_org']);
Route::post('getDependentOrganization', [CitizenRegisterController::class, 'getDependentOrganization']);

Route::post('deleteCitizen', [CitizenRegisterController::class, 'deleteCitizen']);


