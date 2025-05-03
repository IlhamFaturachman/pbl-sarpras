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
        Schema::create('m_kerusakan', function (Blueprint $table) {
            $table->id('kerusakan_id');
            $table->string('tempat_kerusakan')->comment('fasum / gedung / ruang');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('fasilitas_id');
            $table->text('deskripsi_kerusakan');
            $table->string('foto_kerusakan');
            $table->timestamps();

            $table->foreign('item_id')->references('item_id')->on('m_item')->onDelete('restrict');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('m_fasilitas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kerusakan');
    }
};
