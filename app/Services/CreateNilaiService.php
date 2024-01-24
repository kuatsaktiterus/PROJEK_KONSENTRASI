<?php

namespace App\Services;

use App\Models\Nilai;
use App\Models\User;

class CreateNilaiService {
    public function CreateNilai($request, $id_jadwal_kelas, $id_siswa)
    {
        try {
            $nilai = Nilai::UpdateOrCreate(
                [
                    'id' => $request['id']
                ],
                [
                'tugas' => $request['tugas'],
                'ulangan_harian' => $request['ulangan_harian'],
                'uts' => $request['uts'],
                'uas' => $request['uas'],
                'id_jadwal_kelas' => $id_jadwal_kelas,
                'id_siswa' => $id_siswa
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $nilai;
    }
}