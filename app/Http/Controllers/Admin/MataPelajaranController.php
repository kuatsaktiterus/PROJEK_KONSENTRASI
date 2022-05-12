<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MataPelajaranDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\Models\MataPelajaran;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class MataPelajaranController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MataPelajaranDatatable $dataTable)
    {
        return $dataTable->render('app.admin.mata-pelajaran.mata-pelajaran');
    }

    public function store(StoreMataPelajaranRequest $request)
    {
        $request = $request->validated();

        try {
            MataPelajaran::create([
                'nama_mapel' => $request['nama_mapel'],
            ]);
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data mata pelajaran');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data mata pelajaran '. $e->getMessage())->withInput();
        }
    }

    /**
     * Show modal for deleting and editing mata pelajaran
     */
    public function actionMataPelajaran($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $mapel = MataPelajaran::findOrFail($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        $returnHTML = view('app.admin.mata-pelajaran.mata-pelajaran-action', ['data' => $mapel, 'action' => $action])->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function update(UpdateMataPelajaranRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $mapel = MataPelajaran::findOrFail($id);
            $mapel->update([
                'nama_mapel' => $request['nama_mapel'],
            ]);
            return redirect()->back()->withSuccessMessage('Berhasil mengedit data mata pelajaran');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data mata pelajaran '. $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            MataPelajaran::findOrFail($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
