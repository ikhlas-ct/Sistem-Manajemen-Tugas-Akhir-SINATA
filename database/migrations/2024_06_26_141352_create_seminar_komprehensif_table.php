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
            $table->text('transkrip_nilai');
            $table->text('Kartu_Bimbingan');
            $table->text('sertifikat_pkl');
            $table->text('KRS');
            $table->text('komentar_penguji_1')->nullable();
            $table->text('komentar_penguji_2')->nullable();


            $table->unsignedBigInteger('dosen_penguji_1_id')->nullable();
            $table->foreign('dosen_penguji_1_id')->references('id')->on('dosen')->onDelete('cascade'); 
            $table->unsignedBigInteger('dosen_penguji_2_id')->nullable();
            $table->foreign('dosen_penguji_2_id')->references('id')->on('dosen')->onDelete('cascade'); 
            $table->dateTime('tanggal_waktu')->nullable();
            $table->foreignId('ruangan_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('status_prodi', ['diterima', 'direvisi', 'diproses','lulus'])->default('diproses');
            $table->enum('validasi_pembimbing', ['valid', 'ditolak','diproses'])->default('diproses');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seminar_komprehensif');
    }
}

