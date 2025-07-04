<?php

namespace Database\Seeders;

use App\Models\RUU;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RUUSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */    public function run(): void
    {

        // Cari ID user Anggota yang sudah kita buat
        $anggotaA = User::where('email', 'anggota@example.com')->first();

        RUU::create([
            'user_id' => $anggotaA->id,
            'judul' => 'Rancangan Undang-Undang tentang Pengurangan Penggunaan Plastik Sekali Pakai',
            'deskripsi' => 'Melihat dampak buruk dari sampah plastik yang semakin mengkhawatirkan terhadap ekosistem laut dan darat di Indonesia, RUU ini diajukan untuk menekan sumber utama polusi plastik.',
            'status' => 'DRAFT',
        ]);

        RUU::create([
            'user_id' => $anggotaA->id,
            'judul' => 'Rancangan Undang-Undang tentang Digitalisasi dan Akses Pendidikan Nasional',
            'deskripsi' => 'Untuk mengatasi kesenjangan kualitas pendidikan antara kota besar dan daerah 3T (Terdepan, Terluar, Tertinggal), diperlukan sebuah payung hukum yang kuat.',
            'status' => 'DRAFT',
        ]);

        RUU::insert([
            [
                'user_id' => $anggotaA->id,
                'judul' => 'RUU Transparansi Digital',
                'deskripsi' => 'Mengatur transparansi data digital pemerintahan.',
                'status' => 'DRAFT',
            ],
            [
                'user_id' => $anggotaA->id,
                'judul' => 'RUU Perlindungan Data Mahasiswa',
                'deskripsi' => 'Melindungi data pribadi mahasiswa di lingkungan kampus.',
                'status' => 'DRAFT',
            ]
        ]);
    }
}
