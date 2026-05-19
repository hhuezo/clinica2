<?php

use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('catalog')->group(function () {
    Route::get('countries', [CatalogController::class, 'countries']);
    Route::get('departments', [CatalogController::class, 'departments']);
    Route::get('districts', [CatalogController::class, 'districts']);
    Route::get('document-types', [CatalogController::class, 'documentTypes']);
    Route::get('kinships', [CatalogController::class, 'kinships']);
});

Route::middleware('auth')->group(function () {
    Route::apiResource('patients', PatientController::class)->only(['index', 'store', 'show']);
    Route::apiResource('appointments', AppointmentController::class)->only(['index', 'store', 'update']);

    Route::prefix('clinic')->group(function () {
        Route::get('/', [ClinicController::class, 'index']);
        Route::post('/', [ClinicController::class, 'store']);
        Route::post('{clinic}/branches', [ClinicController::class, 'storeBranch']);
        Route::get('branches', [ClinicController::class, 'branches']);
        Route::get('doctors', [ClinicController::class, 'doctors']);
        Route::post('doctors', [ClinicController::class, 'storeDoctor']);
    });
});
