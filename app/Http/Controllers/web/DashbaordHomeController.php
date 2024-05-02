<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashbaordHomeController extends Controller
{
    public function getTitleParent()
    {
        return "Dashboard";
    }

    public function getJs()
    {
        return asset('assets/controller/DashboardHome.js');
    }

    public function index()
    {
        $data['data'] = [
            'title' => 'Dashboard Home',
            'cardTitle' => 'Dashboard Home',
        ];
        $view = view('content/dashboardAdmin', $data);
        $put['title_content'] = 'Scan-KTP';
        $put['title_top'] = 'Scan-KTP';
        $put['title_parent'] = $this->getTitleParent();
        $put['js'] = $this->getJs();
        $put['view_file'] = $view;
        // dd($put);
        return view('layout.mainLayout', $put);
    }
}
