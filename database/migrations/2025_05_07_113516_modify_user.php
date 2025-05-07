<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->string('nama_lengkap')->after('user_id');
            $table->string('nomor_induk')->after('nama_lengkap');
            $table->string('status')->after('remember_token');
        });
    }
    
    public function down(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'nomor_induk', 'status']);
        });
    }
    
};
