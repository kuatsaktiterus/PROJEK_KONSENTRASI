<?php
namespace App\Services;

use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class UpdateGuruService {
    public function UpdateGuru($guru, $request, $id)
    {
        try {
            $guru->update([
                'nama'                => $request['nama'],
                'golongan'            => $request['golongan'],
                'jenis_kelamin'       => $request['jenis_kelamin'],
                'no_telepon'          => $request['no_telepon'],
                'alamat'              => $request['alamat'],
                'pendidikan_terakhir' => $request['pendidikan_terakhir'],
                'jurusan_pendidikan'  => $request['jurusan_pendidikan'],
            ]);

            if (request()->hasFile('foto')) {
                $UpdatePhotoName = (new UpdatePhotoService)->UpdatePhoto('foto', 'guru', $guru);

                $guru->update([
                    'foto' => $UpdatePhotoName,
                ]);
            }

            if (request()->filled('password')) {
                try {
                    $user = Guru::find($id)->user;
                    $user->password = Hash::make($request['password']);
                    $user->save();
                } catch (\Throwable $th) {
                    return redirect()->back()->withWarningMessage('Anda gagal mengedit password user');
                }
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}