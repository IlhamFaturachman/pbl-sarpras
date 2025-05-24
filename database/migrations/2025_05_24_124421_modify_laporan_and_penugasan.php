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
        // Hapus foreign key terlebih dahulu sebelum drop kolom
        Schema::table('m_laporan', function (Blueprint $table) {
            $table->dropForeign(['teknisi_id']);
            $table->dropColumn('teknisi_id');
        });

        // Tambah kolom bukti_perbaikan ke m_penugasan
        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->string('bukti_perbaikan')->nullable()->after('catatan_perbaikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tambahkan kembali kolom teknisi_id ke m_laporan
        Schema::table('m_laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('teknisi_id')->nullable();

            // Tambahkan kembali foreign key jika diperlukan
            $table->foreign('teknisi_id')->references('id')->on('users')->onDelete('set null');
        });

        // Hapus kolom bukti_perbaikan dari m_penugasan
        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->dropColumn('bukti_perbaikan');
        });
    }
};
