<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PembagianKelasDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\StorePembagianKelasRequest;
use App\Http\Requests\UpdatePembagianKelasRequest;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\PembagianKelas;
use App\Models\TahunAjaran;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class PembagianKelasController extends ControllerAdmin
{
    public function store(StorePembagianKelasRequest $request)
    {
        $request = $request->validated();
        try {
            $id = request()->session()->get('id_kelas');
        } catch (DecryptException $e) {
            abort(404);
        }
       
        try {
            PembagianKelas::create([
                'nama_kelas' => $request['nama_kelas'],
                'wali_kelas' => $request['wali_kelas'],
                'id_kelas'   => $id,
            ]);
            
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data pembagian kelas');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data pembagian kelas'. $e->getMessage());
        }
    }

    public function show($id, PembagianKelasDatatable $dataTable)
    {
        $tahunAjar = TahunAjaran::latest()->first()->aktif;

        try {
            $id = Crypt::decrypt($id);
            session()->put('id_kelas', $id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $kelas = Kelas::find($id);
        $guru = Guru::select('nip', 'nama', 'id')->get();
        return $dataTable->with('id', $id)->render('app.admin.kelas.pembagian-kelas', ['gurus' => $guru, 'kelas' => $kelas->kelas, 'jurusan' => $kelas->jurusan, 'tahunAjar' => $tahunAjar]);
    }

    public function actionPembagianKelas($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $kelas = PembagianKelas::findOrFail($id);
            $guru = Guru::all();
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $returnHTML = view('app.admin.kelas.pembagian-kelas-action', [
            'data' => $kelas,
            'action' => $action,
            'gurus' => $guru
        ])->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function update(UpdatePembagianKelasRequest $request, $id)
    {
        $request = $request->validated();
        try {
            $idPembagianKelas = Crypt::decrypt($id);
            $pembagianKelas = PembagianKelas::findOrFail($idPembagianKelas);
        } catch (DecryptException $e) {
            abort(404);
        }

        try {
            $pembagianKelas->update([
                'nama_kelas' => $request['nama_kelas'],
                'wali_kelas' => $request['wali_kelas'],
            ]);
            
            return redirect()->back()->withSuccessMessage('Berhasil mengedit data pembagian kelas');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data pembagian kelas '. $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            try {
                PembagianKelas::where('id', $id)->delete();
                return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
            }
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
    }
}
