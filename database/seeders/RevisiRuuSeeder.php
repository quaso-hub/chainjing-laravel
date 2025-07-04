<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RevisiRUU;
use App\Models\RUU;
use App\Models\User;

class RevisiRuuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari ID user Pimpinan dan RUU Plastik
        $pimpinan = User::where('email', 'pimpinan@example.com')->first();
        $ruuPlastik = RUU::where('judul', 'like', '%Plastik%')->first();

        RevisiRUU::create([
            'ruu_id' => $ruuPlastik->id,
            'user_id' => $pimpinan->id,
            'alasan' => 'Pada prinsipnya saya setuju dengan RUU ini, namun larangan saja tidak cukup tanpa adanya insentif untuk mendorong inovasi. Usulkan ditambahkan pasal tentang insentif fiskal.', // atau 'isi_revisi'
            'status' => 'Diajukan',
        ]);
    }
}
