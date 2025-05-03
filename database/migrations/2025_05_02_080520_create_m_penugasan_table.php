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
        Schema::create('m_penugasan', function (Blueprint $table) {
            $table->id('penugasan_id');
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('teknisi_id');
            $table->string('status_penugasan')->comment('belum dikerjakan / sedang dikerjakan / selesai');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan_perbaikan')->nullable();
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan')->onDelete('cascade');
            $table->foreign('teknisi_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_penugasan');
    }
};
