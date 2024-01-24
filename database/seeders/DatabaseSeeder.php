<?php

namespace Database\Seeders;

use App\Models\JadwalKelas;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(JurusanSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GuruSeeder::class);
        $this->call(SiswaSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(JadwalSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(PembagianKelasSeeder::class);
        // $this->call(PembagianKelasSiswaSeeder::class);
        $this->call(MataPelajaranSeeder::class);
        $this->call(JadwalKelasSeeder::class);
        $this->call(PengumumanGuruSeeder::class);
        $this->call(PengumumanAdminSeeder::class);
        $this->call(TahunAjaranSeeder::class);
        $this->call(ArsipRekapitulasiKelasSeeder::class);
        $this->call(RekapitulasiKelasSeeder::class);
    }
}
