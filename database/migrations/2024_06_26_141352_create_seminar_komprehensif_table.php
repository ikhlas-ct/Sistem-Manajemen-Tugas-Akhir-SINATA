<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarKomprehensifTable extends Migration
{
    public function up()
    {
        Schema::create('seminar_komprehensif', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_bimbingan_id');
            $table->foreign('mahasiswa_bimbingan_id')->references('id')->on('mahasiswa_bimbingans')->onDelete('cascade');
            $table->string('file_KHS');
            $table->string('Kartu_Bimbingan');
            $table->unsignedBigInteger('dosen_penguji_1_id');
            $table->foreign('dosen_penguji_1_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->unsignedBigInteger('dosen_penguji_2_id');
            $table->foreign('dosen_penguji_2_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->dateTime('tanggal_waktu')->nullable();
            $table->foreignId('ruangan_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('status_prodi', ['diterima', 'ditolak', 'diproses'])->default('diproses');
            $table->enum('status_lulus', ['lulus', 'tidak_lulus'])->nullable();
            $table->decimal('nilai_penguji_1', 5, 2)->nullable();
            $table->decimal('nilai_penguji_2', 5, 2)->nullable();
            $table->enum('validasi_pembimbing', ['valid', 'tidak_valid','diproses'])->default('diproses');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seminar_komprehensif');
    }
}

