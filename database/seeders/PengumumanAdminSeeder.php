<?php

namespace Database\Seeders;

use App\Models\PengumumanAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengumumanAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengumumanAdmins = [
            ['id' => 1, 'pengumuman' => "Bulan Depan tanggal 02-14 UAS", 'waktu_pengumuman' => date(now())],
        ];
        
        foreach($pengumumanAdmins as $pengumumanAdmin){
            PengumumanAdmin::create($pengumumanAdmin);
        }
    }
}
