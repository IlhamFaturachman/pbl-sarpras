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
        Schema::dropIfExists('m_prioritas'); // Menghapus tabel lama jika ada

        Schema::create('m_prioritas', function (Blueprint $table) {
            $table->id('prioritas_id');
            $table->unsignedBigInteger('laporan_id');
            $table->enum('tingkat_kerusakan', ['rendah', 'sedang', 'tinggi']);
            $table->enum('dampak', ['rendah', 'sedang', 'tinggi']);
            $table->enum('jumlah_terdampak', ['rendah', 'sedang', 'tinggi']);
            $table->boolean('alternatif'); // 0 = ada, 1 = tidak ada
            $table->enum('ancaman', ['rendah', 'sedang', 'tinggi']);
            $table->decimal('skor_fuzzy', 5, 2)->nullable(); // Nilai akhir fuzzy (0.00 - 1.00)
            $table->enum('tingkat_prioritas', ['Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'])->nullable(); // Output dari fuzzy
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
