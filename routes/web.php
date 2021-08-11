<?php

use App\Http\Controllers\CBEMController;
use App\Http\Controllers\CDPMController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\VoterController;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [PageController::class, 'home'])->name('home')->middleware('votedirection');

Route::get('/home', [PageController::class, 'home'])->name('home')->middleware('votedirection');

Route::get('/vote/dpm', [PageController::class, 'voteDpm'])->name('votedpm')->middleware(['auth', 'votedirection']);
Route::get('/vote/bem', [PageController::class, 'voteBem'])->name('votebem')->middleware(['auth', 'votedirection']);

Route::post('/logout', [VoterController::class, 'logout'])->name('logout')->middleware(['auth']);

Route::post('/vote/dpm/{nomor_urut}', [VoterController::class, 'voteDpm'])->middleware(['auth']);
Route::post('/vote/bem/{nomor_urut}', [VoterController::class, 'voteBem'])->middleware(['auth']);

Route::view('/manager', 'admin'); # Ini Route Vue!!!
Route::view('/manager/login', 'loginAdmin'); # Ini Route Vue!!!
Route::view('/manager/{app}', 'admin')->where('app', '.*'); # Ini Route Vue!!!
