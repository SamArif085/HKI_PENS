<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuratPermohonan;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::post('cek', [LoginController::class, 'cekLogin'])->name('cekLogin');

Route::get('dashboardAdmin', [HomeController::class, 'index'])->name('dashboardAdmin')->middleware('auth');
Route::get('suratpermohonan', [HomeController::class, 'suratpermohonan'])->name('suratpermohonan')->middleware('auth');
Route::get('dataktp', [HomeController::class, 'dataktp'])->name('dataktp')->middleware('auth');

Route::post('tambahPermohonan', [SuratPermohonan::class, 'tambahPermohonan'])->name('tambahPermohonan');


Route::get('/hasilpermohonan', [HomeController::class, 'hasilpermohonan'])->name('hasilpermohonan');
Route::post('parse-pdf', [PDFController::class, 'parse'])->name('parse.pdf')->middleware('auth');
