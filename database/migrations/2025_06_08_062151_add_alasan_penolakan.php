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
            $table->text('alasan_penolakan')->after('periode_id')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_laporan', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
        });
    }
};
