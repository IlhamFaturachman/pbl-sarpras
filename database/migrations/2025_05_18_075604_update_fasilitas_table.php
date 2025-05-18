<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // m_fasum: drop kode and lokasi
        Schema::table('m_fasum', function (Blueprint $table) {
            if (Schema::hasColumn('m_fasum', 'kode')) {
                $table->dropColumn('kode');
            }
            if (Schema::hasColumn('m_fasum', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
        });

        // m_gedung: drop lokasi
        Schema::table('m_gedung', function (Blueprint $table) {
            if (Schema::hasColumn('m_gedung', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
        });

        // m_ruang: drop lokasi, add kode (VARCHAR 10)
        Schema::table('m_ruang', function (Blueprint $table) {
            if (Schema::hasColumn('m_ruang', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
            if (!Schema::hasColumn('m_ruang', 'kode')) {
                $table->string('kode', 10)->after('ruang_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // m_fasum: add back kode and lokasi
        Schema::table('m_fasum', function (Blueprint $table) {
            if (!Schema::hasColumn('m_fasum', 'kode')) {
                $table->string('kode', 255);
            }
            if (!Schema::hasColumn('m_fasum', 'lokasi')) {
                $table->text('lokasi');
            }
        });

        // m_gedung: add back lokasi
        Schema::table('m_gedung', function (Blueprint $table) {
            if (!Schema::hasColumn('m_gedung', 'lokasi')) {
                $table->text('lokasi');
            }
        });

        // m_ruang: drop kode, add back lokasi
        Schema::table('m_ruang', function (Blueprint $table) {
            if (Schema::hasColumn('m_ruang', 'kode')) {
                $table->dropColumn('kode');
            }
            if (!Schema::hasColumn('m_ruang', 'lokasi')) {
                $table->text('lokasi');
            }
        });
    }
};
