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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('logbook_id');
            $table->foreign('logbook_id')->references('id')->on('logbook')->onDelete('cascade');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->unsignedBigInteger('dosen_pembimbing_id');
            $table->foreign('dosen_pembimbing_id')->references('id')->on('dosen_pembimbing')->onDelete('cascade');
            $table->longText('hasil_konsultasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
