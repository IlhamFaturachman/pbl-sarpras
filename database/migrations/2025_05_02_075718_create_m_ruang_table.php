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
        Schema::create('m_ruang', function (Blueprint $table) {
            $table->id('ruang_id');
            $table->string('nama');
            $table->unsignedBigInteger('gedung_id');
            $table->integer('lantai');
            $table->text('lokasi');
            $table->timestamps();

            $table->foreign('gedung_id')->references('gedung_id')->on('m_gedung')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_ruang');
    }
};
