<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\GuruDatatable;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Requests\StoreExcelRequest;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\User;
use App\Services\UpdateGuruService;
use App\Services\UploadPhotoService;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends ControllerAdmin
{
    public function index(GuruDatatable $dataTable)
    {
        return $dataTable->render('app.admin.guru.guru');
        
    }

    public function store(StoreGuruRequest $request)
    {
        $request = $request->validated();
        try {
            $user = (new RegisterController())->register([
                'username' => $request['nip'],
                'password' => Hash::make($request['nip']),
                'role'     => 'guru'
            ]);
            
            $guru = $user->Guru()->create([
                'nama'                  => $request['nama'],
                'nip'                   => $request['nip'],
                'golongan'              => $request['golongan'],
                'jenis_kelamin'         => $request['jenis_kelamin'],
                'no_telepon'            => $request['no_telepon'],
                'alamat'                => $request['alamat'],
                'pendidikan_terakhir'   => $request['pendidikan_terakhir'],
                'jurusan_pendidikan'    => $request['jurusan_pendidikan'],
            ]);

            if (request()->hasFile('foto')) {
                $name = (new UploadPhotoService)->UploadPhoto('guru'); 

                $guru->update([
                    'foto' => $name
                ]);
            }
            return redirect()->back()->withSuccessMessage('Berhasil menyimpan data guru');
        } catch (\Throwable $th) {
            $user->delete();
            return redirect()->back()->withWarningMessage('Gagal menyimpan data guru '. $th->getMessage());
        }
    }

    public function store_from_excel(StoreExcelRequest $request)
    {
        $request = $request->validated();

        try {
            $import = new GuruImport;
            $import->import($request['file']);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->withWarningMessage("Gagal Menambah Data Guru kesalahan terjadi di baris ".$failures[0]->row().", ".$failures[0]->errors()[0]."");
        }
        return redirect()->back()->withSuccessMessage('Berhasil menyimpan data Guru');
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $guru = Guru::find($id);
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan '. $th->getMessage());
        }
        return view('app.admin.guru.guru-show', ['guru' => $guru]);
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $guru = Guru::find($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan '. $e->getMessage());
        }
        return view('app.admin.guru.guru-edit', ['guru' => $guru, 'jurusan' => Jurusan::all()]);
    }

    public function update(UpdateGuruRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $id = Crypt::decrypt($id);
            $guru = Guru::find($id);
        } catch (DecryptException $e) {
            return abort(404);
        }

        try {
            (new UpdateGuruService)->UpdateGuru($guru, $request, $id);
            return redirect()->back()->withSuccessMessage('Berhasil mengedit data guru');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal mengedit data guru '. $th->getMessage());
        }
    }

    public function actionDeleteGuru($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $guru = Guru::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan '. $e->getMessage());
        }

        $returnHTML = view('app.admin.guru.guru-delete', ['data' => $guru,])->render();
        return response()->json(['html' => $returnHTML]);
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $id = Guru::find($id);
            $filename = $id->foto;
            $id = $id->user->id;
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        
        try {
            $file = storage_path('app/public/image/guru/') . $filename;
            if (is_file($file) && ($filename != 'Default.png')) {
                Storage::delete("/public/image/guru/". $filename);
            }
            User::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data Guru');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data Guru '. $e->getMessage());
        }
        
    }
}
