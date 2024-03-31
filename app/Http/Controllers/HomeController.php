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
}
