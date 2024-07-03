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
        Schema::create('judul_tugas_akhirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_bimbingan_id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('file_judul');
            $table->text('saran')->nullable();
            $table->enum('status', ['diterima', 'ditolak', 'diproses'])->default('diproses');
            $table->timestamps();

            $table->foreign('mahasiswa_bimbingan_id')->references('id')->on('mahasiswa_bimbingans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judul_tugas_akhirs');
    }
};
