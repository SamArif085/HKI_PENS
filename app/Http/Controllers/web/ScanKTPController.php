<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScanKTPController extends Controller
{
    public function getTitleParent()
    {
        return "Scan KTP";
    }

    public function getJs()
    {
        return asset('assets/controller/ScanKTP.js');
    }

    public function index()
    {
        $data['data'] = [
            'title' => 'Data KTP',
            'cardTitle' => 'Masukan Scan KTP',
        ];
        $view = view('content/ktp/form', $data);
        $put['title_content'] = 'Scan-KTP';
        $put['title_top'] = 'Scan-KTP';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        // dd($put);
        return view('layout.mainLayout', $put);
    }

    public function hasilscan(Request $request)
    {
        $extractedData = $request->input('extractedData');
        $data = [];
        foreach ($extractedData as $index => $extracted) {
            $nik = isset($extracted['nik']) ? $extracted['nik'] : null;
            $nama = isset($extracted['nama']) ? $extracted['nama'] : null;
            $addressDetails = isset($extracted['addressDetails']) ? $extracted['addressDetails'] : null;
            $data[] = [
                'title' => 'Data KTP',
                'cardTitle' => 'Hasil Scan KTP',
                'nik' => $nik,
                'nama' => $nama,
                'addressDetails' => $addressDetails,
            ];
        }
        $view = view('content/ktp/hasil', compact('data'));
        $put['title_content'] = 'Scan-KTP';
        $put['title_top'] = 'Scan-KTP';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        return view('layout.mainLayout', $put);
    }
}
