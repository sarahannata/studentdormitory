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
        Schema::create('cuti_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Karyawan pengaju
            $table->enum('keterangan', ['Sakit', 'Izin']); // Pilihan cuti atau izin
            $table->text('alasan'); // Alasan pengajuan
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable(); // Bisa null kalau hanya satu hari
            $table->enum('status', ['Dalam proses', 'Disetujui', 'Ditolak'])->default('Dalam Proses'); // Status pengajuan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti_izin');
    }
};
