<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mapels = [
            [
                'id' => 1, 
                'nama_mapel' => 'Fisika',
                'deskripsi_predikat_A' => "
                    Sangat kompeten dalam penguasaan konsep besaran
                    fisika, gerak melingkar, dan elastisitas. Jika belajar cukup
                    giat, penguasaan materi gaya dan gerak akan meningkat
                ",
                'deskripsi_predikat_B' => "
                    Sudah kompeten dalam penguasaan konsep besaran
                    fisika, gerak melingkar, dan elastisitas. Jika belajar cukup
                    giat, penguasaan materi gaya dan gerak akan meningkat
                ",
                'deskripsi_predikat_C' => "
                    Cukup kompeten dalam penguasaan konsep besaran
                    fisika, gerak melingkar, dan elastisitas. Jika belajar cukup
                    giat, penguasaan materi gaya dan gerak akan meningkat
                ",
                'deskripsi_predikat_D' => "
                    Belum kompeten dalam penguasaan konsep besaran
                    fisika, gerak melingkar, dan elastisitas. Jika belajar cukup
                    giat, penguasaan materi gaya dan gerak akan meningkat
                ",
                "semester" => 1,
                "kkm" => 75
            ],
            [
                'id' => 2, 
                'nama_mapel' => 'Kimia', 
                'deskripsi_predikat_A' => "
                    Sangat kompeten dalam penguasaan konsep kimia
                ",
                'deskripsi_predikat_B' => "
                    Sudah kompeten dalam penguasaan konsep kimia
                ",
                'deskripsi_predikat_C' => "
                    Cukup kompeten dalam penguasaan konsep kimia
                ",
                'deskripsi_predikat_D' => "
                    Belum kompeten dalam penguasaan konsep kimia
                ",
                "semester" => 1,
                "kkm" => 75
            ],
            [
                'id' => 3, 
                'nama_mapel' => 'Matematika',
                'deskripsi_predikat_A' => "
                Sangat kompeten dalam penguasaan konsep matematika
                ",
                'deskripsi_predikat_B' => "
                    Sudah kompeten dalam penguasaan konsep matematika
                ",
                'deskripsi_predikat_C' => "
                    Cukup kompeten dalam penguasaan konsep matematika
                ",
                'deskripsi_predikat_D' => "
                    Belum kompeten dalam penguasaan konsep matematika
                ",
                "semester" => 1,
                "kkm" => 75
            ],
        ];

        foreach($mapels as $mapel){
            MataPelajaran::create($mapel);
        }
    }
}
