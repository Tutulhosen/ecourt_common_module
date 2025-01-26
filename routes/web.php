<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSOController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\EmcNewsController;
use App\Http\Controllers\gcc\GccController;
use App\Http\Controllers\GccNewsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CauseListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\emc\CourtController;
use App\Http\Controllers\MyprofileController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\EmcSettingController;
use App\Http\Controllers\gcc\ReportController;
use App\Http\Controllers\GccSettingController;
use App\Http\Controllers\CrpcSectionController;
use App\Http\Controllers\DoptorLoginController;
use App\Http\Controllers\EmcRegisterController;
use App\Http\Controllers\GccRegisterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\doptor\NDoptorUserData;
use App\Http\Controllers\CitizenAppealController;
use App\Http\Controllers\DependentDataController;
use App\Http\Controllers\emc\EmcReportController;
use App\Http\Controllers\EmcAppealListController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\PeshkarSettingController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ApiCitizenCheckController;
use App\Http\Controllers\GccParentOfficeController;
use App\Http\Controllers\EmcLogManagementController;
use App\Http\Controllers\GccLogManagementController;
use App\Http\Controllers\mobilecourt\CriminalController;
use App\Http\Controllers\mobilecourt\MobileCourtController;
use App\Http\Controllers\citizen\CitizenAppealListController;
use App\Http\Controllers\mobilecourt\MonthlyReportController;
use App\Http\Controllers\mobilecourt\McRegisterListController;
use App\Http\Controllers\CertificateAssistentSettingController;
use App\Http\Controllers\citizen\CitizenRegistrationController;
use App\Http\Controllers\mobilecourt\MisnotificationController;
use App\Http\Controllers\citizen\GccCitizenAppealListController;
use App\Http\Controllers\emc_citizen\EmcCitizenAppealController;
use App\Http\Controllers\emc_citizen\EmcCitizenRegisterController;
use App\Http\Controllers\gcc\CourtController as GccCourtController;
use App\Http\Controllers\emc_citizen\EmcCitizenAppealListController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserListController;

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

Route::get('/g', function () {
    return view('gcc_login');
});

Route::get('/lo', function () {
    return view('gcc_login_templete');
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});
//Reoptimized class loader:
Route::get('/optimize-clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>View cache cleared</h1>';
});



Route::get('/custom-logout', [LandingPageController::class, 'custom_logout'])->name('custom.logout');
Route::get('/en2bn', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'notify' => en2bn($request->notify),
    ]);
})->name('en2bn');

Route::get('/', [LandingPageController::class, 'index'])->name('home.index');
Route::get('/allGolpos', [LandingPageController::class, 'allGolpos'])->name('home.allGolpos');
Route::get('/sottogolpo/{id}', [LandingPageController::class, 'singleGolpo'])->name('home.singleGolpo');

// !TEMPORARY
// Route::get('/addData', [LandingPageController::class, 'addData']);


//! TEMPORARY
Route::get('/dropdownlist/get/district/{id}', [LandingPageController::class, 'getDependentDistrictForDoptor']);
Route::get('/dropdownlist/get/upazila/{id}', [LandingPageController::class, 'getDependentUpazilaForDoptor']);
//!

Route::get('/support/center', [SupportController::class, 'citizen_support_form_page'])->name('support.center');


Route::get('/doptor/court', [LandingPageController::class, 'doptor_court_select'])->name('doptor.court.select');
Route::get('/login/page/{type_id}', [LandingPageController::class, 'show_log_in_page'])->name('show_log_in_page');
Route::post('/logined_in', [LandingPageController::class, 'logined_in'])->name('logined_in');
Route::get('/admin/login/page', [LandingPageController::class, 'show_admin_log_in_page'])->name('show_admin_log_in_page');
Route::post('/admin/logined_in', [LandingPageController::class, 'admin_logined_in'])->name('admin.logined_in');
Route::post('/logout/custom', [LandingPageController::class, 'logout'])->name('logout.custom');
Route::get('/redirect/select/court/{id}', [LandingPageController::class, 'redirect_select_court'])->name('redirect.select.court');

//citizen  registration
Route::get('/registration', [CitizenRegistrationController::class, 'register'])->name('citizen.registration');
Route::get('/registration/form/by/type/{type_id}', [CitizenRegistrationController::class, 'register_by_type'])->name('citizen.registration.by.type');
Route::post('/registration/opt/send}', [CitizenRegistrationController::class, 'register_opt_send'])->name('citizen.registration.otp.sent');
Route::get('/registration/citizen/mobile/check/{user_id}', [CitizenRegistrationController::class, 'registration_otp_check'])->name('registration.citizen.mobile.check');
Route::get('/registration/citizen/reg/opt/resend/{user_id}', [CitizenRegistrationController::class, 'registration_otp_resend'])->name('registration.citizen.reg.opt.resend');
Route::post('/registration/otp/verify', [CitizenRegistrationController::class, 'registration_otp_verify'])->name('registration.otp.verify');
Route::get('/reset/password/after/otp/verify/{user_id}', [CitizenRegistrationController::class, 'reset_password_after_otp_verify'])->name('reset.password.after.otp.verify');
Route::post('/password/match', [CitizenRegistrationController::class, 'password_match'])->name('password.match');
Route::post('/new/nid/verify/mobile/reg/first', [CitizenRegistrationController::class, 'new_nid_verify_mobile_reg_first'])->name('new.nid.verify.mobile.reg.first');

Route::post('/verify/account/mobile/reg/first', [CitizenRegistrationController::class, 'verify_account_mobile_reg_first'])->name('verify.account.mobile.reg.first');
Route::post('password/match/organization', [CitizenRegistrationController::class, 'password_match_organization'])->name('password.match.organization');

//dependency route
route::get('/case/dropdownlist/getdependentdistrict/{id}', [DependentDataController::class, 'getDependentDistrict']);
route::get('/case/dropdownlist/getdependentupazila/{id}', [DependentDataController::class, 'getDependentUpazila']);
route::get('/case/dropdownlist/getdependentcourt/{id}', [DependentDataController::class, 'getDependentCourt']);
route::post('/case/dropdownlist/getdependentorganization', [DependentDataController::class, 'getDependentOrganization']);
route::get('/case/dropdownlist/getdependentOfficeName/{id}', [DependentDataController::class, 'getdependentOfficeName']);




Route::get('/dashboard/{id?}', [DashboardController::class, 'index'])->name('dashboard.index');
//for gcc dashboard statistics
Route::post('/dashboard/ajax-case-status', [DashboardController::class, 'ajaxCaseStatus'])->name('dashboard.case-status-report');
Route::post('/dashboard/ajax-payment-report', [DashboardController::class, 'ajaxPaymentReport'])->name('dashboard.payment-report');
Route::post('/dashboard/ajax-crpc-pie-chart', [DashboardController::class, 'ajaxPieChart'])->name('dashboard.crpc-pie-chart');

//for emc dashboard statistics
Route::post('/dashboard/emc/ajax-crpc', [DashboardController::class, 'emc_ajaxCrpc'])->name('emc.dashboard.crpc-report');
Route::post('/dashboard/emc/ajax-case-status', [DashboardController::class, 'emc_ajaxCaseStatus'])->name('emc.dashboard.case-status-report');
Route::post('/dashboard/emc/ajax-case-statistics', [DashboardController::class, 'emc_ajaxCaseStatistics'])->name('emc.dashboard.ajax-case-statistics');
Route::post('/dashboard/emc/ajax-crpc-pie-chart', [DashboardController::class, 'emc_ajaxPieChart'])->name('emc.dashboard.crpc-pie-chart');

//user profile setup route
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'my-profile/', 'as' => 'my-profile.'], function () {
        Route::get('/', [MyprofileController::class, 'index'])->name('index');
        Route::get('/basic', [MyprofileController::class, 'basic_edit'])->name('basic_edit');
        Route::post('/basic/update', [MyprofileController::class, 'basic_update'])->name('basic_update');
        Route::get('/image', [MyprofileController::class, 'imageUpload'])->name('imageUpload');
        Route::post('/image/update', [MyprofileController::class, 'image_update'])->name('image_update');
        Route::get('/change/password/logged/in', [MyprofileController::class, 'change_password_lgged_in'])->name('change.password.logged.in');
        Route::post('/update/password/logged/in', [MyprofileController::class, 'update_password_logged_in'])->name('update.password.logged.in');
    });
});

Route::group(['prefix' => 'role-permission/', 'as' => 'role-permission.'], function () {
    Route::get('/index', [RolePermissionController::class, 'index'])->name('index');
    Route::post('/show_permission', [RolePermissionController::class, 'show_permission'])->name('show_permission');
    Route::post('/store', [RolePermissionController::class, 'store'])->name('store');
});

// route for mobile court 
Route::group(['prefix' => 'mobile-court/', 'as' => 'mobile.court.'], function () {
    Route::get('/openclose', [MobileCourtController::class, 'index'])->name('openclose');
    Route::post('/create_events', [MobileCourtController::class, 'create_events'])->name('create_events');
    Route::post('/update_events', [MobileCourtController::class, 'update_events'])->name('update_events');
    Route::post('/delete_events', [MobileCourtController::class, 'delete_events'])->name('delete_events');
    Route::get('/getcourtdataAll', [MobileCourtController::class, 'getcourtdataAll'])->name('court.getcourtdataAll');
    Route::get('/prosecution/create', [MobileCourtController::class, 'prosecution_create_page'])->name('prosecution.create.page');

    Route::post('/prosecution/prosecution_store', [MobileCourtController::class, 'prosecution_store'])->name('prosecution.store');
    Route::get('/dropdownlist/getdependentdistrict/{id}', [MobileCourtController::class, 'getDependentDistrict']);
    Route::get('/dropdownlist/getdependentupazila/{id}', [MobileCourtController::class, 'getDependentUpazila']);
    Route::get('/dropdownlist/getdependentcitycorporation/{id}', [MobileCourtController::class, 'getDependentCitycorporation']);

    Route::get('/dropdownlist/getdependentmetropolitan/{id}', [MobileCourtController::class, 'getDependentMetropolitan']);
    Route::get('/dropdownlist/getdependentmetropolitanthana/{id}', [MobileCourtController::class, 'getDependentMetropolitanThana']);
    Route::get('/location/division/', [LocationController::class, 'division']);
    Route::get('/location/zilla/{id}', [LocationController::class, 'zilla']);
    Route::get('/location/upazilla/{id}', [LocationController::class, 'upazilla']);
    Route::get('/location/citycorporation/{id}', [LocationController::class, 'citycorporation']);
    Route::get('/location/metropolitan/{id}', [LocationController::class, 'metropolitan']);
    Route::get('/location/thana/{id}', [LocationController::class, 'thana']);
    Route::post('/prosecution/createProsecutionCriminalBymagistrate', [MobileCourtController::class, 'prosecution_store']);
    Route::post('/prosecution/createProsecutionWitness', [MobileCourtController::class, 'createProsecutionWitness']);
    Route::get('/law/getLaw/', [MobileCourtController::class, 'getLaw']);
    Route::get('/section/getSectionByLawId', [MobileCourtController::class, 'getSectionByLawId']);
    Route::get('/section/getPunishmentBySectionId', [MobileCourtController::class, 'getPunishmentBySectionId']);
    Route::post('/prosecution/createProsecution', [MobileCourtController::class, 'createProsecution']);
    Route::post('/prosecution/savelist', [MobileCourtController::class, 'savelist']);


    Route::post('/prosecution/saveCriminalConfessionSuomotu', [MobileCourtController::class, 'saveCriminalConfessionSuomotu']);
    Route::post('/punishment/saveJimmaderInformation', [MobileCourtController::class, 'saveJimmaderInformation']);
    Route::post('/punishment/getOrderListByProsecutionId', [MobileCourtController::class, 'getOrderListByProsecutionId']);
    Route::post('/prosecution/getCaseInfoByProsecutionId', [MobileCourtController::class, 'getCaseInfoByProsecutionId']);
    Route::post('/criminal/getCriminalPreviousCrimeDetails', [CriminalController::class, 'getCriminalPreviousCrimeDetails']);
    Route::post('/punishment/isPunishmentExist', [MobileCourtController::class, 'isPunishmentExist']);
    Route::post('/geo_thanas/getThanaByUsersZillaId', [MobileCourtController::class, 'getThanaByUsersZillaId']);
    Route::post('/prosecution/saveOrderBylaw', [MobileCourtController::class, 'saveOrderBylaw']);
    Route::post('/punishment/deleteOrder', [MobileCourtController::class, 'deleteOrder']);
    Route::get('/punishment/previewOrderSheet', [MobileCourtController::class, 'previewOrderSheet']);
    Route::post('/punishment/getOrderSheetInfo', [MobileCourtController::class, 'getOrderSheetInfo']);
    Route::post('/punishment/saveOrderSheet', [MobileCourtController::class, 'saveOrderSheet']);
});


// Settings for gcc for GCO
Route::middleware('auth')->group(function () {
    // Route::middleware(['doptor_user_active_middlewire'])->group(function () {
    // Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
    Route::group(['prefix' => 'gcc/', 'as' => 'gcc.'], function () {
        Route::get('settings/short-decision', [GccSettingController::class, 'shortDecision'])->name('settings.short-decision');
        Route::get('settings/short-decision/create', [GccSettingController::class, 'shortDecisionCreate'])->name('settings.short-decision.create');
        Route::post('settings/short-decision/store', [GccSettingController::class, 'shortDecisionStore'])->name('settings.short-decision.store');
        Route::get('settings/short-decision/edit/{id}', [GccSettingController::class, 'shortDecisionEdit'])->name('settings.short-decision.edit');
        Route::post('settings/short-decision/update/{id}', [GccSettingController::class, 'shortDecisionUpdate'])->name('settings.short-decision.update');
    });
});

// default causelist
Route::get('/cause_list', [CauseListController::class, 'index'])->name('cause_list');
// Settings for emc for EM

Route::middleware('auth')->group(function () {
    // gcc report module 
    Route::get('/gcc-report', [ReportController::class, 'index'])->name('gcc.report.index');
    Route::post('/gcc-report-pdf', [ReportController::class, 'gcc_pdf_generate']);

    Route::group(['prefix' => 'emc/', 'as' => 'emc.'], function () {

        Route::get('short-decision', [EmcSettingController::class, 'shortDecision'])->name('short-decision');
        Route::get('short-decision/create', [EmcSettingController::class, 'shortDecisionCreate'])->name('short-decision.create');
        Route::post('short-decision/store', [EmcSettingController::class, 'shortDecisionStore'])->name('short-decision.store');
        Route::get('short-decision/edit/{id}', [EmcSettingController::class, 'shortDecisionEdit'])->name('short-decision.edit');
        Route::post('short-decision/update/{id}', [EmcSettingController::class, 'shortDecisionUpdate'])->name('short-decision.update');
        Route::get('short-decision/details/create/{id}', [EmcSettingController::class, 'shortDecisionDetailsCreate'])->name('short-decision.details_create');
        Route::post('short-decision/details/store', [EmcSettingController::class, 'shortDecisionDetailsStore'])->name('short-decision.details_store');
    });
});



// For GCC ASST_GCO
Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
    Route::get('certificate_asst-short-decision', [CertificateAssistentSettingController::class, 'shortDecision'])->name('certificate_asst.short.decision');
    Route::get('certificate_asst-short-decision/create', [CertificateAssistentSettingController::class, 'shortDecisionCreate'])->name('certificate_asst.short.decision.create');
    Route::post('certificate_asst-short-decision/store', [CertificateAssistentSettingController::class, 'shortDecisionStore'])->name('certificate_asst.short.decision.store');
    Route::get('certificate_asst-short-decision/edit/{id}', [CertificateAssistentSettingController::class, 'shortDecisionEdit'])->name('certificate_asst.short.decision.edit');
    Route::post('certificate_asst-short-decision/update/{id}', [CertificateAssistentSettingController::class, 'shortDecisionUpdate'])->name('certificate_asst.short.decision.update');
    Route::get('certificate_asst-short-decision/details/create/{id}', [CertificateAssistentSettingController::class, 'shortDecisionDetailsCreate'])->name('certificate_asst.short.decision.details.create');
    Route::post('certificate_asst-short-decision/details/store', [CertificateAssistentSettingController::class, 'shortDecisionDetailsStore'])->name('certificate_asst.short.decision.details.store');
});

// For EMC for PESKAR
Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
    Route::get('peshkar-short-decision', [PeshkarSettingController::class, 'shortDecision'])->name('peshkar.short.decision');
    Route::get('peshkar-short-decision/create', [PeshkarSettingController::class, 'shortDecisionCreate'])->name('peshkar.short.decision.create');
    Route::post('peshkar-short-decision/store', [PeshkarSettingController::class, 'shortDecisionStore'])->name('peshkar.short.decision.store');
    Route::get('peshkar-short-decision/edit/{id}', [PeshkarSettingController::class, 'shortDecisionEdit'])->name('peshkar.short.decision.edit');
    Route::post('peshkar-short-decision/update/{id}', [PeshkarSettingController::class, 'shortDecisionUpdate'])->name('peshkar.short.decision.update');
    Route::get('peshkar-short-decision/details/create/{id}', [PeshkarSettingController::class, 'shortDecisionDetailsCreate'])->name('peshkar.short.decision.details.create');
    Route::post('peshkar-short-decision/details/store', [PeshkarSettingController::class, 'shortDecisionDetailsStore'])->name('peshkar.short.decision.details.store');
});


// For emc citizen
Route::middleware('auth')->group(function () {

    Route::post('citizen_check', [ApiCitizenCheckController::class, 'citizen_check'])->name('citizen_check');

    Route::group(['prefix' => 'emc/citizen/', 'as' => 'emc.citizen.'], function () {

        Route::get('appeal/create', [EmcCitizenAppealController::class, 'create'])->name('appeal.create');
        Route::get('appeal/edit/{id}', [EmcCitizenAppealController::class, 'edit'])->name('appeal.edit');

        Route::post('appeal/nid/check', [EmcCitizenAppealController::class, 'appeal_nid_check'])->name('appeal.nid.check');

        Route::post('appeal/store', [EmcCitizenAppealController::class, 'store'])->name('appeal.store');

        Route::get('appeal/list', [EmcCitizenAppealListController::class, 'index'])->name('appeal.index');
        Route::get('appeal/draft_list', [EmcCitizenAppealListController::class, 'draft_list'])->name('appeal.draft_list');
        Route::get('appeal/rejected_list', [EmcCitizenAppealListController::class, 'rejected_list'])->name('appeal.rejected_list');
        Route::get('appeal/closed_list', [EmcCitizenAppealListController::class, 'closed_list'])->name('appeal.closed_list');
        Route::get('appeal/postponed_list', [EmcCitizenAppealListController::class, 'postponed_list'])->name('appeal.postponed_list');
        Route::get('register', [EmcCitizenRegisterController::class, 'create'])->name('register');
        Route::get('appeal/trial_date_list', [EmcCitizenRegisterController::class, 'trial_date_list'])->name('appeal.trial_date_list');
    });

    Route::get('/emc-report', [EmcReportController::class, 'index'])->name('emc-report');
    Route::post('/emc-pdf-gereate', [EmcReportController::class, 'pdf_generate'])->name('emc_pdf_generate');

    Route::post('/payment-process', [PaymentController::class, 'payment_process'])->name('payment_process');
    Route::get('/payment-success', [PaymentController::class, 'ekPaySuccess'])->name('payment_success');
    Route::get('/payment-cancel', [PaymentController::class, 'ekPayCancel'])->name('payment_cancel');
    Route::get('/paynotice', [PaymentController::class, 'paynotice'])->name('paynotice');
    Route::post('/process-fee', [PaymentController::class, 'process_fee'])->name('process_fee');
    Route::post('/makepaymentmodal', [PaymentController::class, 'makepaymentmodal'])->name('makepaymentmodal');
});


Route::group(['prefix' => 'generalCertificate/'], function () {
    Route::get('appealCreate', [AppealController::class, 'create'])->name('appealCreate');
    route::get('/case/dropdownlist/getdependentdistrict/{id}', [AppealController::class, 'getDependentDistrict']);
    route::get('/case/dropdownlist/getdependentupazila/{id}', [AppealController::class, 'getDependentUpazila']);
    route::get('/case/dropdownlist/getdependentcourt/{id}', [AppealController::class, 'getDependentCourt']);
    route::get('/getdependentlawdetails/{id}', [CitizenAppealController::class, 'getDependentLawDetails']);
    // emc
    route::get('/court/dropdownlist/getdependentcourt/{id}', [AppealController::class, 'EmcDependentCourt']);
});


// For emc court
Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
    Route::group(['prefix' => 'emc/', 'as' => 'emc.'], function () {
        route::get('/court', [CourtController::class, 'index'])->name('court');
        route::get('/court/create', [CourtController::class, 'create'])->name('court.create');
        Route::post('/court/save', [CourtController::class, 'store'])->name('court.save');
        route::get('/court/edit/{id}', [CourtController::class, 'edit'])->name('court.edit');
        route::post('/court/update/{id}', [CourtController::class, 'update'])->name('court.update');
        route::get('/court-setting/dropdownlist/getdependentdistrict/{id}', [CourtController::class, 'getDependentDistrict']);
        Route::get('/emc-generate-pdf/{id}', [EmcAppealListController::class, 'generate_pdf'])->name('generate.pdf');
    });
});

//For gcc court
Route::middleware(['settings_protection_from_citizen_middlewire'])->group(function () {
    Route::group(['prefix' => 'gcc/', 'as' => 'gcc.'], function () {
        route::get('/court', [GccCourtController::class, 'index'])->name('court');
        route::get('/court/create', [GccCourtController::class, 'create'])->name('court.create');
        Route::post('/court/save', [GccCourtController::class, 'store'])->name('court.save');
        route::get('/court/edit/{id}', [GccCourtController::class, 'edit'])->name('court.edit');
        route::post('/court/update/{id}', [GccCourtController::class, 'update'])->name('court.update');
        route::get('/court-setting/dropdownlist/getdependentdistrict/{id}', [GccCourtController::class, 'getDependentDistrict']);
        route::get('/court-setting/dropdownlist/getDependentUpazila/{id}', [GccCourtController::class, 'getDependentUpazila']);
    });
});

//Gcc pp citizen
Route::middleware(['gccrouteprotect2'])->group(function () {
    Route::group(['prefix' => 'gcc/pp/citizen/', 'as' => 'gcc.pp.citizen.'], function () {
        Route::get('appeal/all_case', [GccCitizenAppealListController::class, 'all_case'])->name('appeal.all_case');
        Route::get('appeal/running_case', [GccCitizenAppealListController::class, 'running_case'])->name('appeal.running_case');
        Route::get('appeal/pending_case', [GccCitizenAppealListController::class, 'pending_case'])->name('appeal.pending_case');
        Route::get('appeal/complete_case', [GccCitizenAppealListController::class, 'complete_case'])->name('appeal.complete_case');
        Route::get('appeal/case-details/{id}', [GccCitizenAppealListController::class, 'showAppealCaseDetails'])->name('appeal.case.details');
        Route::get('appeal/case-tracking/{id}', [GccCitizenAppealListController::class, 'showAppealTrakingPage'])->name('appeal.case.tracking');
        Route::get('/case-appeal/{id}', [GccCitizenAppealListController::class, 'CaseAppeal'])->name('case.appeal');

        Route::get('/case/for/appeal/all_case', [GccCitizenAppealListController::class, 'all_case_appeal_case'])->name('case.for.appeal.all_case');
        Route::get('/case/for/appeal/running_case', [GccCitizenAppealListController::class, 'running_case_appeal_case'])->name('case.for.appeal.running_case');
        Route::get('/case/for/appeal/pending_case', [GccCitizenAppealListController::class, 'pending_case_appeal_case'])->name('case.for.appeal.pending_case');
        Route::get('/case/for/appeal/complete_case', [GccCitizenAppealListController::class, 'complete_case_appeal_case'])->name('case.for.appeal.complete_case');
    });
});

//Gcc citizen
Route::middleware(['gccrouteprotect2'])->group(function () {
    Route::group(['prefix' => 'gcc/citizen/', 'as' => 'gcc.citizen.'], function () {
        Route::get('appeal/all_case', [GccCitizenAppealListController::class, 'all_case_gcc_citizen'])->name('appeal.all_case');
        Route::get('appeal/running_case', [GccCitizenAppealListController::class, 'running_case_gcc_citizen'])->name('appeal.running_case');
        Route::get('appeal/pending_case', [GccCitizenAppealListController::class, 'pending_case_gcc_citizen'])->name('appeal.pending_case');
        Route::get('appeal/complete_case', [GccCitizenAppealListController::class, 'complete_case_gcc_citizen'])->name('appeal.complete_case');

        Route::get('case/for/appeal/all_case', [GccCitizenAppealListController::class, 'case_for_all_case_gcc_citizen'])->name('case.for.appeal.all_case');
        Route::get('case/for/appeal/running_case', [GccCitizenAppealListController::class, 'case_for_running_case_gcc_citizen'])->name('case.for.appeal.running_case');
        Route::get('case/for/appeal/pending_case', [GccCitizenAppealListController::class, 'case_for_pending_case_gcc_citizen'])->name('case.for.appeal.pending_case');
        Route::get('vase/for/appeal/complete_case', [GccCitizenAppealListController::class, 'case_for_complete_case_gcc_citizen'])->name('case.for.appeal.complete_case');
        
        Route::get('appeal/certify_copy_fee_case', [GccCitizenAppealListController::class, 'certify_copy_fee_case'])->name('appeal.certify_copy_fee_case');
        Route::get('appeal/for/hearing', [GccCitizenAppealListController::class, 'for_hearing'])->name('appeal.for.hearing');
        Route::get('certify/copy/cancel', [GccCitizenAppealListController::class, 'certify_copy_cancel'])->name('appeal.certify.copy.cancel');

        Route::get('/case-appeal/{id}', [GccCitizenAppealListController::class, 'CaseAppeal_gcc_citizen'])->name('case.appeal');

        Route::get('case-traking/{id}', [GccCitizenAppealListController::class, 'showCitizenTrakingPage'])->name('appealTraking');
        Route::get('appeal/case-details/{id}', [GccCitizenAppealListController::class, 'showCitizenCaseDetails'])->name('appeal.case.details');

        

        //certificate copy
        Route::get('/court-fee/{id}/{court_id}', [GccCitizenAppealListController::class, 'court_fee_page'])->name('court.fee');
        Route::post('/court-fee/submit', [GccCitizenAppealListController::class, 'court_fee'])->name('court.fee.submit');
        Route::get('/certify-copy-fee/{id}/{court_id}', [GccCitizenAppealListController::class, 'certify_copy_fee_page'])->name('certify.copy.fee');
        Route::post('/certify-copy-fee/submit', [GccCitizenAppealListController::class, 'certify_copy_fee'])->name('certify.copy.fee.submit');
        Route::get('/attached-certify-copy-page/{id}/{court_id}', [GccCitizenAppealListController::class, 'attached_certify_copy_page'])->name('attached.certify.copy.page');
        Route::post('/attached-certify-copy/submit', [GccCitizenAppealListController::class, 'attached_certify_copy'])->name('attached.certify.copy.submit');
        Route::get('/certify/copy/list', [GccCitizenAppealListController::class, 'certify_copy_list'])->name('certify.copy.list');
        Route::get('/certify/applicent/form/{id}', [GccCitizenAppealListController::class, 'certify_applicent_form'])->name('certify.applicent.form');
        //appeal process
        Route::get('/appeal-court-fee/{id}/{court_id}', [GccCitizenAppealListController::class, 'appeal_court_fee_page'])->name('appeal.court.fee');
        Route::post('/appeal-court-fee/submit', [GccCitizenAppealListController::class, 'appeal_court_fee'])->name('appeal.court.fee.submit');
       
    });
});

//parent office dashboard data fetch
Route::group(['prefix' => 'gcc/parent/office/', 'as' => 'gcc.parent.office.'], function () {
    Route::get('appeal/all_case/{status}', [GccParentOfficeController::class, 'all_case_for_parent'])->name('appeal.all_case');
    Route::get('appeal/case-traking/{id}', [GccParentOfficeController::class, 'case_traking'])->name('appeal.case.traking');
    Route::get('appeal/view/{id}', [GccParentOfficeController::class, 'showAppealViewPage'])->name('appeal.appealView');
});

//Emc citizen
Route::middleware(['gccrouteprotect2'])->group(function () {
    Route::group(['prefix' => 'emc/citizen/', 'as' => 'emc.citizen.'], function () {
        Route::get('appeal/all_case', [CitizenAppealListController::class, 'all_case'])->name('appeal.all_case');
        Route::get('appeal/running_case', [CitizenAppealListController::class, 'running_case'])->name('appeal.running_case');
        Route::get('appeal/pending_case', [CitizenAppealListController::class, 'pending_case'])->name('appeal.pending_case');
        Route::get('appeal/complete_case', [CitizenAppealListController::class, 'complete_case'])->name('appeal.complete_case');

        Route::get('case/for/all/appeal/case', [CitizenAppealListController::class, 'case_for_all_appeal_case'])->name('case.for.all.appeal.case');
        Route::get('case/for/running/appeal/case', [CitizenAppealListController::class, 'case_for_running_appeal_case'])->name('case.for.running.appeal.case');
        Route::get('case/for/pending/appeal/case', [CitizenAppealListController::class, 'case_for_pending_appeal_case'])->name('case.for.pending.appeal.case');
        Route::get('case/for/complete/appeal/case', [CitizenAppealListController::class, 'case_for_complete_appeal_case'])->name('case.for.complete.appeal.case');

        Route::get('case-traking/{id}', [CitizenAppealListController::class, 'showAppealTrakingPage'])->name('appealTraking');
        Route::get('appeal/case-details/{id}', [CitizenAppealListController::class, 'showAppealCaseDetails'])->name('appeal.case.details');
        Route::get('/case-appeal/{id}', [CitizenAppealListController::class, 'CaseAppeal'])->name('case.appeal');
    });
});



// For emc investigation
Route::get('/investigator/verify', [InvestigationController::class, 'investigator_verify'])->name('investigator.verify');
Route::post('/investigator/verify/form', [InvestigationController::class, 'investigator_verify_form_submit'])->name('investigator.verify.form');
Route::get('/investigation/report/{id}/{mobile_no}/{investigator_id}', [InvestigationController::class, 'investigation_report'])->name('investigation.report');
Route::post('/investigator/form/submit', [InvestigationController::class, 'investigator_form_submit'])->name('investigator.form.submit');



Route::get('/voice_to_text', function () {
    return view('_voice_to_text_ours');
})->name('voice_to_text');


Route::get('/getLogin', [SSOController::class, 'getLogin']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//emc archive
Route::get('/emc/closed_list', [EmcAppealListController::class, 'closed_list'])->name('emc.closed_list');
// Route::get('/emc/closed_list/details/{id}', [EmcAppealListController::class, 'showAppealViewPage'])->name('emc.showAppealViewPage');
Route::get('/emc/old_closed_list', [EmcAppealListController::class, 'old_closed_list'])->name('emc.old_closed_list');
Route::get('/emc/old_closed_list/details/{id}', [EmcAppealListController::class, 'showAppealViewPage'])->name('emc.showAppealViewPage');



//EMC log index 
Route::get('/emc/log_index', [EmcLogManagementController::class, 'index'])->name('emc.log_index');
Route::get('/emc/log_index_single/{id}', [EmcLogManagementController::class, 'log_index_single'])->name('emc.log_index_single');
Route::get('/emc/create_log_pdf/{id}', [EmcLogManagementController::class, 'create_log_pdf'])->name('emc.create_log_pdf');
Route::get('/emc/log/logid/details/{id}', [EmcLogManagementController::class, 'log_details_single_by_id'])->name('emc.log_details_single_by_id');

//GCC log  index
Route::get('/gcc/log_index', [GccLogManagementController::class, 'index'])->name('gcc.log_index');
Route::get('/gcc/log_index_single/{id}', [GccLogManagementController::class, 'log_index_single'])->name('gcc.log_index_single');
Route::get('/gcc/log/logid/{id}', [GccLogManagementController::class, 'log_details_single_by_id'])->name('gcc.log_details_single_by_id');
Route::get('/gcc/create_log_pdf/{id}', [GccLogManagementController::class, 'create_log_pdf'])->name('gcc.create_log_pdf');


//EMC News 
Route::group(['prefix' => 'emc/', 'as' => 'emc.'], function () {
    Route::get('/news/list', [EmcNewsController::class, 'index'])->name('news');
    Route::get('/news/create', [EmcNewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [EmcNewsController::class, 'store'])->name('news.store');
    Route::get('/news/edit/{id}', [EmcNewsController::class, 'edit'])->name('news.edit');
    Route::post('/news/update/{id}', [EmcNewsController::class, 'update'])->name('news.update');
    Route::get('/news/delete/{id}', [EmcNewsController::class, 'destroy'])->name('news.delete');
    Route::get('/news/status/{status}/{id}', [EmcNewsController::class, 'status'])->name('status.update');
});


//GCC News
Route::group(['prefix' => 'gcc/', 'as' => 'gcc.'], function () {
    Route::get('/news/list', [GccNewsController::class, 'index'])->name('news');
    Route::get('/news/create', [GccNewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [GccNewsController::class, 'store'])->name('news.store');
    Route::get('/news/edit/{id}', [GccNewsController::class, 'edit'])->name('news.edit');
    Route::post('/news/update/{id}', [GccNewsController::class, 'update'])->name('news.update');
    Route::get('/news/delete/{id}', [GccNewsController::class, 'destroy'])->name('news.delete');
    Route::get('/news/status/{status}/{id}', [GccNewsController::class, 'status'])->name('status.update');
});


//user list
Route::get('gcc/user/list', [UserListController::class,'gcc_user_list'])->name('gcc.user.list');
Route::get('gcc/user/list/search', [UserListController::class,'gcc_user_list_search'])->name('gcc.user.list.search');
Route::get('emc/user/list', [UserListController::class,'emc_user_list'])->name('emc.user.list');
Route::get('emc/user/list/search', [UserListController::class,'emc_user_list_search'])->name('emc.user.list.search');
Route::get('mc/user/list', [UserListController::class,'mc_user_list'])->name('mc.user.list');
Route::get('mc/user/list/search', [UserListController::class,'mc_user_list_search'])->name('mc.user.list.search');




// EMC Register controller 
Route::group(['prefix' => 'emc/register/', 'as' => 'emc.register.'], function () {
    Route::get('list', [EmcRegisterController::class, 'index'])->name('list');
    Route::get('printPdf', [EmcRegisterController::class, 'registerPrint'])->name('printPdf');
});

// GCC Register controller 
Route::group(['prefix' => 'gcc/register/', 'as' => 'gcc.register.'], function () {
    Route::get('list', [GccRegisterController::class, 'index'])->name('list');
    Route::get('printPdf', [GccRegisterController::class, 'registerPrint'])->name('printPdf');
});

// Feature news
Route::get('/gcc/news/list', [GccNewsController::class, 'index'])->name('gcc.news');
Route::get('/gcc/news/create', [GccNewsController::class, 'create'])->name('gcc.news.create');
Route::post('/gcc/news/store', [GccNewsController::class, 'store'])->name('gcc.news.store');
Route::get('/gcc/news/edit/{id}', [GccNewsController::class, 'edit'])->name('gcc.news.edit');
Route::post('/gcc/news/update/{id}', [GccNewsController::class, 'update'])->name('gcc.news.update');
Route::get('/gcc/news/delete/{id}', [GccNewsController::class, 'destroy'])->name('gcc.news.delete');
Route::get('/gcc/news/status/{status}/{id}', [GccNewsController::class, 'status'])->name('gcc.status.update');


//=======================EMC CRPC Section===============//
Route::group(['prefix' => 'setting/emc/', 'as' => 'setting.emc.'], function () {
    Route::get('crpc-section', [EmcSettingController::class, 'crpcSections'])->name('crpcsection');
    Route::get('crpc-section/add', [EmcSettingController::class, 'crpcSectionsCreate'])->name('crpcsection.add');
    Route::post('crpc-section/save', [EmcSettingController::class, 'crpcSectionsSave'])->name('crpcsection.save');
    Route::get('crpc-section/edit/{id}', [EmcSettingController::class, 'crpcSectionsEdit'])->name('crpcsection.edit');
    Route::post('crpc-section/update/{id}', [EmcSettingController::class, 'crpcSectionsUpdate'])->name('crpcsection.update');
});

// mobile court golpo upload
Route::middleware('auth')->group(function () {
    Route::get('/misnotification/levelConfig', [MisnotificationController::class, 'levelConfig'])->name('misnotification.levelConfig');
    Route::get('misnotification/getNotificationsData/{id}', [MisnotificationController::class, 'getNotificationsData'])->name('misnotification.getNotificationsData');
    Route::post('/misnotification/createNotificationsData', [MisnotificationController::class, 'createNotificationsData'])->name('misnotification.createNotificationsData');
    Route::get('/misnotification/pendingReportList', [MisnotificationController::class, 'pendingReportList'])->name('misnotification.pendingReportList');
    Route::post('/misnotification/printmobilecourtreport', [MisnotificationController::class, 'printmobilecourtreport'])->name('misnotification.printmobilecourtreport');
    Route::post('/misnotification/printappealcasereport', [MisnotificationController::class, 'printappealcasereport'])->name('misnotification.printappealcasereport');
    Route::post('/misnotification/printadmcasereport', [MisnotificationController::class, 'printadmcasereport'])->name('misnotification.printadmcasereport');
    Route::post('/misnotification/printemcasereport', [MisnotificationController::class, 'printemcasereport'])->name('misnotification.printemcasereport');
    Route::post('/misnotification/printcourtvisitreport', [MisnotificationController::class, 'printcourtvisitreport'])->name('misnotification.printcourtvisitreport');
    Route::post('/misnotification/printcaserecordreport', [MisnotificationController::class, 'printcaserecordreport'])->name('misnotification.printcaserecordreport');
    Route::get('/misnotification/defaultSms_send', [MisnotificationController::class, 'defaultSms_send'])->name('misnotification.defaultSms_send');
    
    Route::post('/misnotification/sendLevelThreeMessage', [MisnotificationController::class, 'sendLevelThreeMessage'])->name('misnotification.sendLevelThreeMessage');
    Route::get('/misnotification/approvedReportList', [MisnotificationController::class, 'approvedReportList'])->name('misnotification.approvedReportList');
    Route::get('/misnotification/getReportsData', [MisnotificationController::class, 'getReportsData'])->name('misnotification.getReportsData');
   
    Route::get('/monthly_report/report', [MonthlyReportController::class, 'report'])->name('mc.monthly_report');
    Route::post('/monthly_report/getMisReportList', [MonthlyReportController::class, 'getMisReportList'])->name('mc.monthly_report.getMisReportList');
    Route::post('/monthly_report/printcountrymobilecourtreport', [MonthlyReportController::class, 'printcountrymobilecourtreport'])->name('mc.monthly_report.printcountrymobilecourtreport');
    Route::post('/monthly_report/printdivmobilecourtreport', [MonthlyReportController::class, 'printdivmobilecourtreport'])->name('mc.monthly_report.printdivmobilecourtreport');
    Route::post('/monthly_report/printdivappealcasereport', [MonthlyReportController::class, 'printdivappealcasereport'])->name('mc.monthly_report.printdivappealcasereport');
    Route::post('/monthly_report/printdivadmcasereport', [MonthlyReportController::class, 'printdivadmcasereport'])->name('mc.monthly_report.printdivadmcasereport');
    Route::post('/monthly_report/printdivemcasereport', [MonthlyReportController::class, 'printdivemcasereport'])->name('mc.monthly_report.printdivemcasereport');
    Route::post('/monthly_report/printdivapprovedreport', [MonthlyReportController::class, 'printdivapprovedreport'])->name('mc.monthly_report.printdivapprovedreport');
    Route::get('/monthly_report/ajaxDataCourt', [MonthlyReportController::class, 'ajaxDataCourt'])->name('mc.monthly_report.ajaxDataCourt');
    
    Route::post('/monthly_report/printmobilecourtreport', [MonthlyReportController::class, 'printmobilecourtreport'])->name('monthly_report.printmobilecourtreport');
    Route::post('/monthly_report/printappealcasereport', [MonthlyReportController::class, 'printappealcasereport'])->name('monthly_report.printappealcasereport');
    Route::post('/monthly_report/printadmcasereport', [MonthlyReportController::class, 'printadmcasereport'])->name('monthly_report.printadmcasereport');
    Route::post('/monthly_report/printemcasereport', [MonthlyReportController::class, 'printemcasereport'])->name('monthly_report.printemcasereport');
    Route::post('/monthly_report/printcourtvisitreport', [MonthlyReportController::class, 'printcourtvisitreport'])->name('monthly_report.printcourtvisitreport');
    Route::post('/monthly_report/printcaserecordreport', [MonthlyReportController::class, 'printcaserecordreport'])->name('monthly_report.printcaserecordreport');
    Route::post('/monthly_report/printmobilecourtstatisticreport', [MonthlyReportController::class, 'printmobilecourtstatisticreport'])->name('monthly_report.printmobilecourtstatisticreport');
    
    Route::get('/monthly_report/ajaxDataCase', [MonthlyReportController::class, 'ajaxDataCase'])->name('mc.monthly_report.ajaxDataCase');
    Route::get('/monthly_report/ajaxDataFine', [MonthlyReportController::class, 'ajaxDataFine'])->name('mc.monthly_report.ajaxDataFine');
    Route::get('/monthly_report/ajaxDataAppeal', [MonthlyReportController::class, 'ajaxDataAppeal'])->name('mc.monthly_report.ajaxDataAppeal');
    Route::get('/monthly_report/ajaxDataEm', [MonthlyReportController::class, 'ajaxDataEm'])->name('mc.monthly_report.ajaxDataEm');
    Route::get('/monthly_report/ajaxDataAdm', [MonthlyReportController::class, 'ajaxDataAdm'])->name('mc.monthly_report.ajaxDataAdm');
    Route::get('/monthly_report/dashboard/report', [MonthlyReportController::class, 'dashboard_monthly_report'])->name('mc.monthly_report.dashboard.report');
   
    // mc register
    Route::get('/register_list/register', [McRegisterListController::class, 'register'])->name('mc.registerlist');
    Route::post('/register_list/printcitizenregister', [McRegisterListController::class, 'printcitizenregister'])->name('mc.printcitizenregister');
    Route::post('/register_list/printdailyregister', [McRegisterListController::class, 'printdailyregister'])->name('mc.printdailyregister');
    Route::post('/register_list/printPunishmentJailRegister', [McRegisterListController::class, 'printPunishmentJailRegister'])->name('mc.printPunishmentJailRegister');
    Route::post('/register_list/printmonthlystatisticsregister', [McRegisterListController::class, 'printmonthlystatisticsregister'])->name('mc.printmonthlystatisticsregister');
    Route::post('/register_list/printlawbasedReport', [McRegisterListController::class, 'printlawbasedReport'])->name('printlawbasedReport');
    Route::post('/register_list/printPunishmentFineRegister', [McRegisterListController::class, 'printPunishmentFineRegister'])->name('mc.printPunishmentFineRegister'); 

    #-----------------------------
    #mc dashboard
    #-----------------------------
    Route::post('/dashboard/ajaxDataFineVSCase', [DashboardController::class, 'ajaxDataFineVSCase'])->name('mc.ajaxDataFineVSCase'); 
    Route::post('/dashboard/ajaxDashboardCriminalInformation', [DashboardController::class, 'ajaxDashboardCriminalInformation'])->name('mc.ajaxDashboardCriminalInformation'); 
    Route::post('/dashboard/ajaxdashboardCaseStatistics', [DashboardController::class, 'ajaxdashboardCaseStatistics'])->name('mc.ajaxdashboardCaseStatistics'); 
    Route::post('/dashboard/ajaxCitizen', [DashboardController::class, 'ajaxCitizen'])->name('mc.ajaxCitizen'); 
    Route::post('/dashboard/ajaxDataLocationVSCase', [DashboardController::class, 'ajaxDataLocationVSCase'])->name('mc.ajaxDataLocationVSCase'); 
    Route::post('/dashboard/ajaxDataLawVSCase', [DashboardController::class, 'ajaxDataLawVSCase'])->name('mc.ajaxDataLawVSCase'); 
    Route::get('/dashboard/monthlyReport', [DashboardController::class, 'monthlyReport'])->name('mc.monthlyReport');
 

});
Route::get('/misnotification/setReportDataUnapproved', [MisnotificationController::class, 'setReportDataUnapproved']);
// Route::group(['prefix' => 'emc/', 'as' => 'emc.'], function () {
//     Route::post('/dashboard/ajax-case-status', [DashboardController::class, 'ajaxCaseStatus'])->name('dashboard.case-status-report');
//     Route::post('/dashboard/ajax-payment-report', [DashboardController::class, 'ajaxPaymentReport'])->name('dashboard.payment-report');
//     Route::post('/dashboard/ajax-crpc-pie-chart', [DashboardController::class, 'ajaxPieChart'])->name('dashboard.crpc-pie-chart');
// });

