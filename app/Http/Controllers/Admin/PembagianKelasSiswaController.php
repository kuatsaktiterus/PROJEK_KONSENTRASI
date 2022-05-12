<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\IsiKelasDatatable;
use App\DataTables\Admin\PembagianKelasSiswaDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\PembagianKelas;
use App\Models\PembagianKelasSiswa;
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

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            try {
                PembagianKelasSiswa::find($id)->delete();
                return redirect()->back()->withSuccessMessage('Berhasil mengeluarkan siswa dari kelas');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengeluarkan siswa dari kelas');
            }
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
    }
}
