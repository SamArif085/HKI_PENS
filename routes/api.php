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
Route::post('submit-edit-ktp', 'App\Http\Controllers\api\APIScanKTPController@edit')->name('submit-edit-ktp');

Route::post('submit-scan-dokumen', 'App\Http\Controllers\api\ApiScanDokumenController@submitDokumen')->name('submit-dokumen');
Route::post('submit-edit-dokumen', 'App\Http\Controllers\api\ApiScanDokumenController@edit')->name('submit-edit-dokumen');

Route::post('upload-signature', 'App\Http\Controllers\api\ApiScanTTDController@upload')->name('upload.signature');
