<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\AccessPermissionController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\TimeCapsuleController;
use App\Http\Controllers\ClaimGuideController;
use App\Http\Controllers\NotaryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\InheritanceController;

Route::middleware('auth:sanctum')->group(function () {
    // Vault Dokumen
    Route::get('/vault', [VaultController::class, 'index']);
    Route::post('/vault', [VaultController::class, 'store']);
    Route::get('/vault/{id}', [VaultController::class, 'show']);
    Route::delete('/vault/{id}', [VaultController::class, 'destroy']);

    // Akses Berjenjang
    Route::post('/access', [AccessPermissionController::class, 'store']);
    Route::get('/access/{document_id}', [AccessPermissionController::class, 'index']);
    Route::delete('/access/{id}', [AccessPermissionController::class, 'destroy']);

    // Pengingat
    Route::get('/reminders', [ReminderController::class, 'index']);
    Route::post('/reminders', [ReminderController::class, 'store']);
    Route::get('/reminders/{id}', [ReminderController::class, 'show']);
    Route::put('/reminders/{id}', [ReminderController::class, 'update']);
    Route::delete('/reminders/{id}', [ReminderController::class, 'destroy']);

    // Kapsul Waktu
    Route::get('/capsules', [TimeCapsuleController::class, 'index']);
    Route::post('/capsules', [TimeCapsuleController::class, 'store']);
    Route::get('/capsules/{id}', [TimeCapsuleController::class, 'show']);
    Route::post('/capsules/{id}/unlock', [TimeCapsuleController::class, 'unlock']);
    Route::delete('/capsules/{id}', [TimeCapsuleController::class, 'destroy']);

    // Panduan Klaim
    Route::get('/claim-guides', [ClaimGuideController::class, 'index']);
    Route::get('/claim-guides/institution/{institution}', [ClaimGuideController::class, 'byInstitution']);
    Route::get('/claim-guides/{id}', [ClaimGuideController::class, 'show']);
    Route::post('/claim-guides', [ClaimGuideController::class, 'store']);
    Route::put('/claim-guides/{id}', [ClaimGuideController::class, 'update']);
    Route::delete('/claim-guides/{id}', [ClaimGuideController::class, 'destroy']);

    // Mitra Notaris
    Route::get('/notaries', [NotaryController::class, 'index']);
    Route::get('/notaries/search', [NotaryController::class, 'search']);
    Route::get('/notaries/{id}', [NotaryController::class, 'show']);
    Route::post('/notaries', [NotaryController::class, 'store']);
    Route::put('/notaries/{id}', [NotaryController::class, 'update']);
    Route::delete('/notaries/{id}', [NotaryController::class, 'destroy']);

    // Aset Mapper
    Route::get('/assets', [AssetController::class, 'index']);
    Route::post('/assets', [AssetController::class, 'store']);
    Route::get('/assets/summary', [AssetController::class, 'summary']);
    Route::get('/assets/{id}', [AssetController::class, 'show']);
    Route::put('/assets/{id}', [AssetController::class, 'update']);
    Route::delete('/assets/{id}', [AssetController::class, 'destroy']);

    // Simulasi Waris
    Route::get('/inheritance', [InheritanceController::class, 'index']);
    Route::post('/inheritance', [InheritanceController::class, 'store']);
    Route::get('/inheritance/{id}', [InheritanceController::class, 'show']);
    Route::delete('/inheritance/{id}', [InheritanceController::class, 'destroy']);
});