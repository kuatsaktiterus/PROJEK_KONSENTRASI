<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelases = [
            ['id' => 1, 'kelas' => 'X',  'id_jurusan' => 1],
            ['id' => 2, 'kelas' => 'XI', 'id_jurusan' => 1],
            ['id' => 3, 'kelas' => 'XII','id_jurusan' => 1],
            ['id' => 4, 'kelas' => 'X',  'id_jurusan' => 2],
            ['id' => 5, 'kelas' => 'XI', 'id_jurusan' => 2],
            ['id' => 6, 'kelas' => 'XII','id_jurusan' => 2],
        ];

        foreach($kelases as $kelas){
            Kelas::create($kelas);
        }
    }
}
