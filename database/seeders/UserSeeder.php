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
     */
    public function run(): void
    {
        User::insert([
            [
                'nama' => 'Admin Satu',
                'jabatan_id' => 1,
                'alamat' => 'Jakarta',
                'email' => 'admin@example.com',
                'password' => Hash::make('password')
            ],
            [
                'nama' => 'Anggota Dua',
                'jabatan_id' => 2,
                'alamat' => 'Bandung',
                'email' => 'anggota@example.com',
                'password' => Hash::make('password')
            ]
        ]);
    }
}
