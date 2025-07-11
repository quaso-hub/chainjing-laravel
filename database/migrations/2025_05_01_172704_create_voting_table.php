<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('voting', function (Blueprint $table) {
            $table->id();
            $table->string('vote_id')->unique();
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('ruu_id')->constrained('ruu');
            $table->enum('pilihan', ['SETUJU', 'TOLAK',"ABSTAIN"]);
            $table->timestamp('waktu_vote')->nullable();
            $table->string('voting_hash', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting');
    }
};
