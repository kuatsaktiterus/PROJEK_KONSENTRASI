<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\Raport\RaportDataTable;
use App\DataTables\Admin\Raport\SiswaDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\ArsipRekapitulasiKelas;
use App\Models\JadwalKelas;
use App\Models\PembagianKelas;
use App\Models\PembagianKelasSiswa;
use App\Models\Raport;
use App\Models\RaportMataPelajaran;
use App\Models\RekapitulasiKelas;
use App\Models\TahunAjaran;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class NilaiDanSemesterController extends ControllerAdmin
{
    public function index()
    {
        
        $tahunAjar = TahunAjaran::latest()->first();
        
        if ($tahunAjar['aktif']) {
            $arsipRekapitulasiKelas = ArsipRekapitulasiKelas::where('id_tahun_ajaran', $tahunAjar->id)->first();
            $jumlahPembagianKelas = PembagianKelas::count();
            $jumlahKelasTerekapitulasi = RekapitulasiKelas::where('id_arsip_rekapitulasi_kelas', $arsipRekapitulasiKelas->id)->get();

            return view('app.admin.nilai-dan-semester.nilai-semester', [
                'tahunAjar' => $tahunAjar, 
                'jumlahPembagianKelas' => $jumlahPembagianKelas, 
                'jumlahKelasTerekapitulasi' => $jumlahKelasTerekapitulasi,
                'idArsip' => $arsipRekapitulasiKelas->id,
            ]);
        } else {
            return view('app.admin.nilai-dan-semester.nilai-semester', [
                'tahunAjar' => $tahunAjar, 
            ]);
        }
        
    }

    public function listRaport($id, RaportDataTable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        return $dataTable->with('id', $id)->render('app.admin.nilai-dan-semester.raport.list-raport');
    }

    public function siswa(SiswaDataTable $dataTable)
    {
        return $dataTable->render('app.admin.nilai-dan-semester.raport.siswa');
    }

    public function raportIndex($id, $idSiswa)
    {
        try {
            $idSiswa = Crypt::decrypt($idSiswa);
            $id = Crypt::decrypt($id);
            $raport = Raport::findOrFail($id);
            $raportMataPelajaran = RaportMataPelajaran::where('id_raport', $id)->get();
            $pembagianKelas = PembagianKelasSiswa::where('id_siswa', $idSiswa)->get();
            $pembagianKelas = ($pembagianKelas->count() < 1) ? [] : $pembagianKelas[0]->PembagianKelas;
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        return view('app.admin.nilai-dan-semester.raport.raport', 
        [
            "pembagianKelas" => $pembagianKelas, 
            'raport' => $raport, 
            "raportMataPelajaran" => $raportMataPelajaran, 
            "idSiswa" => $idSiswa
        ]);
    }

    public function akhiriSemester($id_arsip, $id_tahun_ajar)
    {
        try {
            $id_arsip = Crypt::decrypt($id_arsip);
            $id_tahun_ajar = Crypt::decrypt($id_tahun_ajar);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $arsipRekapitulasiKelas = ArsipRekapitulasiKelas::findOrFail($id_arsip);

            $arsipRekapitulasiKelas->update([
                'kelas_aktif' => PembagianKelas::all()->count(),
                'kelas_terekapitulasi' => $arsipRekapitulasiKelas->RekapitulasiKelas->count(),
                'kelas_belum_terekapitulasi' => PembagianKelas::all()->count() - $arsipRekapitulasiKelas->RekapitulasiKelas->count(),
            ]);

            TahunAjaran::findOrFail($id_tahun_ajar)->update([
                'aktif' => false
            ]);

            PembagianKelasSiswa::truncate();
            JadwalKelas::truncate();
            PembagianKelas::truncate();
            RekapitulasiKelas::truncate();

            return redirect()->back()->withSuccessMessage('Semester Telah Diakhiri');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal mengakhiri semester '. $th->getMessage());
        }
    }

    public function mulaiSemester()
    {
        try {
            $tahunAjar = TahunAjaran::latest()->first();
            $semester = ($tahunAjar['semester'] == 'genap') ? 'ganjil' : 'genap';

            $tahunAjar = TahunAjaran::create([
                'tahun_ajar_awal' => date("Y"),
                'tahun_ajar_akhir' => date("Y")+1,
                'semester' => $semester,
                'aktif' => true,
            ]);

            ArsipRekapitulasiKelas::create([
                'kelas_aktif' => 0,
                'kelas_terekapitulasi' => 0, 
                'kelas_belum_terekapitulasi' => 0,
                'id_tahun_ajaran' => $tahunAjar->id
            ]);

            return redirect()->back()->withSuccessMessage('Semester Telah Dimulai');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal memulai semester '. $th->getMessage());
        }
    }
}
