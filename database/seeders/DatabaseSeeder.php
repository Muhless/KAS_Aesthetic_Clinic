<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $users = [
            ['username' => 'admin', 'role' => 'admin'],
            ['username' => 'dokter', 'role' => 'dokter'],
            ['username' => 'perawat', 'role' => 'perawat'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'username' => $user['username'],
                'password' => Hash::make('password123'),
                'role' => $user['role'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
