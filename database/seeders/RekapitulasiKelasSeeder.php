<?php

namespace Database\Seeders;

use App\Models\RekapitulasiKelas;
use Illuminate\Database\Seeder;

class RekapitulasiKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataRekapitulasiKelases = [
            [
                'id'                            => 1,
                'id_pembagian_kelas'            => 1,
                'id_arsip_rekapitulasi_kelas'   => 1
            ],
            [
                'id'                            => 2,
                'id_pembagian_kelas'            => 2,
                'id_arsip_rekapitulasi_kelas'   => 1
            ],
        ];

        foreach ($dataRekapitulasiKelases as $dataRekapitulasiKelas) {
            RekapitulasiKelas::create($dataRekapitulasiKelas);
        }
    }
}
