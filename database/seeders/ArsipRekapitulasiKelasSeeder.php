<?php

namespace Database\Seeders;

use App\Models\ArsipRekapitulasiKelas;
use Illuminate\Database\Seeder;

class ArsipRekapitulasiKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArsipRekapitulasiKelas::create([
            'id'                            => 1,
            'kelas_aktif'                   => 2,
            'kelas_terekapitulasi'          => 0,
            'kelas_belum_terekapitulasi'    => 0,
            'id_tahun_ajaran'               => 1
        ]);
    }
}
