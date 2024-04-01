<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\permohonan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class SuratPermohonan extends Controller
{
    public function tambahPermohonan(Request $request)
    {
        // dd($request->all());
        $nama = $request->nama;
        $perusahaan = $request->perusahaan;
        $alamat = $request->alamat;
        $kuasa_alamat  = $request->kuasa;
        $telepon  = $request->telepon;
        $email  = $request->email;
        $lisensi   = $request->lisensi;
        $pemilik_hak = $request->pemilik_hak;
        $penerima_hak = $request->penerima_hak;
        $sejak_tanggal = $request->sejak_tanggal;
        $sampai_tanggal = $request->sampai_tanggal;


        DB::transaction(
            function () use ($nama, $perusahaan, $alamat, $kuasa_alamat, $telepon, $email, $lisensi, $pemilik_hak, $penerima_hak, $sejak_tanggal, $sampai_tanggal) {
                DB::table('permohonan')->insert([
                    'nama' => $nama,
                    'perusahaan' => $perusahaan,
                    'alamat' => $alamat,
                    'kuasaalamat' =>  $kuasa_alamat,
                    'telepon' => $telepon,
                    'email' => $email,
                    'lisensi' => $lisensi,
                    'pemilik_hak' => $pemilik_hak,
                    'penerima_hak' => $penerima_hak,
                    'sejak_tanggal' => $sejak_tanggal,
                    'sampai_tanggal' => $sampai_tanggal,
                ]);
            }
        );
        return redirect()->route('suratpermohonan');
    }
}
