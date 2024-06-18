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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('mahasiswa_bimbingan_id');
            $table->longText('Materi_Bimbingan')->default(1);
            $table->enum('status', ['Diterima', 'Ditolak', 'Diproses'])->default('Diproses');
            $table->timestamps();

            $table->foreign('mahasiswa_bimbingan_id')->references('id')->on('mahasiswa_bimbingans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
