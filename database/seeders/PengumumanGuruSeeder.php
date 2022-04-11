<?php

namespace Database\Seeders;

use App\Models\PengumumanGuru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengumumanGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengumumanGurus = [
            ['id' => 1, 'pengumuman' => "Hari besok terakhir mengumpulkan tugas 2", 'waktu_pengumuman' => date(now()), 'id_guru' => 1],
            ['id' => 2, 'pengumuman' => "Mengambil formulir biodata di ruang guru", 'waktu_pengumuman' => date(now()), 'id_guru' => 1],
        ];
        
        foreach($pengumumanGurus as $pengumumanGuru){
            PengumumanGuru::create($pengumumanGuru);
        }
    }
}
