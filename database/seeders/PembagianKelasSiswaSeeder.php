<?php

namespace Database\Seeders;

use App\Models\PembagianKelasSiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembagianKelasSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pembagianKelase = [
            ['id' => 1, 'id_siswa' => 1, 'id_pembagian_kelas' => 1],
        ];
        
        foreach($pembagianKelase as $pembagianKelases){
            PembagianKelasSiswa::create($pembagianKelases);
        }
    }
}
