<?php

namespace App\Services;

use App\Models\RaportMataPelajaran;

class CreateRaportMataPelajaranService {
    public function CreateRaportMataPelajaran($nilai, $jadwalKelas, $request)
    {
        try {
            $raportMataPelajaran = RaportMataPelajaran::updateOrCreate(
            [
                'id' => $request['id_raport_mata_pelajaran']
            ],
            [
                'nama_kelas'                =>  $jadwalKelas->pembagianKelas->kelas->kelas. " " . $jadwalKelas->pembagianKelas->kelas->jurusan->jurusan. " " . $jadwalKelas->pembagianKelas->nama_kelas ,
                'wali_kelas'                =>  $jadwalKelas->pembagianKelas->guru->nama,
                'mata_pelajaran'            =>  $jadwalKelas->MataPelajaran->nama_mapel,
                'nilai_pengetahuan'         =>  $nilai,
                'predikat_pengetahuan'      =>  "A",
                'deskripsi_pengetahuan'     =>  $jadwalKelas->MataPelajaran->deskripsi_predikat_A,
                'id_raport'                 =>  $request['id_raport']
            ]);

            if ($nilai < 85) {
                $raportMataPelajaran->update([
                    'predikat_pengetahuan'      =>  "B",
                    'deskripsi_pengetahuan'     =>  $jadwalKelas->MataPelajaran->deskripsi_predikat_B,
                ]);
            } elseif ($nilai < 70 ) {
                $raportMataPelajaran->update([
                    'predikat_pengetahuan'      =>  "C",
                    'deskripsi_pengetahuan'     =>  $jadwalKelas->MataPelajaran->deskripsi_predikat_C,
                ]);
            } elseif ($nilai < 50) {
                $raportMataPelajaran->update([
                    'predikat_pengetahuan'      =>  "D",
                    'deskripsi_pengetahuan'     =>  $jadwalKelas->MataPelajaran->deskripsi_predikat_D,
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $raportMataPelajaran;
    }
}