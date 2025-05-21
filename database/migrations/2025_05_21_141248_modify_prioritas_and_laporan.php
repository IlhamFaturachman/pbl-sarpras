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
        // Hapus kolom 'periode_id' dari tabel m_laporan jika ada
        Schema::table('m_laporan', function (Blueprint $table) {
            if (Schema::hasColumn('m_laporan', 'periode_id')) {
                $table->dropColumn('periode_id'); // hapus kolom
            }
        });

        // Tambahkan ulang kolom 'periode_id' dan tetapkan foreign key
        Schema::table('m_laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('periode_id')->after('teknisi_id');
            
            $table->foreign('periode_id')->references('periode_id')->on('m_periode')->onDelete('cascade');
        });

        // Buat ulang tabel m_prioritas
        Schema::dropIfExists('m_prioritas');

        Schema::create('m_prioritas', function (Blueprint $table) {
            $table->id('prioritas_id');
            $table->unsignedBigInteger('laporan_id');
            $table->double('tingkat_kerusakan');
            $table->double('dampak');
            $table->double('jumlah_terdampak');
            $table->boolean('alternatif'); // 0 = tidak ada, 1 = ada
            $table->double('ancaman');
            $table->double('skor_laporan')->nullable();
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

        Schema::table('m_laporan', function (Blueprint $table) {
            $table->dropForeign(['periode_id']);
            $table->dropColumn('periode_id');
        });
    }
};
