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
        Schema::create('judul_tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_bimbingan_id');
            $table->foreign('mahasiswa_bimbingan_id')->references('id')->on('mahasiswa_bimbingan')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('file');             
            $table->enum('status,',['diterima','ditolak','diproses'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judul_tugas_akhir');
    }
};
