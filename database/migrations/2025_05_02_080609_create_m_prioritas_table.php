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
        Schema::create('m_prioritas', function (Blueprint $table) {
            $table->id('prioritas_id');
            $table->unsignedBigInteger('laporan_id');
            $table->float('tingkat_urgensi');
            $table->float('tingkat_dampak');
            $table->float('total_skoring');
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_prioritas');
    }
};
