<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guru::create([
            'id'                    => '1',
            'nip'                   => '199011092014021007',
            'golongan'              => 'IV/a',
            'nama'                  => 'Heri',
            'jenis_kelamin'         => 'laki-laki',
            'alamat'                => 'Bumi Tamalanrea Permai',
            'no_telepon'            => '0812345678',
            'pendidikan_terakhir'   => 'S1-Teknik Informatika',
            'jurusan_pendidikan'    => 'Pendidikan Bimbingan Konseling',
            'id_user'               => '3',
        ]);
    }
}
