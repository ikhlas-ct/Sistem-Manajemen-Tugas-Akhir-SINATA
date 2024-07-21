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
        Schema::create('penilaian_seminars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seminar_proposal_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('dosen_id');
            $table->integer('nilai');
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->foreign('seminar_proposal_id')->references('id')->on('seminar_proposals')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id')->on('penilaians')->onDelete('cascade');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_seminars'); // Pastikan nama tabel sesuai
    }
};
