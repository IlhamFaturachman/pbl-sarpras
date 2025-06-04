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
        // Hapus kolom fasum_id dan ruang_id dari m_kerusakan
        Schema::table('m_kerusakan', function (Blueprint $table) {
            $table->dropForeign(['fasum_id']);
            $table->dropColumn('fasum_id');

            $table->dropForeign(['ruang_id']);
            $table->dropColumn('ruang_id');
        });

        // Hapus kolom user_id dari m_feedback
        Schema::table('m_feedback', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Ubah kolom status_penugasan menjadi nullable di m_laporan
        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->string('status_penugasan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tambahkan kembali kolom fasum_id dan ruang_id di m_kerusakan
        Schema::table('m_kerusakan', function (Blueprint $table) {
            $table->unsignedBigInteger('fasum_id');
            $table->foreign('fasum_id')->references('fasum_id')->on('m_fasum');

            $table->unsignedBigInteger('ruang_id');
            $table->foreign('ruang_id')->references('ruang_id')->on('m_ruang');
        });

        // Tambahkan kembali kolom user_id di m_feedback
        Schema::table('m_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });

        // Kembalikan status_penugasan menjadi tidak nullable
        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->string('status_penugasan')->nullable(false)->change();
        });
    }
};
