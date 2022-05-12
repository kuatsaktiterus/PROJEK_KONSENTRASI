<?php

namespace App\Http\Controllers;

use App\DataTables\Admin\PengumumanGuruDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengumumanRequest;
use App\Models\PengumumanGuru;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PengumumanGuruController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('pengumumanGuru');
    }

    public function index(PengumumanGuruDataTable $dataTable)
    {
        return $dataTable->render('app.admin.pengumuman-guru.pengumuman-guru');
    }

    public function store(PengumumanRequest $request)
    {
        $this->middleware('guru');
        $request = $request->validated();

        try {
            PengumumanGuru::create([
                'pengumuman'        => $request['pengumuman'],
                'waktu_pengumuman'  => date(now()),
                'id_guru'           => Auth::user()->gurus->id,
                ]);
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data pengumuman');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal menyimpan data pengumuman')->withInput();
        }
    }

    /**
    * Show modal for deleting and editing pengumuman
    */
   public function actionPengumuman($id)
   {
       try {
           $id = Crypt::decrypt($id);
           $pengumuman = PengumumanGuru::findOrFail($id);
       } catch (DecryptException $th) {
           return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
       }

       $returnHTML = view('app.admin.pengumuman-guru.pengumuman-guru-action', ['data' => $pengumuman])->render();
       return response()->json(['html' => $returnHTML]);
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            PengumumanGuru::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
