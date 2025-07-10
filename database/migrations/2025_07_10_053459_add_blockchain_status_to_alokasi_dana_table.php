<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alokasi_dana', function (Blueprint $table) {
            // Untuk melacak status: 'pending' atau 'recorded'
            $table->string('status_blockchain')->default('pending')->after('keterangan');

            // Untuk menyimpan ID transaksi dari blockchain sebagai bukti
            $table->string('tx_id')->nullable()->after('status_blockchain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alokasi_dana', function (Blueprint $table) {
            $table->dropColumn(['status_blockchain', 'tx_id']);
        });
    }
};
