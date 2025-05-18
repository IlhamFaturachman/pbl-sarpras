<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menghapus kolom tempat_kerusakan dari tabel m_kerusakan.
     */
    public function up(): void
    {
        Schema::table('m_kerusakan', function (Blueprint $table) {
            if (Schema::hasColumn('m_kerusakan', 'tempat_kerusakan')) {
                $table->dropColumn('tempat_kerusakan');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Menambahkan kembali kolom tempat_kerusakan (nullable) ke tabel m_kerusakan.
     */
    public function down(): void
    {
        Schema::table('m_kerusakan', function (Blueprint $table) {
            $table->string('tempat_kerusakan')->nullable()->after('kerusakan_id');
        });
    }
};
