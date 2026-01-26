<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umpan_baliks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspirasi_id')->constrained('aspirasis')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->text('isi_umpan_balik');
            $table->date('tanggal_umpan_balik');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umpan_baliks');
    }
};