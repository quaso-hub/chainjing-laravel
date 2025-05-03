<?php

namespace Database\Seeders;

use App\Models\RUU;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RUUSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */    public function run(): void
    {
        RUU::insert([
            [
                'judul' => 'RUU Transparansi Digital',
                'deskripsi' => 'Mengatur transparansi data digital pemerintahan.',
                'status' => 'VOTING',
            ],
            [
                'judul' => 'RUU Perlindungan Data Mahasiswa',
                'deskripsi' => 'Melindungi data pribadi mahasiswa di lingkungan kampus.',
                'status' => 'DRAFT',
            ]
        ]);
    }
}
