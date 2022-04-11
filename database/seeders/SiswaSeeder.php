<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Siswa::create([
            'id'                    => '1',
            'name'                  => 'Ricky Heri Sappa',
            'jenis_kelamin'         => 'laki-laki',
            'no_telepon'            => '081433538729',
            'nisn'                  => '161348',
            'nik'                   => '7317231130306010001',
            'tempat_lahir'          => 'Makassar',
            'tanggal_lahir'         => '2021-12-28',
            'agama'                 => 'kristen protestan',
            'alamat_lengkap'        => 'Jl. Tidung VI Stp 3 No.53',
            'alamat_rt'             => '02',
            'alamat_rw'             => '03',
            'alamat_kelurahan'      => 'Mappala',
            'alamat_kecamatan'      => 'Rappocini',
            'kode_pos'              => '92002',
            'tinggal_bersama'       => 'orang tua',
            'transportasi'          => 'kendaraan pribadi',
            'id_user'               => 2,
            'id_jurusan'            => '1',
        ]);
    }
}
