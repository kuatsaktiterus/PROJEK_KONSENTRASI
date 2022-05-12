<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JurusanDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\StoreJurusanRequest;
use App\Http\Requests\UpdateJurusanRequest;
use App\Models\Jurusan;
use App\Models\Kelas;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class JurusanController extends ControllerAdmin
{
    public function index(JurusanDatatable $dataTable)
    {
        return $dataTable->render('app.admin.jurusan.jurusan', ['jurusans' => Jurusan::all()]);
    }

    public function store(StoreJurusanRequest $request)
    {
        $request = $request->validated();

        try {
            $jurusan = Jurusan::create(['jurusan' => $request['jurusan']]);
            (new KelasController)->store($jurusan);

            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data jurusan');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data jurusan '. $th->getMessage());
        }
    }

    public function actionJurusan($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $jurusan = Jurusan::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $returnHTML = view('app.admin.jurusan.jurusan-action', [
            'data' => $jurusan,
            'action' => $action
        ])->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function update(UpdateJurusanRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $id = Crypt::decrypt($id);
            $jurusan = Jurusan::findOrFail($id);
        } catch (DecryptException $e) {
            return abort(404);
        }

        try {
            $jurusan->update(['jurusan' => $request['jurusan']]);
            return redirect()->back()->withSuccessMessage('Berhasil mengedit data jurusan');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data jurusan '. $th->getMessage());
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
            Kelas::where('id_jurusan', $id)->delete();
            Jurusan::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
