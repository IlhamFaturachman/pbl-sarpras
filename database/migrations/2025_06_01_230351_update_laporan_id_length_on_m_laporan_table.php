<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('m_laporan', function (Blueprint $table) {
            // Ubah panjang kolom laporan_id menjadi 36 karakter
            $table->string('laporan_id', 36)->change();
        });
    }

    public function down()
    {
        Schema::table('m_laporan', function (Blueprint $table) {
            // Kembalikan ke panjang sebelumnya (20)
            $table->string('laporan_id', 20)->change();
        });
    }
};
