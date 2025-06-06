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
        Schema::table('m_laporan', function (Blueprint $table) {
            $table->dropForeign(['pelapor_id']); 
            $table->dropColumn('pelapor_id');     
        });

        Schema::table('m_kerusakan', function (Blueprint $table) {
            $table->unsignedBigInteger('pelapor_id')->after('kerusakan_id'); 
            $table->foreign('pelapor_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tambahkan kembali pelapor_id ke m_laporan
        Schema::table('m_laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('pelapor_id')->after('id');
            $table->foreign('pelapor_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });

        // Hapus pelapor_id dari m_kerusakan
        Schema::table('m_kerusakan', function (Blueprint $table) {
            $table->dropForeign(['pelapor_id']);
            $table->dropColumn('pelapor_id');
        });
    }
};
