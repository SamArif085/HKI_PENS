<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\api\ScanKTPAPIController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('hasil-scan-ktp', 'App\Http\Controllers\api\APIScanKTPController@scancard')->name('scancard');
Route::post('submit-scan-ktp', 'App\Http\Controllers\api\APIScanKTPController@submit')->name('submit');
Route::post('submit-scan-dokumen', 'App\Http\Controllers\api\ApiScanDokumenController@submitDokumen')->name('submit-dokumen');
