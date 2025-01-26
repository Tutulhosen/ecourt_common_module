<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GeoThanasController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MagistrateController;
use App\Http\Controllers\DoptorLoginController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\doptor\NDoptorUserData;
use App\Http\Controllers\FormDownLoadController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\McRegisterListController;
use App\Http\Controllers\GeoMetropolitanController;
use App\Http\Controllers\McLawAndSectionController;
use App\Http\Controllers\GeoCityCorporationsController;
use App\Http\Controllers\McCitizenPublicViewController;
use App\Http\Controllers\doptor\NDoptorUserManagementAdmin;
use App\Http\Controllers\MCLawController;
use App\Http\Controllers\MCSectionController;
use App\Http\Controllers\McSottoGolpoController;
use App\Http\Controllers\OrganizationManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin/doptor/management', 'as' => 'admin.doptor.management.'], function () {

    Route::post('/import/dortor/offices', [NDoptorUserData::class, 'import_doptor_office'])->name('import.offices');

    Route::get('/dropdownlist/getdependentdistrict/{id}', [NDoptorUserData::class, 'getDependentDistrictForDoptor']);
    Route::get('/dropdownlist/getdependentupazila/{id}', [NDoptorUserData::class, 'getDependentUpazilaForDoptor']);
    Route::get('/dropdownlist/getdependentlayer/{id}', [NDoptorUserData::class, 'getdependentlayer']);

    Route::get('/import/dortor/offices/search', [NDoptorUserData::class, 'imported_doptor_office_search'])->name('import.offices.search');

    Route::get('/user_list/segmented/all/{office_id}', [NDoptorUserManagementAdmin::class, 'all_user_list_from_doptor_segmented'])->name('user_list.segmented.all');

    Route::get('/search/user_list/segmented/all/{office_id}', [NDoptorUserManagementAdmin::class, 'all_user_list_from_doptor_segmented_search'])->name('search.all.members');

    Route::post('/divisional/commissioner/create', [NDoptorUserManagementAdmin::class, 'divisional_commissioner_create_by_admin'])->name('divisional.commissioner.create');

    Route::post('/district/commissioner/create', [NDoptorUserManagementAdmin::class, 'district_commissioner_create_by_admin'])->name('dictrict.commissioner.create');

    Route::post('/pasker/district/commissioner/create', [NDoptorUserManagementAdmin::class, 'pasker_district_commissioner_create_by_admin'])->name('pasker.dictrict.commissioner.create');

    Route::post('/aditional/district/commissioner/create', [NDoptorUserManagementAdmin::class, 'aditional_district_commissioner_create_by_admin'])->name('aditional.dictrict.commissioner.create');

    Route::post('/aditional/district/commissioner/pasker/create', [NDoptorUserManagementAdmin::class, 'aditional_district_commissioner_pasker_create_by_admin'])->name('aditional.dictrict.commissioner.pasker.create');

    Route::post('/deputy/collector/create', [NDoptorUserManagementAdmin::class, 'deputy_collector_create_by_admin'])->name('deputy.collector.create');

    Route::post('/record/keeper/create', [NDoptorUserManagementAdmin::class, 'record_keeper_create_by_admin'])->name('record.keeper.create');

    Route::post('/dc/office/gco', [NDoptorUserManagementAdmin::class, 'gco_dc_create_by_admin'])->name('gco.dc.create');

    Route::post('/dc/office/certificate/assistent', [NDoptorUserManagementAdmin::class, 'store_certificate_asst_dc_by_admin'])->name('certificate.assistent.create.dc');

    Route::post('/uno/office/gco', [NDoptorUserManagementAdmin::class, 'gco_uno_create_by_admin'])->name('gco.uno.create');

    Route::post('/uno/office/certificate/assistent', [NDoptorUserManagementAdmin::class, 'store_certificate_asst_uno_by_admin'])->name('certificate.assistent.create.uno');


    //emc route
    Route::post('emc/dm/create', [NDoptorUserManagementAdmin::class, 'dm_create_by_admin'])->name('emc.dm.create');
    Route::post('emc/adm/create', [NDoptorUserManagementAdmin::class, 'adm_create_by_admin'])->name('emc.adm.create');
    Route::post('emc/adm/pasker/create', [NDoptorUserManagementAdmin::class, 'adm_pasker_create_by_admin'])->name('emc.adm.pasker.create');
    Route::post('emc/em/create', [NDoptorUserManagementAdmin::class, 'em_create_by_admin'])->name('emc.em.create');
    Route::post('emc/em/pasker/create', [NDoptorUserManagementAdmin::class, 'em_pasker_create_by_admin'])->name('emc.em.pasker.create');

    //Mobile Court route
    Route::post('mc/dm/create', [NDoptorUserManagementAdmin::class, 'mc_dm_create_by_admin'])->name('mc.dm.create');
    Route::post('mc/adm/create', [NDoptorUserManagementAdmin::class, 'mc_adm_create_by_admin'])->name('mc.adm.create');
    Route::post('mc/acgm/create', [NDoptorUserManagementAdmin::class, 'mc_acgm_create_by_admin'])->name('mc.acgm.create');
    Route::post('mc/em/create', [NDoptorUserManagementAdmin::class, 'mc_em_create_by_admin'])->name('mc.em.create');
    Route::post('mc/pasker/create', [NDoptorUserManagementAdmin::class, 'mc_pasker_create_by_admin'])->name('mc.pasker.create');
});

//nothi login route
Route::get('test_nothi/', [DoptorLoginController::class, 'ndoptor_sso'])->name('nothi.v2.login');
Route::get('test/nothi/callback', [DoptorLoginController::class, 'ndoptor_sso_callback']);
Route::get('test/nothi/nothi_issus', [DoptorLoginController::class, 'ndoptor_sso_nothi_issus'])->name('nothi_issus');



//Forget password 
Route::get('applicant/forget/password/{id}', [RegistrationController::class, 'forget_password'])->name('applicant.forget.password');
Route::post('applicant/forget/password/usercheck', [RegistrationController::class, 'user_check_forget_password'])->name('user.check.forget.password');

Route::get('/registration/citizen/mobile/check/{user_id}', [RegistrationController::class, 'registration_otp_check'])->name('registration.citizen.mobile.check');

Route::get('/registration/citizen/reg/opt/resend/{user_id}', [RegistrationController::class, 'registration_otp_resend'])->name('registration.citizen.reg.opt.resend');

Route::post('/registration/otp/verify', [RegistrationController::class, 'registration_otp_verify'])->name('registration.otp.verify');

Route::get('/reset/password/after/otp/{user_id}', [RegistrationController::class, 'reset_password_after_otp'])->name('reset.password.after.otp');
Route::post('/mobile/first/password/match', [RegistrationController::class, 'mobile_first_password_match'])->name('mobile.first.password.match');
Route::post('/mobile/first/password/match/organization', [RegistrationController::class, 'mobile_first_password_match_organization'])->name('mobile.first.password.match.organization');



//support section
Route::middleware('auth')->group(function () {
    Route::get('/citizen/support/center', [SupportController::class, 'citizen_support_form_page'])->name('support.center.citizen');
    Route::post('/citizen/support/center/post/form', [SupportController::class, 'support_form_post_citizen'])->name('support.form.post.citizen');
    Route::get('/download/form', [FormDownLoadController::class, 'index'])->name('download.form');
});


Route::middleware('auth')->group(function () {
    Route::get('get/organization/change/applicant', [OrganizationManagementController::class, 'get_organization_change_by_applicant'])->name('get.organization.change.applicant');

    Route::post('post/organization/change/applicant', [OrganizationManagementController::class, 'post_organization_change_by_applicant'])->name('post.organization.change.applicant');
});


/*------------------mc law and section--------------------------------*/


Route::get('/citizen_public_view/new', [McCitizenPublicViewController::class, 'new'])->name('mc_citizen_public_view.new');
Route::post('/job_description/getzilla/{ld?}', [McRegisterListController::class, 'getzilla'])->name('getzilla');
Route::post('/job_description/getUpazila/{ld?}', [McRegisterListController::class, 'getUpazila'])->name('getUpazila');

// citicorporation 
Route::post('/geo_city_corporations/getCityCorporation', [GeoCityCorporationsController::class, 'getCityCorporation'])->name('geo.getCityCorporation');
Route::post('/geo_metropolitan/getmetropolitan', [GeoMetropolitanController::class, 'getmetropolitan'])->name('geo.getmetropolitan');
Route::post('/geo_thanas/getthanas', [GeoThanasController::class, 'getthanas'])->name('geo.getthanas');


Route::post('/citizen_public_view/create', [McCitizenPublicViewController::class, 'create'])->name('em_citizen_public_view.create');
Route::post('/citizen_public_view/search', [McCitizenPublicViewController::class, 'search'])->name('em_citizen_public_view.search');

//Determination of Jurisdiction
Route::get('/jurisdiction/determination',[MagistrateController::class, 'jurisdiction'])->name('jurisdiction.determination');
Route::post('/jurisdiction/store', [MagistrateController::class, 'jurisdiction_store'])->name('jurisdiction.store');
Route::get('/check/user/permission', [MagistrateController::class, 'check_user_permission'])->name('check.user.permission');
Route::get('/get-districts/{div_id}', [MagistrateController::class, 'getDistricts']);
Route::get('/get-user/{dis_id}', [MagistrateController::class, 'getUser']);
Route::get('/get-upazilas/{dis_id}', [MagistrateController::class, 'getUpazilas']);

//mobile court mamla cancel
Route::get('cancel/mamla', [MagistrateController::class, 'mamla_cancel'])->name('mobile.court.mamla.cnacel');
Route::post('cancel/mamla/from/admin', [MagistrateController::class, 'mamla_cancel_from_admin'])->name('mobile.court.mamla.cancel.from.admin');



// mobile court golpo upload
Route::middleware('auth')->group(function () {
    Route::get('/sottogolpo', [McSottoGolpoController::class, 'index'])->name('mc_sottogolpo.index');
    Route::get('/sottogolpo/create', [McSottoGolpoController::class, 'create'])->name('mc_sottogolpo.create');
    Route::post('/sottogolpo/store', [McSottoGolpoController::class, 'store'])->name('mc_sottogolpo.store');
    Route::get('/sottogolpo/edit/{id}', [McSottoGolpoController::class, 'edit'])->name('mc_sottogolpo.edit');
    Route::post('/sottogolpo/update/{id}', [McSottoGolpoController::class, 'update'])->name('mc_sottogolpo.update');
});

//mc law 
Route::middleware('auth')->group(function () {
    Route::get('/mc/law/index', [MCLawController::class, 'index'])->name('mc.law.index');
    Route::get('/mc/law/create', [MCLawController::class, 'create'])->name('mc.law.create');
    Route::post('/mc/law/store', [MCLawController::class, 'store'])->name('mc.law.store');
    Route::get('/mc/law/edit/{id}', [MCLawController::class, 'edit'])->name('mc.law.edit');
    Route::post('/mc/law/update/{id}', [MCLawController::class, 'update'])->name('mc.law.update');
});

//mc section 
Route::middleware('auth')->group(function () {
    Route::get('/mc/section/index', [MCSectionController::class, 'index'])->name('mc.section.index');
    Route::get('/mc/section/create', [MCSectionController::class, 'create'])->name('mc.section.create');
    Route::post('/mc/section/store', [MCSectionController::class, 'store'])->name('mc.section.store');
    Route::get('/mc/section/edit/{id}', [MCSectionController::class, 'edit'])->name('mc.section.edit');
    Route::post('/mc/section/update/{id}', [MCsectionController::class, 'update'])->name('mc.section.update');
});



Route::get('/create/doptor/office/table', [NDoptorUserManagementAdmin::class, 'create_doptor_office_tabel']);
