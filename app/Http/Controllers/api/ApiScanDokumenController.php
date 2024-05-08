<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiScanDokumenController extends Controller
{
    public function submitDokumen(Request $request)
    {
        $data = $request->all();
        DB::table('dokumen_pc')->insert([
            'nama_pencipta' => $data['namaPencipta'],
            'wn_pencipta' => $data['kewarganegaraanPencipta'],
            'alamat_pencipta' => $data['alamatPencipta'],
            'email_pencipta' => $data['emailPencipta'],
            'no_hp_Pencipta' => $data['noHpPencipta'],
            'nama_pg_Hak' => $data['namaPemegangHak'],
            'wn_pg_Hak' => $data['kewarganegaraanPemegangHak'],
            'alamat_pg_hak' => $data['alamatPemegangHak'],
            'email_pg_Hak' => $data['emailPemegangHak'],
            'jenis_cipta' => $data['jenisCiptaan'],
            'tgl_tempat' => $data['tanggalDanTempat'],
            'uraian_cipta' => $data['uraianCiptaan'],
        ]);

        return redirect()->route('Scan-Dokumen');
    }
    // public function submitDokumen(Request $request)
    // {
    //     // dd($data = $request->all());
    //     $data = $request->all();
    //     foreach ($data as $key => $value) {
    //         if (is_array($value)) {
    //             foreach ($value as $index => $val) {
    //                 if ($val === '') {
    //                     $data[$key][$index] = null;
    //                 }
    //             }
    //         } else {
    //             if ($value === '') {
    //                 $data[$key] = null;
    //             }
    //         }
    //     }

    //     $namaPencipta = $data['namaPencipta'];
    //     $wnPencipta = $data['kewarganegaraanPencipta'];
    //     $alamatPencipta = $data['alamatPencipta'];
    //     $emailPencipta = $data['emailPencipta'];
    //     $no_hpPencipta =  $data['noHpPencipta'];
    //     $nama_pg_Hak =  $data['namaPemegangHak'];
    //     $wn_pg_Hak = $data['kewarganegaraanPemegangHak'];
    //     $alamat_pg_hak = $data['alamatPemegangHak'];
    //     $email_pg_Hak = $data['emailPemegangHak'];
    //     $jenis_cipta = $data['jenisCiptaan'];
    //     $tgl_tempat = $data['tanggalDanTempat'];
    //     $uraian_cipta = $data['uraianCiptaan'];

    //     DB::transaction(function () use ($namaPencipta, $wnPencipta, $alamatPencipta, $emailPencipta, $no_hpPencipta, $nama_pg_Hak, $wn_pg_Hak, $alamat_pg_hak, $email_pg_Hak, $jenis_cipta, $tgl_tempat, $uraian_cipta) {
    //         foreach ($namaPencipta as $key => $nama) {
    //             DB::table('dokumen_pc')->insert([
    //                 'nama_pencipta' => $nama,
    //                 'wn_pencipta' => $wnPencipta[$key],
    //                 'alamat_pencipta' => $alamatPencipta[$key],
    //                 'email_pencipta' => $emailPencipta[$key],
    //                 'no_hp_Pencipta' => $no_hpPencipta[$key],
    //                 'nama_pg_Hak' => $nama_pg_Hak[$key],
    //                 'wn_pg_Hak' => $wn_pg_Hak[$key],
    //                 'alamat_pg_hak' => $alamat_pg_hak[$key],
    //                 'email_pg_Hak' => $email_pg_Hak[$key],
    //                 'jenis_cipta' => $jenis_cipta[$key],
    //                 'tgl_tempat' => $tgl_tempat[$key],
    //                 'uraian_cipta' => $uraian_cipta[$key],
    //             ]);
    //         }
    //     });

    //     return redirect()->route('Scan-Dokumen');
    // }
}
