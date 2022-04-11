<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jadwals = [
            ['id' => 1, 'jam_mulai' => '07:30:00',  'jam_selesai' => '09:00:00', 'hari' => 1],
            ['id' => 2, 'jam_mulai' => '09:20:00',  'jam_selesai' => '11:10:00', 'hari' => 2],
            ['id' => 3, 'jam_mulai' => '01:00:00',  'jam_selesai' => '15:00:00', 'hari' => 3],
            ['id' => 4, 'jam_mulai' => '15:10:00',  'jam_selesai' => '17:00:00', 'hari' => 4],
        ];

        foreach($jadwals as $jadwal){
            Jadwal::create($jadwal);
        }
    }
}
