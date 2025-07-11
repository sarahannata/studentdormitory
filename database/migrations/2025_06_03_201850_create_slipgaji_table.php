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
        Schema::create('slipgaji', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nomor_slip')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('created_by')->nullable(); // penerima, relasi ke tabel users
            $table->string('metode_pembayaran'); // 'norek' atau 'cash'
            $table->string('nomor_rekening')->nullable(); // hanya diisi jika metode norek
            $table->json('rincian_gaji'); // disimpan dalam bentuk json
            $table->json('potongan_pajak');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun'); // contoh: 2025

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slipgaji');
    }
};
