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
        Schema::create('mahasiswa_bimbingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_pembimbing_id');
            $table->foreign('dosen_pembimbing_id')->references('id')->on('dosen_pembimbings')->onDelete('cascade');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_bimbingans');
    }
};
