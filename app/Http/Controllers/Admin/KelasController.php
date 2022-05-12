<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\KelasDatatable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KelasController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store($jurusan)
    {
        try {
            $kelases = [
                ['kelas'=>'X',      'id_jurusan'=> $jurusan->id],
                ['kelas'=>'XI',     'id_jurusan'=> $jurusan->id],
                ['kelas'=>'XII',    'id_jurusan'=> $jurusan->id],
            ];

            foreach ($kelases as $kelas) {
                Kelas::create($kelas);
            }
        } catch (\Throwable $th) {
            $jurusan->delete();
            throw $th;
        }
    }

    public function show($id, KelasDatatable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
            $jurusan = Jurusan::find($id);
            return $dataTable->with('id', $id)->render('app.admin.kelas.kelas', ['jurusan' => $jurusan->jurusan]);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
