<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                // 'role' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'Admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'PLPP',
                'email' => 'plpp@gmail.com',
                // 'role' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'PLPP',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@gmail.com',
                // 'role' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'Mahasiswa',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Dosen',
                'email' => 'dosen@gmail.com',
                // 'role' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'Dosen',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
