<?php

use App\Http\Controllers\GccFormDownLoadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\citizen\CitizenAppealController;
use App\Http\Controllers\citizen\GccCitizenAppealListController;
use App\Http\Controllers\citizen\CitizenAppealViewController;
use App\Http\Controllers\GccAppealListController;

Route::middleware(['gccrouteprotectCitizen'])->group(function () {
    Route::group(['prefix' => 'citizen/', 'as' => 'citizen.'], function () {
        Route::get('appeal/create', [CitizenAppealController::class, 'create'])->name('appeal.create');

        Route::get('appeal/edit/{id}', [CitizenAppealController::class, 'edit'])->name('appeal.edit');
        Route::post('appeal/kharij_application', [CitizenAppealController::class, 'kharij_application'])->name('appeal.kharij_application');
        Route::get('appeal/list', [GccCitizenAppealListController::class, 'index'])->name('appeal.index');
        Route::get('appeal/all_case', [GccCitizenAppealListController::class, 'all_case'])->name('appeal.all_case');
        Route::get('appeal/pending_list', [GccCitizenAppealListController::class, 'pending_list'])->name('appeal.pending_list');
        Route::get('appeal/draft_list', [GccCitizenAppealListController::class, 'draft_list'])->name('appeal.draft_list');
        Route::get('appeal/rejected_list', [GccCitizenAppealListController::class, 'rejected_list'])->name('appeal.rejected_list');
        Route::get('appeal/closed_list', [GccCitizenAppealListController::class, 'closed_list'])->name('appeal.closed_list');
        Route::get('appeal/postponed_list', [GccCitizenAppealListController::class, 'postponed_list'])->name('appeal.postponed_list');
        Route::get('appeal/trial_date_list', [GccCitizenAppealListController::class, 'trial_date_list'])->name('appeal.trial_date_list');
        Route::get('appeal/view/{id}', [CitizenAppealViewController::class, 'showAppealViewPage'])->name('appeal.appealView');
    });
});

Route::group(['prefix' => 'api/citizen/', 'as' => 'api.citizen.', 'middleware' => 'gccrouteprotectCitizen'], function () {
    Route::post('appeal/response/store', [CitizenAppealController::class, 'response_for_store'])->name('appeal.response.store');
});

//arhieve module

Route::get('/gcc/closed_list', [GccAppealListController::class, 'closed_list'])->name('gcc.closed_list');
Route::post('/gcc/closed_list/search', [GccAppealListController::class, 'closed_list_search'])->name('gcc.closed_list.search');
Route::get('/gcc/closed_list/detais/{id}', [GccAppealListController::class, 'closed_list_details'])->name('gcc.closed_list.details');
Route::get('/gcc/closed_list/nothi/{id}', [GccAppealListController::class, 'closed_list_nothi'])->name('gcc.closed_list.nothi');
Route::get('/gcc/old_closed_list', [GccAppealListController::class, 'old_closed_list'])->name('gcc.old_closed_list');
Route::post('/gcc/old_closed_list/search', [GccAppealListController::class, 'old_closed_list_search'])->name('gcc.old_closed_list.search');
Route::get('/gcc/old_closed_list/details/{id}', [GccAppealListController::class, 'showAppealViewPage'])->name('gcc.showAppealViewPage');
Route::get('/generate-pdf/{id}', [GccAppealListController::class, 'generate_pdf'])->name('gcc.generate.pdf');


Route::get('/gcc/appeal/get/orderSheets/{id}', [GccAppealListController::class, 'gcc_appeal_order_sheet'])->name('gcc.appeal.order.sheet');
Route::get('/gcc/appeal/get/shortorderSheets/{id}', [GccAppealListController::class, 'gcc_appeal_short_order_sheet'])->name('gcc.appeal.short.order.sheet');

// Route::middleware('auth')->group(function () {
//     Route::group(['prefix' => 'gcc/', 'as' => 'gcc.'], function () {
       
//     });
// });