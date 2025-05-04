<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->unsignedBigInteger('pelapor_id');
            $table->unsignedBigInteger('kerusakan_id');
            $table->string('status_laporan');
            $table->string('prioritas');
            $table->date('tanggal_laporan');
            $table->date('tanggal_update_status')->nullable();
            $table->unsignedBigInteger('teknisi_id')->nullable();
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->timestamps();

            $table->foreign('pelapor_id')->references('user_id')->on('m_user');
            $table->foreign('kerusakan_id')->references('kerusakan_id')->on('m_kerusakan');
            $table->foreign('teknisi_id')->references('user_id')->on('m_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_laporan');
    }
};
