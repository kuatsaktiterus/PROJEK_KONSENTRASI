<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JadwalKelasDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\StoreJadwalKelasRequest;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\JadwalKelas;
use App\Models\MataPelajaran;
use App\Models\PembagianKelas;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class JadwalKelasController extends ControllerAdmin
{
    public function store(StoreJadwalKelasRequest $request)
    {
        $request = $request->validated();

        try {
            $cekJadwalKelasPengajar = JadwalKelas::where('id_pengajar', $request['pengajar'])->get();
            $cekJadwalKelasKelas = JadwalKelas::where('id_pembagian_kelas', $request['pembagian_kelas'])->get();

            // cek jadwal dari guru yang telah dipilih
            $getRuleJadwalKelas_idJadwalPengajar = array();
            foreach ($cekJadwalKelasPengajar as $jadwal) {
                $getRuleJadwalKelas_idJadwalPengajar[] = '' . $jadwal->id_jadwal . '';
            }

            // cek jadwal dari kelas yang telah dipilih
            $getRuleJadwalKelas_idJadwalKelas = array();
            foreach ($cekJadwalKelasKelas as $jadwal) {
                $getRuleJadwalKelas_idJadwalKelas[] = '' . $jadwal->id_jadwal . '';
            }
            
            // Jika pengajar memiliki waktu mengajar yang sama
            if (in_array($request['jadwal'], $getRuleJadwalKelas_idJadwalPengajar)) {
                return redirect()->back()->withWarningMessage('Pengajar ini sudah memiliki jadwal di waktu tersebut')->withInput();
            }

            // Jika didalam sebuah kelas sudah memiliki waktu mengajar tersebut
            if (in_array($request['jadwal'], $getRuleJadwalKelas_idJadwalKelas)) {
                return redirect()->back()->withWarningMessage('Waktu pelajaran di kelas ini sudah terisi')->withInput();
            }

            JadwalKelas::create([
                'id_pembagian_kelas' => $request['pembagian_kelas'],
                'id_matapelajaran'   => $request['mapel'],
                'id_pengajar'        => $request['pengajar'],
                'id_jadwal'          => $request['jadwal']
            ]);
            
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data jadwal kelas');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data jadwal kelas '. $e->getMessage())->withInput();
        }
    }

    public function show($id, JadwalKelasDatatable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $pembagianKelas = PembagianKelas::all();
            $mataPelajaran = MataPelajaran::all();
            $pengajar = Guru::all();
            $jadwal = Jadwal::all();
            $dataPemabgianKelas = PembagianKelas::findOrFail($id);
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan '. $th->getMessage());
        }

        return $dataTable->with('id', $id)->render('app.admin.jadwal-kelas.jadwal-kelas', [
            'pembagianKelas' => $pembagianKelas,
            'matapelajaran'  => $mataPelajaran,
            'pengajar'       => $pengajar,
            'jadwal'         => $jadwal,
            'data'           => $dataPemabgianKelas
        ]);
    }

    public function actionJadwalKelas($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $jadwalKelas = JadwalKelas::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $pembagianKelas = PembagianKelas::all();
        $matapelajaran = MataPelajaran::all();
        $guru = Guru::all();
        $jadwal = Jadwal::all();

        $returnHTML = view('app.admin.jadwal-kelas.jadwal-kelas-action', [
            'data' => $jadwalKelas,
            'pembagianKelas' => $pembagianKelas,
            'matapelajaran' => $matapelajaran,
            'pengajar' => $guru,
            'jadwal' => $jadwal,
            'action' => $action
        ])->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function update(StoreJadwalKelasRequest $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $jadwalKelas = JadwalKelas::findOrFail($id);
        $request = $request->validated();
        $cekJadwalKelasPengajar = JadwalKelas::where('id_pengajar', $request['pengajar'])->get();
        $cekJadwalKelasKelas = JadwalKelas::where('id_pembagian_kelas', $request['pembagian_kelas'])->get();

        // cek jadwal dari guru yang telah dipilih
        $getRuleJadwalKelas_idJadwalPengajar = array();
        foreach ($cekJadwalKelasPengajar as $jadwal) {
            if (!($id == $jadwal['id'])) {
                $getRuleJadwalKelas_idJadwalPengajar[] = '' . $jadwal->id_jadwal . '';
            }
        }

        // cek jadwal dari kelas yang telah dipilih
        $getRuleJadwalKelas_idJadwalKelas = array();
        foreach ($cekJadwalKelasKelas as $jadwal) {
            if (!($id == $jadwal['id'])) {
                $getRuleJadwalKelas_idJadwalKelas[] = '' . $jadwal->id_jadwal . '';
            }
        }
        
        // Jika pengajar memiliki waktu mengajar yang sama
        if (in_array($request['jadwal'], $getRuleJadwalKelas_idJadwalPengajar)) {
            return redirect()->back()->withWarningMessage('Pengajar ini sudah memiliki jadwal di waktu tersebut')->withInput();
        }

        // Jika didalam sebuah kelas sudah memiliki waktu mengajar tersebut
        if (in_array($request['jadwal'], $getRuleJadwalKelas_idJadwalKelas)) {
            return redirect()->back()->withWarningMessage('Waktu pelajaran di kelas ini sudah terisi')->withInput();
        }

        try {
            $jadwalKelas->update([
                'id_pembagian_kelas'    => $request['pembagian_kelas'],
                'id_matapelajaran'      => $request['mapel'],
                'id_pengajar'           => $request['pengajar'],
                'id_jadwal'             => $request['jadwal'],
            ]);
            
            return redirect()->back()->withSuccessMessage('Berhasil mengedit data jurusan');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data jurusan '. $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            JadwalKelas::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data Jadwal Kelas');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data Jadwal Kelas'. $e->getMessage());
        }
    }
}
