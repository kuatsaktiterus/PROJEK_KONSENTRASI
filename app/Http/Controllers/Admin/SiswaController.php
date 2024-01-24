<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SiswaDatatable;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\StoreExcelRequest;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Imports\SiswaImport;
use App\Models\ArsipRekapitulasiKelas;
use App\Models\Jurusan;
use App\Models\Raport;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Services\UpdateSiswaService;
use App\Services\UploadPhotoService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SiswaDatatable $dataTable)
    {
        return $dataTable->render('app.admin.siswa.siswa');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.admin.siswa.siswa-create', ['jurusan' => Jurusan::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiswaRequest $request)
    {
        $request = $request->validated();

        try {
            $user = (new RegisterController)->register([
                'username' => $request['nisn'],
                'password' => Hash::make($request['nisn']),
                'role' => 'siswa'
            ]);
            
            $siswa = $user->Siswa()->create([
                'name' => $request['nama'],
                'jenis_kelamin' => $request['jenis_kelamin'],
                'no_telepon' => $request['no_telepon'],
                'nisn' => $request['nisn'],
                'nik' => $request['nik'],
                'tempat_lahir' => $request['tempat_lahir'],
                'tanggal_lahir' => $request['tanggal_lahir'],
                'agama' => $request['agama'],
                'alamat_lengkap' => $request['alamat_lengkap'],
                'alamat_rt' => $request['alamat_rt'],
                'alamat_rw' => $request['alamat_rw'],
                'alamat_kelurahan' => $request['alamat_kelurahan'],
                'alamat_kecamatan' => $request['alamat_kecamatan'],
                'kode_pos' => $request['kode_pos'],
                'tinggal_bersama' => $request['tinggal_bersama'],
                'transportasi' => $request['transportasi'],
                'id_jurusan' => $request['jurusan'],
            ]);

            if (request()->hasFile('foto')) {
                $UploadedPhotoName = (new UploadPhotoService)->UploadPhoto('siswa');

                $siswa->update([
                    'foto' => $UploadedPhotoName,
                ]);
            }
            return redirect()->route('siswa.create')->withSuccessMessage('Berhasil menyimpan data siswa');
        } catch (\Throwable $th) {
            $user->delete();
            return redirect()->route('siswa.create')->withWarningMessage('Gagal menyimpan data siswa '. $th->getMessage());
        }
    }

    public function store_from_excel(StoreExcelRequest $request)
    {
        $request = $request->validated();
        
        try {
            $import = new SiswaImport;
            $import->import($request['file']);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->withWarningMessage("Gagal Menambah Data Siswa kesalahan terjadi di baris ".$failures[0]->row().", ".$failures[0]->errors()[0]."");
        }
        return redirect()->back()->withSuccessMessage('Berhasil menyimpan data siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $siswa = Siswa::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }
        return view('app.admin.siswa.siswa-show', ['siswa' => $siswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $siswa = Siswa::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }
        return view('app.admin.siswa.siswa-edit', ['siswa' => $siswa, 'jurusan' => Jurusan::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiswaRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $id = Crypt::decrypt($id);
            $siswa = Siswa::find($id);
        } catch (DecryptException $e) {
            return abort(404);
        }

        try {
            (new UpdateSiswaService)->UpdateSiswa($siswa, $request, $id);
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data siswa '. $th->getMessage());
        }
        return redirect()->back()->withSuccessMessage('Berhasil mengedit data siswa');
    }

    public function actionDeleteSiswa($id)
    {
    try {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findOrFail($id);
    } catch (DecryptException $e) {
        return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
    }

    $returnHTML = view('app.admin.siswa.siswa-delete', ['data' => $siswa,])->render();
    return response()->json(['html' => $returnHTML]);
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
            $id_siswa = Crypt::decrypt($id);
            $siswa = Siswa::find($id_siswa);
            $filename = $siswa->foto;
            $id_user = $siswa->user->id;
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan '. $e->getMessage());
        }

        try {
            $file = storage_path('app/public/image/siswa/') . $filename;
            if (is_file($file) && ($filename != 'Default.png')) {
                Storage::delete("/public/image/siswa/". $filename);
            }
            User::findOrFail($id_user)->delete();
            Raport::where('id_siswa', $id_siswa)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data Siswa');
        } catch (\Throwable $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data Siswa '. $e->getMessage());
        }
        
    }
}
