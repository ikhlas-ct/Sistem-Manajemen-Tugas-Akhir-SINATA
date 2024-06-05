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
        Schema::create('detail_jadwal_acara', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('jadwal_acara_id');
            $table->foreign('jadwal_acara_id')->references('id')->on('jadwal_acara')->onDelete('cascade');
            $table->unsignedBigInteger('dosen_pembimbing_id');
            $table->foreign('dosen_pembimbing_id')->references('id')->on('dosen_pembimbing')->onDelete('cascade');
            $table->unsignedBigInteger('dosen_penguji_id');
            $table->foreign('dosen_penguji_id')->references('id')->on('dosen_penguji')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jadwal_acara');
    }
};
