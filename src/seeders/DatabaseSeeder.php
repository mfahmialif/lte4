<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // User::factory(10)->create();
        DB::table('users')->insert([
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('dalwa123'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Admin 2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('dalwa123'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Moota',
                'email' => 'moota@gmail.com',
                'password' => Hash::make('dalwa123'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Kepala',
                'email' => 'kepala@gmail.com',
                'password' => Hash::make('dalwa123'),
                'role' => 'kepala',
            ],
        ]);
    }
}
