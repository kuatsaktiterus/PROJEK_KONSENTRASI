<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['id' => 1, 'username' => 'riki', 'password' => Hash::make('12345678'), 'role' => 'super_admin'],
            ['id' => 2, 'username' => '161348',  'password' => Hash::make('161348'), 'role' => 'siswa'],
            ['id' => 3, 'username' => '199011092014021007',  'password' => Hash::make('199011092014021007'), 'role' => 'guru'],
            ['id' => 4, 'username' => '192442',  'password' => Hash::make('192442'), 'role' => 'admin'],
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
