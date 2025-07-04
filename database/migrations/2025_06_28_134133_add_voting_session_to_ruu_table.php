<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ruu', function (Blueprint $table) {
            // Tambahkan kolom setelah kolom 'status'
            $table->timestamp('voting_mulai')->nullable()->after('status');
            $table->timestamp('voting_selesai')->nullable()->after('voting_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('ruu', function (Blueprint $table) {
            $table->dropColumn(['voting_mulai', 'voting_selesai']);
        });
    }
};
