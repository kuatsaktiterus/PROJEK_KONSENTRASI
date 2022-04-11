<?php

namespace Database\Seeders;

use App\Models\JadwalKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jadwal_kelases = [
            ['id' => 1, 'id_pembagian_kelas' => 1,  'id_matapelajaran' => 1, 'id_pengajar' => 1, 'id_jadwal' => 1],
            ['id' => 2, 'id_pembagian_kelas' => 1,  'id_matapelajaran' => 2, 'id_pengajar' => 1, 'id_jadwal' => 2],
        ];

        foreach($jadwal_kelases as $jadwal_kelas){
            JadwalKelas::create($jadwal_kelas);
        }
    }
}
