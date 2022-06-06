<?php

namespace App\Http\Controllers\Guru;

use App\DataTables\Admin\MataPelajaranDatatable;
use App\DataTables\Admin\SiswaDatatable;
use App\DataTables\Guru\JadwalKelasDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Guru;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guru');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jadwalKelas(JadwalKelasDatatable $dataTable)
    {
        return $dataTable->with('id', Auth::user()->guru->id)->render('app.guru.jadwal-kelas');
    }

    public function mataPelajaran(MataPelajaranDatatable $dataTable)
    {
        return $dataTable->render('app.guru.mata-pelajaran');
    }

    public function siswa(SiswaDatatable $dataTable)
    {
        return $dataTable->render('app.guru.siswa');
    }

    public function profil(SiswaDatatable $dataTable)
    {
        $dataGuru = Guru::findOrFail(Auth::user()->guru->id);

        return view('app.guru.profil.profil', ['guru' => $dataGuru]);
    }

    public function indexPassword()
    {
        $dataSiswa = Guru::findOrFail(Auth::user()->guru->id);

        return view('app.guru.profil.update-pass', ['guru' => $dataSiswa]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request = $request->validated();

        try {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request['newPassword'])]);
            return redirect()->back()->withSuccessMessage('Berhasil mengganti password');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal mengganti password, '. $e->getMessage());
        }
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
