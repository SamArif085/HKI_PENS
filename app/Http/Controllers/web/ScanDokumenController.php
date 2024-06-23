<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\DokumenPermohonanCipta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ScanDokumenController extends Controller
{
    public function getTitleParent()
    {
        return "Scan Dokumen";
    }

    public function getJs()
    {
        return asset('assets/controller/ScanDokumen.js');
    }

    public function index()
    {
        $data['data'] = [
            'title' => 'Data Dokumen',
            'cardTitle' => 'Masukan Scan Dokumen',
        ];
        $data['getDataDokumen'] = DokumenPermohonanCipta::orderBy('created_at', 'desc')->get();
        $view = view('content/SuratPermohonan/form', $data);
        $put['title_content'] = 'Scan-Dokumen';
        $put['title_top'] = 'Scan-Dokumen';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        // dd($put);
        return view('layout.mainLayout', $put);
    }

    public function hasilscan($cacheKey)
    {
        if (!Cache::has($cacheKey)) {
            return redirect()->route('Scan-Dokumen')->with('error', 'Data has expired. Please start again.');
        }
        $dataDokumen = DokumenPermohonanCipta::get();
        $hasilDokumen = Cache::get($cacheKey);
        $data['hasilDokumen'] = $hasilDokumen;
        $existingPencipta = $dataDokumen->map(function ($item) {
            return [
                'nama_pencipta' => $item->nama_pencipta,
                'uraian_cipta' => $item->uraian_cipta,
            ];
        })->toArray();

        $data['home'] = [
            'title' => 'Data Data Dokumen Permohonan',
            'cardTitle' => 'Hasil Scan Dokumen Permohonan',
        ];

        $data['existingPencipta'] = $existingPencipta;
        $view = view('content/SuratPermohonan/hasil', $data);

        $put['title_content'] = 'Scan-KTP';
        $put['title_top'] = 'Scan-KTP';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        return view('layout.mainLayout', $put);
    }


    public function getDataDokumen(Request $request)
    {
        $namaPencipta = $request->query('nama_pencipta');
        $uraianCiptaan = $request->query('uraian_cipta');
        if (!$namaPencipta || !$uraianCiptaan) {
            return response()->json([
                'error' => 'Harap berikan nilai untuk nama_pencipta dan uraian_cipta.'
            ], 400);
        }

        $data['dokumen_cek'] = DokumenPermohonanCipta::where('nama_pencipta', $namaPencipta)
            ->where('uraian_cipta', $uraianCiptaan)
            ->get();

        return response()->json($data);
    }
}
