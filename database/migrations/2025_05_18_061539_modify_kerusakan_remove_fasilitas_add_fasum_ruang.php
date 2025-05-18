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
        // 1. Hapus foreign key dan kolom fasilitas_id dari m_kerusakan
        Schema::table('m_kerusakan', function (Blueprint $table) {
            if (Schema::hasColumn('m_kerusakan', 'fasilitas_id')) {
                $table->dropForeign(['fasilitas_id']);
                $table->dropColumn('fasilitas_id');
            }
        });

        // 2. Tambahkan kolom fasum_id dan ruang_id baru ke m_kerusakan
        Schema::table('m_kerusakan', function (Blueprint $table) {
            $table->unsignedBigInteger('fasum_id')->nullable()->after('item_id');
            $table->unsignedBigInteger('ruang_id')->nullable()->after('fasum_id');

            $table->foreign('fasum_id')->references('fasum_id')->on('m_fasum')->onDelete('set null');
            $table->foreign('ruang_id')->references('ruang_id')->on('m_ruang')->onDelete('set null');
        });

        // 3. Hapus foreign key dari m_fasilitas sebelum dihapus
        Schema::table('m_fasilitas', function (Blueprint $table) {
            $table->dropForeign(['gedung_id']);
            $table->dropForeign(['ruang_id']);
            $table->dropForeign(['fasum_id']);
        });

        // 4. Hapus tabel m_fasilitas
        Schema::dropIfExists('m_fasilitas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Buat ulang tabel m_fasilitas
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

        // 2. Tambahkan kembali kolom fasilitas_id ke m_kerusakan
        Schema::table('m_kerusakan', function (Blueprint $table) {
            $table->unsignedBigInteger('fasilitas_id')->nullable()->after('item_id');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('m_fasilitas')->onDelete('restrict');

            // Hapus kolom fasum_id dan ruang_id
            $table->dropForeign(['fasum_id']);
            $table->dropForeign(['ruang_id']);
            $table->dropColumn(['fasum_id', 'ruang_id']);
        });
    }
};
