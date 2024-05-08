<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\ScanDokumenController as ApiScanDokumenController;
use Illuminate\Http\Request;

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
        $view = view('content/suratpermohonan/form', $data);
        $put['title_content'] = 'Scan-Dokumen';
        $put['title_top'] = 'Scan-Dokumen';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        // dd($put);
        return view('layout.mainLayout', $put);
    }

    public function hasilscan(Request  $request)
    {
        $data = $request->all();
        $data['home'] = [
            'title' => 'Data KTP',
            'cardTitle' => 'Masukan Scan KTP',
        ];
        $view = view('content/SuratPermohonan/hasil', $data);
        $put['title_content'] = 'Scan-KTP';
        $put['title_top'] = 'Scan-KTP';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        // dd($put);
        return view('layout.mainLayout', $put);
    }
}
