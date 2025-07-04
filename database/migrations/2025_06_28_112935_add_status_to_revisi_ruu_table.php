<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('revisi_ruu', function (Blueprint $table) {
            // Tambahkan kolom status setelah kolom 'alasan' atau 'isi_revisi'
            // Default 'Diajukan' agar data lama/baru otomatis terisi
            $table->string('status')->default('Diajukan')->after('alasan');
        });
    }

    public function down(): void
    {
        Schema::table('revisi_ruu', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
