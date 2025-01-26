<?php

use App\Http\Controllers\EmcAppealListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSOController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\gcc\GccController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\emc\CourtController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\EmcSettingController;
use App\Http\Controllers\gcc\ReportController;
use App\Http\Controllers\GccSettingController;
use App\Http\Controllers\DoptorLoginController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\doptor\NDoptorUserData;
use App\Http\Controllers\CitizenAppealController;
use App\Http\Controllers\DependentDataController;
use App\Http\Controllers\emc\EmcReportController;
use App\Http\Controllers\CauseListController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\PeshkarSettingController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ApiCitizenCheckController;
use App\Http\Controllers\mobilecourt\CriminalController;
use App\Http\Controllers\mobilecourt\MobileCourtController;
use App\Http\Controllers\citizen\CitizenAppealListController;
use App\Http\Controllers\CertificateAssistentSettingController;
use App\Http\Controllers\citizen\CitizenRegistrationController;
use App\Http\Controllers\citizen\GccCitizenAppealListController;
use App\Http\Controllers\emc_citizen\EmcCitizenAppealController;
use App\Http\Controllers\emc_citizen\EmcCitizenRegisterController;
use App\Http\Controllers\gcc\CourtController as GccCourtController;
use App\Http\Controllers\emc_citizen\EmcCitizenAppealListController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GccParentOfficeController;



//emc archive
Route::get('/emc/closed_list', [EmcAppealListController::class, 'closed_list'])->name('emc.closed_list');
Route::post('/emc/closed_list/search', [EmcAppealListController::class, 'closed_list_search'])->name('emc.closed_list.search');
Route::get('/emc/old_closed_list', [EmcAppealListController::class, 'old_closed_list'])->name('emc.old_closed_list');
Route::post('/emc/old_closed_list/search', [EmcAppealListController::class, 'old_closed_list_search'])->name('emc.old_closed_list.search');
Route::get('/emc/old_closed_list/details/{id}', [EmcAppealListController::class, 'showAppealViewPage'])->name('emc.showAppealViewPage');

Route::get('/emc/appeal/details/{id}', [EmcAppealListController::class, 'showAppealDetails'])->name('emc.show.appeal.details');
Route::get('/emc/appeal/case-traking/{id}', [EmcAppealListController::class, 'case_traking'])->name('emc.show.appeal.case.traking');
Route::get('/emc/appeal/nothiView/{id}', [EmcAppealListController::class, 'emc_close_case_nothiView'])->name('emc.show.appeal.case.nothiView');
Route::get('/emc/appeal/orderSheetDetails/{id}', [EmcAppealListController::class, 'emc_close_case_orderSheetDetails'])->name('emc.show.appeal.case.orderSheetDetails');
Route::get('/emc/appeal/shortOrderSheets/{id}', [EmcAppealListController::class, 'emc_close_case_shortOrderSheets'])->name('emc.show.appeal.case.shortOrderSheets');

// Route::middleware('auth')->group(function () {
//     Route::group(['prefix' => 'gcc/', 'as' => 'gcc.'], function () {
//         Route::get('/download/form', [EmcFormDownLoadController::class, 'index'])->name('download.form');
//     });
// });