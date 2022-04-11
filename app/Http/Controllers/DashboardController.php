<?php

namespace App\Http\Controllers;

use App\Services\DashboardDataService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(DashboardDataService $dataDashboard)
    {
        $dataUser = $dataDashboard->DashboardUser();
            
        return view('dashboard.dashboard', [
            'user'                  => $dataUser[0], 
            'jumlahGuru'            => $dataUser[1], 
            'jumlahSiswa'           => $dataUser[2], 
            'jumlahKelas'           => $dataUser[3],
            'jadwalHarian'          => $dataUser[4],
            'pengumumanSekolah'     => $dataUser[5],
            'pengumumanGuru'        => $dataUser[6],
            'jumlahAdmin'           => $dataUser[7]]);
    }
}
