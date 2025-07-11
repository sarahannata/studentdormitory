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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable(); // Bisa null untuk jadwal harian
            $table->string('tipe_kehadiran');
            $table->enum('tipe_jadwal', ['tanggal', 'setiap_hari'])->default('tanggal');
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
