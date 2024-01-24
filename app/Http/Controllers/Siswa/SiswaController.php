<?php

namespace App\Http\Controllers\Siswa;

use App\DataTables\Admin\GuruDatatable;
use App\DataTables\Admin\MataPelajaranDatatable;
use App\DataTables\Siswa\InfoKelasDataTable;
use App\DataTables\Siswa\JadwalKelasDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Siswa;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('siswa');
    }

    public function guru(GuruDatatable $dataTable)
    {
        return $dataTable->render('app.siswa.guru');
    }

    public function infoKelas(InfoKelasDataTable $dataTable)
    {
        $dataSiswa = Siswa::findOrFail(Auth::user()->siswa->id);
        $idPembagianKelas = $dataSiswa->pembagiankelassiswa[0]->id;    
        $guru = $dataSiswa->pembagiankelassiswa[0]->PembagianKelas->guru;
        return $dataTable->with('id', $idPembagianKelas)->render('app.siswa.kelas.info-kelas', ['data' => $dataSiswa, 'guru' =>  $guru]);
    }

    public function jadwalKelas(JadwalKelasDataTable $dataTable)
    {
        $idSiswa = Auth::user()->siswa->id;
        if ((new Siswa())->isKelasNull($idSiswa)) {abort(404);}
        $dataSiswa = Siswa::findOrFail($idSiswa);
        $idPembagianKelas = $dataSiswa->pembagiankelassiswa[0]->id_pembagian_kelas;    
        return $dataTable->with('id', $idPembagianKelas)->render('app.siswa.kelas.jadwal-kelas', ['data' => $dataSiswa]);
    }

    public function mataPelajaran(MataPelajaranDatatable $dataTable)
    {
        return $dataTable->render('app.siswa.matapelajaran');
    }

    public function profil()
    {
        $dataSiswa = Siswa::findOrFail(Auth::user()->siswa->id);

        return view('app.siswa.profil.profil', ['siswa' => $dataSiswa]);
    }

    public function gantiPassword()
    {
        $dataSiswa = Siswa::findOrFail(Auth::user()->siswa->id);

        return view('app.siswa.profil.ganti-pass', ['siswa' => $dataSiswa]);
    }

    public function gantiPasswordUpdate(UpdatePasswordRequest $request)
    {
        $request = $request->validated();

        try {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request['newPassword'])]);

            return redirect()->back()->withSuccessMessage('Berhasil mengedit data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data');
        }
    }
}
