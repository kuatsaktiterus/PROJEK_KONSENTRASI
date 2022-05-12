<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\PembagianKelas;
use App\Models\PengumumanAdmin;
use App\Models\PengumumanGuru;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardDataService {

    public function DashboardUser()
    {
        if (Auth::user()->role == 'siswa' || Auth::user()->role == 'guru') {$isUser = true;} else{$isUser = false;}

        if($isUser) {
            $user           = (Auth::user()->role == 'siswa') ? 
            Siswa::findOrfail(Auth::user()->siswa->id) : 
            Guru::findOrfail(Auth::user()->guru->id);
        } else{$user = null;}

        $jumlahGuru         = Guru::count();
        $jumlahSiswa        = Siswa::count();
        $pengumumanAdmin    = PengumumanAdmin::all();
        $pengumumanGuru     = PengumumanGuru::all();

        if($isUser) {
            $jumlahKelas = (Auth::user()->role == 'siswa') ?
            PembagianKelas::where('id_kelas', $user->pembagiankelassiswa[0]->pembagiankelas->kelas->id)->count() : 
            PembagianKelas::all()->count();
        } else {
            $jumlahKelas = PembagianKelas::all()->count();
        }
        $jumlahAdmin        = Admin::count();

        // cari jadwal sesuai hari ini
        $hari = date('w', Carbon::now()->timestamp);
        $jadwal = Jadwal::where('hari', $hari)->get();

        // cari jadwal kelas untuk kelas hari itu
        if($isUser) {
            $jadwalHarian = [];
            foreach ($jadwal as $data) {
                $jadwalHarian = (Auth::user()->role == 'siswa') ? $user->pembagiankelassiswa[0]->jadwalkelas->where('id_jadwal', $data->id) : $user->jadwalkelas->where('id_jadwal', $data->id);;
            }
        } else{$jadwalHarian = null;}

        return [$user, $jumlahGuru, $jumlahSiswa, $jumlahKelas, $jadwalHarian, $pengumumanAdmin, $pengumumanGuru, $jumlahAdmin];
    }
}