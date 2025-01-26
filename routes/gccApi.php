<?php

use App\Http\Controllers\GccCaseMappingApiController;
use App\Http\Controllers\GccUserManagementApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GccApiController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\citizen\CitizenAppealController;

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

Route::post('/logined_in', [ApiLoginController::class, 'logined_in']);
Route::post('/mc-logined_in', [ApiLoginController::class, 'mobile_court_logined_in']);
Route::post('/gcc-logined_in', [ApiLoginController::class, 'gcc_court_logined_in']);
Route::post('/emc-logined_in', [ApiLoginController::class, 'emc_court_logined_in']);
Route::post('/citizen_login', [ApiLoginController::class, 'citizen_login']);

Route::post('/organization/store', [GccApiController::class, 'organization_store']);
Route::post('/organization/update', [GccApiController::class, 'organization_update']);


Route::post('/gcc/case-mapping/store', [GccCaseMappingApiController::class, 'store']);

// dm and dam user management
Route::post('/commonModule/user/info', [GccApiController::class, 'pass_user_data_for_gcc_court']);
Route::post('/certificate/copy/payment/data', [GccApiController::class, 'certificate_copy_payment_data']);

Route::post('/gcc/adm/user/management/all_user_list', [GccUserManagementApiController::class, 'get_adm_user_list']);
Route::post('/gcc/adm/user/management/store/gco/dc', [GccUserManagementApiController::class, 'store_gco_dc']);
Route::post('/gcc/adm/user/management/store/certificate/dc', [GccUserManagementApiController::class, 'store_certificate_dc']);
Route::post('/gcc/adm/user/management/store/adc/dc', [GccUserManagementApiController::class, 'store_adc_dc']);