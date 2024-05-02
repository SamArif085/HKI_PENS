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

    public function add()
    {
        $data['data'] = [];
        $view = view('page.mou.leveling.form.formadd', $data);
        $put['title_content'] = 'Tambah Leveling';
        $put['title_top'] = 'Tambah Leveling';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;

        return view('template.main', $put);
    }

    public function ubah(Request $request)
    {
        $api = new ApiScanDokumenController();
        $data = $request->all();
        $data['data'] = $api->getDetailData($data['id'])->original;
        $view = view('page.mou.leveling.form.formadd', $data);

        $put['title_content'] = 'Ubah Leveling';
        $put['title_top'] = 'Ubah Leveling';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        return view('template.main', $put);
    }

    public function hasilscan(Request  $request)
    {
        $data = $request->all();
        dd($data);

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
