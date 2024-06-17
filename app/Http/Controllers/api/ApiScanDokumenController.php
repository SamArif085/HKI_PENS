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
        $existingData = DB::table('dokumen_pc')
            ->where('nama_pencipta', $data['namaPencipta'])
            ->first();

        if ($existingData) {
            DB::table('dokumen_pc')
                ->where('id', $existingData->id)
                ->update([
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

            $message = 'Data berhasil diperbarui.';
        } else {
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

            $message = 'Data berhasil disimpan.';
        }

        return response()->json(['message' => $message]);
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $data = $request->all();
        $updateData = [
            'nama_pencipta' => $data['nama'],
            'wn_pencipta' => $data['wn'],
            'alamat_pencipta' => $data['alamat'],
            'email_pencipta' => $data['email'],
            'no_hp_pencipta' => $data['hp'],
            'nama_pg_hak' => $data['namapghak'],
            'wn_pg_hak' => $data['wnpghak'],
            'alamat_pg_hak' => $data['alamatpghak'],
            'email_pg_hak' => $data['emailpghak'],
            'jenis_cipta' => $data['jenis'],
            'tgl_tempat' => $data['tgl'],
            'uraian_cipta' => $data['uraian'],
        ];
        DB::table('dokumen_pc')->where('id', $id)->update($updateData);

        $message = 'Data berhasil diperbarui.';

        return response()->json(['message' => $message]);
    }
}
