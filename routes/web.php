<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\web\ScanKTPController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuratPermohonanController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ScanCardController;
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

// Route::post('tambahPermohonan', [SuratPermohonanController::class, 'tambahPermohonan'])->name('tambahPermohonan');

Route::post('/parse-pdf', [PDFController::class, 'parse'])->name('parse.pdf')->middleware('auth');


Route::get('/dashboardAdmin', 'App\Http\Controllers\web\DashbaordHomeController@index')->name('dashboardAdmin')->middleware('auth');

Route::get('/Scan-Dokumen', 'App\Http\Controllers\web\ScanDokumenController@index')->middleware('auth')->name('Scan-Dokumen');
Route::get('/Hasil-Scan-Dokumen', 'App\Http\Controllers\web\ScanDokumenController@hasilscan')->middleware('auth')->name('hasil-Dokumen');

Route::get('/Scan-KTP', 'App\Http\Controllers\web\ScanKTPController@index')->middleware('auth')->name('Scan-KTP');
Route::get('/hasil-scan-ktp', 'App\Http\Controllers\web\ScanKTPController@hasilscan')->middleware('auth')->name('hasil-scan-ktp');
