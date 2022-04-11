<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusans = [
            ['id' => 1, 'jurusan' => 'IPA'],
            ['id' => 2, 'jurusan' => 'IPS'],
        ];

        foreach($jurusans as $jurusan){
            Jurusan::create($jurusan);
        }
    }
}
