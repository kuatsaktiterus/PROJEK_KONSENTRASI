<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JadwalDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\JadwalRequest;
use App\Models\Jadwal;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class JadwalController extends ControllerAdmin
{
    public function index(JadwalDatatable $dataTable)
    {
        return $dataTable->render('app.admin.jadwal.jadwal');
    }

    public function store(JadwalRequest $request)
    {
        $request = $request->validated();

        try {
            Jadwal::create([
                'jam_mulai'     => $request['jam_mulai'],
                'jam_selesai'   => $request['jam_selesai'],
                'hari'          => $request['hari'],
            ]);

            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data jadwal');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data jadwal')->withInput();

        }
    }

    public function actionJadwal($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $jadwal = Jadwal::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $returnHTML = view('app.admin.jadwal.jadwal-action', ['data' => $jadwal, 'action' => $action])->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function update(JadwalRequest $request, $id)
    {
        $request = $request->validated();
        try {
            $id = Crypt::decrypt($id);
            $jadwal = Jadwal::find($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        
        try {
            $jadwal->update([
                'jam_mulai'     => $request['jam_mulai'],
                'jam_selesai'   => $request['jam_selesai'],
                'hari'          => $request['hari'],
            ]);

            return redirect()->back()->withSuccessMessage('Berhasil mengedit data jadwal');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data jadwal '. $e->getMessage());

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
            Jadwal::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data Jadwal');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data Jadwal '. $th->getMessage());
        }
    }
}
