<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanKTP;
use Illuminate\Support\Facades\Cache;

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
        $data['getDataKTP'] = ScanKTP::orderBy('created_at', 'desc')->get();
        $view = view('content/ktp/form', $data);
        $put['title_content'] = 'Scan-KTP';
        $put['title_top'] = 'Scan-KTP';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        return view('layout.mainLayout', $put);
    }

    public function hasilscan(Request $request)
    {
        $extractedData = Cache::get('extracted_data');

        if (!$extractedData) {
            return redirect()->back()->with('error', 'No data found in cache.');
        }

        $existingData = ScanKTP::all()->toArray();

        $data = [];
        foreach ($extractedData as $index => $extracted) {
            $nik = isset($extracted['nik']) ? $extracted['nik'] : null;
            $nama = isset($extracted['nama']) ? $extracted['nama'] : null;
            $addressDetails = isset($extracted['addressDetails']) ? $extracted['addressDetails'] : null;
            $isSaved = false;
            foreach ($existingData as $existing) {
                if ($existing['nik'] == $nik) {
                    $isSaved = true;
                    break;
                }
            }
            $data[] = [
                'title' => 'Data KTP',
                'cardTitle' => 'Hasil Scan KTP',
                'nik' => $nik,
                'nama' => $nama,
                'addressDetails' => $addressDetails,
                'is_saved' => $isSaved,
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


    public function getDataKtp(Request $request)
    {
        $nik = $request->query('nik');
        if ($nik) {
            $data['ktp'] = ScanKTP::where('nik', $nik)->get();
        } else {
            $data['ktp'] = ScanKTP::get();
        }
        return response()->json($data);
    }
}
