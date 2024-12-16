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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('ruangan_id')->constrained('ruangans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('ukm_id')->constrained('ukms')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('tanggal_pesan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->text('tujuan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
