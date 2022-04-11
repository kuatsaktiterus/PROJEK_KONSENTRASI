<?php

namespace Database\Seeders;

use App\Models\PembagianKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembagianKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pembagianKelases = [
            ['id' => 1, 'nama_kelas' => 'A', 'wali_kelas' => 1, 'id_kelas' => 1],
            ['id' => 2, 'nama_kelas' => 'A', 'wali_kelas' => 1, 'id_kelas' => 2],
        ];
        
        foreach($pembagianKelases as $pembagianKelases){
            PembagianKelas::create($pembagianKelases);
        }
    }
}
