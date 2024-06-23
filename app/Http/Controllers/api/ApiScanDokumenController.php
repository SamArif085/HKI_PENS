<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Models\DokumenPermohonanCipta;

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

    public function parse(Request $request)
    {
        $file = $request->data['file'];
        $pdfFile = $file;

        $parser = new Parser();
        try {
            $pdf = $parser->parseFile($pdfFile);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca file PDF. Mohon unggah file yang benar.');
        }

        $pages = $pdf->getPages();
        $data = [];
        $currentData = [];
        $dataValid = false;

        foreach ($pages as $pageNumber => $page) {
            $text = $page->getText();

            preg_match_all('/I\.\s*Pencipta\s*:(.*?)^(?=\bII\.|\z)/ms', $text, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $currentData['pencipta'] = $this->parsePencipta($match[1]);
            }

            preg_match_all('/II\.\s*Pemegang\s+Hak\s+Cipta\s*:(.*?)(?=III|$)/s', $text, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $currentData['pemegang_hak'] = $this->parsePemegangHak($match[1]);
            }

            preg_match('/III\.\s*Jenis\s+dari\s+judul\s+ciptaan\s+yang\s+dimohonkan\s*:\s*([^IV]+)/s', $text, $matches);
            $jenisCiptaan = trim($matches[1] ?? '');

            preg_match('/Di\s+([^,\n\r]+,\s+\d+\s+\w+\s+\d+)/', $text, $matches);
            $tanggalDanTempat = trim($matches[1] ?? '');

            preg_match('/V\.\s*Uraian\s+ciptaan\s*:\s*([\s\S]*?)^\s*$/m', $text, $matches);
            $uraianCiptaan = trim($matches[1] ?? '');

            $uraianCiptaan = preg_replace('/\s+/', ' ', $uraianCiptaan);
            $currentData['jenis_ciptaan'] = $jenisCiptaan;
            $currentData['tanggal_dan_tempat'] = $tanggalDanTempat;
            $currentData['uraian_ciptaan'] = $uraianCiptaan;

            if (!empty($currentData['pencipta']) && !empty($currentData['pemegang_hak']) && !empty($jenisCiptaan) && !empty($tanggalDanTempat) && !empty($uraianCiptaan)) {
                $dataValid = true;
            }

            $data[] = $currentData;
            $currentData = [];
        }

        if (!$dataValid) {
            return redirect()->back()->with('error', 'Dokumen tidak cocok dengan fitur scan dokumen permohonan. Mohon masukan data file yang benar.');
        }

        $hasilDokumen = ['data' => $data];
        $cacheKey = 'hasilDokumen_' . uniqid();
        Cache::put($cacheKey, $hasilDokumen, 600);

        return response()->json([
            'success' => true,
            'cacheKey' => $cacheKey,
        ]);
    }

    private function parsePencipta($text)
    {
        $no_hp = '';
        $email = '';

        preg_match('/1\.\s*Nama\s*:\s*([^\n]+)/', $text, $matches);
        $nama = trim($matches[1] ?? '');

        preg_match('/2\.\s*Kewarganegaraan\s*:\s*([^\n]+)/', $text, $matches);
        $kewarganegaraan = trim($matches[1] ?? '');

        preg_match('/3\.\s*Alamat\s*:\s*(.*?)(?=\s*4\.|\z)/s', $text, $matches);
        $alamat = isset($matches[1]) ? trim(preg_replace('/\s+/', ' ', $matches[1])) : '';

        preg_match('/5\.\s*No\. HP & E-mail\s*:\s*\+(\d+)\s*&\s*([^\n]+)/', $text, $matches);
        if (isset($matches[1])) {
            $no_hp = '+' . trim($matches[1]);
            $email = trim($matches[2]);
        } else {
            preg_match('/5\.\s*No\. HP & E-mail\s*:\s*(?:\+(\d+)\s*&\s*([^\s]+)\s*|\s*([^\s]+)\s*&\s*([^\n]+))/s', $text, $matches);
            if (isset($matches[1])) {
                $no_hp = '+' . trim($matches[1]);
                $email = trim($matches[2]);
            } else {
                preg_match('/5\.\s*No\. HP & E-mail\s*:\s*([^\n]+)/', $text, $matches);
                if (isset($matches[1])) {
                    if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
                        $email = trim($matches[1]);
                    } else {
                        $no_hp = trim($matches[1]);
                    }
                }
            }
        }
        // dd($text);
        return [
            'nama' => $nama,
            'kewarganegaraan' => $kewarganegaraan,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'email' => $email,
        ];
    }

    private function parsePemegangHak($text)
    {
        preg_match('/1\.\s*Nama\s*:\s*([^\n]+)/', $text, $matches);
        $nama = trim($matches[1] ?? '');

        preg_match('/2\.\s*Kewarganegaraan\s*:\s*([^\n]+)/', $text, $matches);
        $kewarganegaraan = trim($matches[1] ?? '');

        preg_match('/3\.\s*Alamat\s*:\s*(.*?)(?:4\.|Telepon :|\n\n|$)/s', $text, $matches);
        $alamat = trim($matches[1] ?? '');

        preg_match('/No\. HP & E-mail\s*:\s*([^&]+)/', $text, $matches);
        $email = trim($matches[1] ?? '');

        $alamat = preg_replace('/\s+/', ' ', $alamat);
        return [
            'nama' => $nama,
            'kewarganegaraan' => $kewarganegaraan,
            'alamat' => $alamat,
            'email' => $email,
        ];
    }

    public function submitAllData(Request $request)
    {
        try {
            $xData = $request->input('x_data');

            DB::beginTransaction();

            $updatedCount = 0;
            $newCount = 0;

            foreach ($xData as $data) {
                if ($data['found']) {
                    DokumenPermohonanCipta::where('id', $data['id'])->update([
                        'nama_pencipta' => $data['nama'],
                        'wn_pencipta' => $data['kewarganegaraan'],
                        'alamat_pencipta' => $data['alamat_pencipta'],
                        'email_pencipta' => $data['email_pencipta'],
                        'no_hp_pencipta' => $data['no_hp_pencipta'],
                        'nama_pg_hak' => $data['nama_pemegang_hak'],
                        'wn_pg_hak' => $data['kewarganegaraan_pemegang_hak'],
                        'alamat_pg_hak' => $data['alamat_pemegang_hak'],
                        'email_pg_hak' => $data['email_pemegang_hak'],
                        'jenis_cipta' => $data['jenis_ciptaan'],
                        'tgl_tempat' => $data['tanggal_dan_tempat'],
                        'uraian_cipta' => $data['uraian_ciptaan'],
                    ]);
                    $updatedCount++;
                } else {
                    DokumenPermohonanCipta::create([
                        'nama_pencipta' => $data['nama'],
                        'wn_pencipta' => $data['kewarganegaraan'],
                        'alamat_pencipta' => $data['alamat_pencipta'],
                        'email_pencipta' => $data['email_pencipta'],
                        'no_hp_pencipta' => $data['no_hp_pencipta'],
                        'nama_pg_hak' => $data['nama_pemegang_hak'],
                        'wn_pg_hak' => $data['kewarganegaraan_pemegang_hak'],
                        'alamat_pg_hak' => $data['alamat_pemegang_hak'],
                        'email_pg_hak' => $data['email_pemegang_hak'],
                        'jenis_cipta' => $data['jenis_ciptaan'],
                        'tgl_tempat' => $data['tanggal_dan_tempat'],
                        'uraian_cipta' => $data['uraian_ciptaan'],
                    ]);
                    $newCount++;
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.',
                'updated_count' => $updatedCount,
                'new_count' => $newCount,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
