<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TahunAjaran::create([
            'id'                => 1,
            'tahun_ajar_awal'   => 2022,
            'tahun_ajar_akhir'  => 2022,
            'semester'          => 'ganjil',
            'aktif'             => 1
        ]);
    }
}
