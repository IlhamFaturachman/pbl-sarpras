<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLaporanIdAndAddVerifikatorId extends Migration
{
    public function up()
    {
        // Step 1: Drop foreign keys terlebih dahulu
        Schema::table('m_feedback', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        Schema::table('m_notifikasi', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        Schema::table('m_prioritas', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        // Step 2: Ubah kolom laporan_id menjadi string
        Schema::table('m_laporan', function (Blueprint $table) {
            $table->string('laporan_id', 20)->change();
            $table->unsignedBigInteger('verifikator_id')->nullable()->after('pelapor_id');
            $table->foreign('verifikator_id')->references('user_id')->on('m_user')->onDelete('set null');
        });

        Schema::table('m_feedback', function (Blueprint $table) {
            $table->string('laporan_id', 20)->change();
        });

        Schema::table('m_notifikasi', function (Blueprint $table) {
            $table->string('laporan_id', 20)->change();
        });

        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->string('laporan_id', 20)->change();
        });

        Schema::table('m_prioritas', function (Blueprint $table) {
            $table->string('laporan_id', 20)->change();
        });

        // Step 3: Tambahkan kembali foreign key
        Schema::table('m_feedback', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan')->onDelete('cascade');
        });

        Schema::table('m_notifikasi', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan')->onDelete('cascade');
        });

        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan')->onDelete('cascade');
        });

        Schema::table('m_prioritas', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Balikkan semua perubahan dan drop foreign keys baru
        Schema::table('m_feedback', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        Schema::table('m_notifikasi', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        Schema::table('m_prioritas', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
        });

        Schema::table('m_laporan', function (Blueprint $table) {
            $table->dropForeign(['verifikator_id']);
            $table->dropColumn('verifikator_id');
            $table->unsignedBigInteger('laporan_id')->change();
        });

        Schema::table('m_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('laporan_id')->change();
        });

        Schema::table('m_notifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('laporan_id')->change();
        });

        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->unsignedBigInteger('laporan_id')->change();
        });

        Schema::table('m_prioritas', function (Blueprint $table) {
            $table->unsignedBigInteger('laporan_id')->change();
        });

        // Tambahkan kembali foreign keys lama
        Schema::table('m_feedback', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan');
        });

        Schema::table('m_notifikasi', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan');
        });

        Schema::table('m_penugasan', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan');
        });

        Schema::table('m_prioritas', function (Blueprint $table) {
            $table->foreign('laporan_id')->references('laporan_id')->on('m_laporan');
        });
    }
}
