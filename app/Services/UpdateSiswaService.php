<?php
namespace App\Services;

use App\Models\Siswa;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UpdateSiswaService {
    public function UpdateSiswa($siswa, $request, $id)
    {
        try {
            $siswa->update([
                'name'              => $request['nama'],
                'jenis_kelamin'     => $request['jenis_kelamin'],
                'no_telepon'        => $request['no_telepon'],
                'tempat_lahir'      => $request['tempat_lahir'],
                'tanggal_lahir'     => $request['tanggal_lahir'],
                'agama'             => $request['agama'],
                'alamat_lengkap'    => $request['alamat_lengkap'],
                'alamat_rt'         => $request['alamat_rt'],
                'alamat_rw'         => $request['alamat_rw'],
                'alamat_kelurahan'  => $request['alamat_kelurahan'],
                'alamat_kecamatan'  => $request['alamat_kecamatan'],
                'kode_pos'          => $request['kode_pos'],
                'tinggal_bersama'   => $request['tinggal_bersama'],
                'transportasi'      => $request['transportasi'],
                'id_jurusan'        => $request['jurusan'],
            ]);

            if (request()->hasFile('foto')) {
                $updatedPhotoName = (new UpdatePhotoService)->UpdatePhoto('foto', 'siswa', $siswa);
                $siswa->update([
                    'foto' => $updatedPhotoName,
                ]);
            }

            if (request()->filled('password')) {
                try {
                    $user = Siswa::find($id)->user;
                    $user->password = Hash::make($request['password']);
                    $user->save();
                } catch (\Throwable $th) {
                    return redirect()->route('siswa.edit', ['siswa' => Crypt::encrypt($id)])->withWarningMessage('Anda gagal mengupdate password user');
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}