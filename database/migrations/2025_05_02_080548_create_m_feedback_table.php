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
        Schema::create('m_feedback', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('rating');
            $table->text('komentar')->nullable();
            $table->date('tanggal_feedback')->nullable();
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_feedback');
    }
};
