<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PengumumanSekolahDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\PengumumanRequest;
use App\Models\PengumumanAdmin;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PengumumanAdminController extends ControllerAdmin
{
    public function index(PengumumanSekolahDatatable $dataTable)
    {
        return $dataTable->render('app.admin.pengumuman-sekolah.pengumuman-sekolah');
    }

    public function store(PengumumanRequest $request)
    {
        $request = $request->validated();

        try {
            PengumumanAdmin::create([
                'pengumuman'        => $request['pengumuman'],
                'waktu_pengumuman'  => date(now()),
                ]);
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data pengumuman');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data pengumuman '. $e->getMessage())->withInput();
        }
    }

   public function actionPengumuman($action, $id)
   {
       try {
           $id = Crypt::decrypt($id);
           $pengumuman = PengumumanAdmin::findOrFail($id);
       } catch (DecryptException $th) {
           return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
       }

       $returnHTML = view('app.admin.pengumuman-sekolah.pengumuman-sekolah-action', ['data' => $pengumuman, 'action' => $action])->render();
       return response()->json(['html' => $returnHTML]);
   }

    public function update(PengumumanRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $id = Crypt::decrypt($id);
            $pengumuman = PengumumanAdmin::findOrFail($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $pengumuman->update([
                'pengumuman'        => $request['pengumuman'],
                'waktu_pengumuman'  => date(now()),
                ]);
            return redirect()->back()->withSuccessMessage('Berhasil mengedit data pengumuman');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data pengumuman');
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
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            PengumumanAdmin::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
