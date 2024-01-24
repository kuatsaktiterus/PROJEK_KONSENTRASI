<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\IsiKelasDatatable;
use App\DataTables\Admin\PembagianKelasSiswaDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\ArsipRekapitulasiKelas;
use App\Models\Kelas;
use App\Models\PembagianKelas;
use App\Models\PembagianKelasSiswa;
use App\Models\Raport;
use App\Models\TahunAjaran;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class PembagianKelasSiswaController extends ControllerAdmin
{
    public function store($idSiswa, $idPembagianKelas)
    {
        try {
            $pembagianKelas = Crypt::decrypt($idPembagianKelas);
            $idSiswa = Crypt::decrypt($idSiswa);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        }

        try {
            $tahunAjar = TahunAjaran::where('aktif', true)->first();
            $idRekapitulasi = ArsipRekapitulasiKelas::where('id_tahun_ajaran', $tahunAjar->id)->first()->id;
            Raport::create([
                'id_siswa' => $idSiswa,
                'id_arsip_rekapitulasi_kelas' => $idRekapitulasi
            ]);
            PembagianKelasSiswa::create([
                'id_siswa'              => $idSiswa,
                'id_pembagian_kelas'    => $pembagianKelas,
            ]);
            
            return redirect()->back()->withSuccessMessage('Berhasil memasukkan siswa ke dalam kelas');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal memasukkan siswa ke dalam kelas '. $e->getMessage());
        }
    }

    public function show($id, PembagianKelasSiswaDatatable $dataTable)
    {
        $id_kelas = session()->get('id_kelas');

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $id_jurusan = PembagianKelas::find($id)->kelas->id_jurusan;

        $banyakPembagianKelasSiswa = PembagianKelasSiswa::where('id_pembagian_kelas', $id)->count();
        $pembagianKelas = PembagianKelas::find($id);
        return $dataTable->with('id', $id)->with('id_jurusan', $id_jurusan)->render(
            'app.admin.kelas.pembagian-kelas-siswa',
            [
                'id'                => $id_kelas,
                'banyakSiswa'       => $banyakPembagianKelasSiswa,
                'idPembagianKelas'  => $pembagianKelas->id,
                'kelas'             => $pembagianKelas->kelas->kelas,
                'jurusan'           => $pembagianKelas->kelas->jurusan
            ]
        );
    }

    public function edit($id, IsiKelasDatatable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $pembagianKelas = PembagianKelas::find($id);
        return $dataTable->with('id', $id)->render('app.admin.kelas.isi-kelas', ['pembagianKelas' => $pembagianKelas]);
    }

    public function destroy($id, $idSiswa)
    {
        try {
            $tahunAjar = TahunAjaran::where('aktif', true)->first();
            $idRekapitulasi = ArsipRekapitulasiKelas::where('id_tahun_ajaran', $tahunAjar->id)->first()->id;
            $id = Crypt::decrypt($id);
            $idSiswa = Crypt::decrypt($idSiswa);
            $raport = Raport::where('id_siswa', $idSiswa)->where('id_arsip_rekapitulasi_kelas', $idRekapitulasi)->get();
            if ($raport[0]->raportmatapelajaran->count() > 0) {
                $raport[0]->raportmatapelajaran->each(function($item)
                {
                    return $item->delete();
                });
            }
            $raport[0]->delete();
            PembagianKelasSiswa::find($id)->delete();
            try {
                return redirect()->back()->withSuccessMessage('Berhasil mengeluarkan siswa dari kelas');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengeluarkan siswa dari kelas');
            }
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
    }
}
