<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Dashboard Admin',
            'cardTitle' => 'Dashboard Admin',
        ];

        return view('content/dashboardAdmin', $data);
    }

    public function suratpermohonan()
    {

        $data = [
            'title' => 'Surat Permohonan',
            'cardTitle' => 'Surat Permohonan',
        ];
        return view('content/suratpermohonan/suratpermohonan', $data);
    }

    // public function dataktp()
    // {

    //     $data = [
    //         'title' => 'Data KTP',
    //         'cardTitle' => 'Masukan Scan KTP',
    //     ];
    //     return view('content/ktp/form', $data);
    // }

    public function hasilpermohonan(Request  $request)
    {
        $data = $request->all();

        // dd($data);
        return view('content/suratpermohonan/hasil', $data);
    }

    // public function hasilscan(Request  $request)
    // {
    //     $parsedText = $request->input('parsedText');
    //     $error = $request->input('error');

    //     return view('content/ktp/hasil', compact('parsedText', 'error'));
    // }
}
