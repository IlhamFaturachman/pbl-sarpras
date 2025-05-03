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
        Schema::create('m_fasilitas', function (Blueprint $table) {
            $table->id('fasilitas_id');
            $table->string('nama');
            $table->string('tipe_lokasi')->comment('fasum / gedung / ruang');
            $table->unsignedBigInteger('gedung_id')->nullable();
            $table->unsignedBigInteger('ruang_id')->nullable();
            $table->unsignedBigInteger('fasum_id')->nullable();
            $table->text('lokasi');
            $table->timestamps();

            $table->foreign('gedung_id')->references('gedung_id')->on('m_gedung')->onDelete('set null');
            $table->foreign('ruang_id')->references('ruang_id')->on('m_ruang')->onDelete('set null');
            $table->foreign('fasum_id')->references('fasum_id')->on('m_fasum')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_fasilitas');
    }
};
