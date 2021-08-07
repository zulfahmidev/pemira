<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CBEMController;
use App\Http\Controllers\CDPMController;
use App\Http\Controllers\QuickCountController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VoterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::prefix('admin')->group(function() {

    Route::prefix('candidate')->group(function() {

        // BEM
        Route::get('bem', [CBEMController::class, 'index']);
        Route::get('bem/{nomor_urut}', [CBEMController::class, 'show']);
        Route::post('bem', [CBEMController::class, 'store'])->middleware(['adminauth']);
        Route::post('bem/{nomor_urut}', [CBEMController::class, 'update'])->middleware(['adminauth']);
        Route::delete('bem/{nomor_urut}', [CBEMController::class, 'destroy'])->middleware(['adminauth']);
        
        // DPM
        Route::get('dpm', [CDPMController::class, 'index']);
        Route::get('dpm/{nomor_urut}', [CDPMController::class, 'show']);
        Route::post('dpm', [CDPMController::class, 'store'])->middleware(['adminauth']);
        Route::post('dpm/{nomor_urut}', [CDPMController::class, 'update'])->middleware(['adminauth']);
        Route::delete('dpm/{nomor_urut}', [CDPMController::class, 'destroy'])->middleware(['adminauth']);

    });

    Route::prefix('voter')->group(function() {

        Route::post('import', [VoterController::class, 'import'])->middleware(['adminauth']);
        Route::post('reset', [VoterController::class, 'reset'])->middleware(['adminauth']);
        Route::post('broadcast_password', [VoterController::class, 'broadcastPassword'])->middleware(['adminauth']);
        Route::post('login', [VoterController::class, 'login']);
        Route::post('logout', [VoterController::class, 'logout'])->middleware(['voterauth']);
    });
    
    Route::prefix('setting')->group(function() {

        Route::post('/init', [SettingController::class, 'init'])->middleware(['adminauth']);
        // Route::post('/', [SettingController::class, 'set']);
        Route::get('/{key}', [SettingController::class, 'get']);
    });

    Route::post('vote/bem/{nomor_urut}', [VoterController::class, 'voteBem'])->middleware(['voterauth']);
    Route::post('vote/dpm/{nomor_urut}', [VoterController::class, 'voteDpm'])->middleware(['voterauth']);

    Route::get('quickcount', [QuickCountController::class, 'index']);
    
    Route::delete('admin/{name}', [AdminAuthController::class, 'destroy'])->middleware(['adminauth']); // matikan
    Route::post('admin/logout', [AdminAuthController::class, 'logout'])->middleware(['adminauth']);
    Route::post('admin/register', [AdminAuthController::class, 'register']); // matikan
    Route::post('admin/login', [AdminAuthController::class, 'login']);
// });