<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');
            $table->string('kelas');
            $table->string('email')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('judul_pengaduan');
            $table->text('deskripsi_pengaduan');
            $table->string('lokasi')->nullable();
            $table->enum('status', ['Belum Diproses', 'Sedang Diproses', 'Selesai'])->default('Belum Diproses');
            $table->date('tanggal_pengaduan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};