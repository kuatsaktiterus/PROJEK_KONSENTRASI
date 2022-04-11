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
            ['id' => 1, 'nama_mapel' => 'Fisika',  ],
            ['id' => 2, 'nama_mapel' => 'Kimia', ],
            ['id' => 3, 'nama_mapel' => 'Matematika',],
        ];

        foreach($mapels as $mapel){
            MataPelajaran::create($mapel);
        }
    }
}
