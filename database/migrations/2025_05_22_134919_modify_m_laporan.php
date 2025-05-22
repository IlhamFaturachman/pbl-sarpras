<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class modifyMLaporan extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('m_laporan', function (Blueprint $table) {
            // Hapus kolom prioritas
            if (Schema::hasColumn('m_laporan', 'prioritas')) {
                $table->dropColumn('prioritas');
            }

            // Tambahkan foreign key ke periode_id
            if (!Schema::hasColumn('m_laporan', 'periode_id')) {
                $table->unsignedBigInteger('periode_id')->nullable()->after('teknisi_id');
                $table->foreign('periode_id')->references('periode_id')->on('m_periode')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_laporan', function (Blueprint $table) {
            // Tambahkan kembali kolom prioritas
            if (!Schema::hasColumn('m_laporan', 'prioritas')) {
                $table->string('prioritas', 255)->nullable()->after('status_laporan');
            }

            // Hapus foreign key dan kolom periode_id
            if (Schema::hasColumn('m_laporan', 'periode_id')) {
                $table->dropForeign(['periode_id']);
                $table->dropColumn('periode_id');
            }
        });
    }
}
