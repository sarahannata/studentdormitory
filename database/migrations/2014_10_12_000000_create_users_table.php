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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('telepon')->nullable();
            $table->string('posisi');
            $table->unsignedBigInteger('divisi_id')->nullable(); // pastikan ini ada sebelum foreign key
            $table->foreign('divisi_id')->references('id')->on('divisi')->onDelete('set null');
            $table->string('foto')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['admin', 'pimpinan', 'pegawai'])->default('pegawai');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
