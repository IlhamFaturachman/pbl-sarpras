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
        Schema::table('m_item', function (Blueprint $table) {
            $table->unsignedBigInteger('fasum_id')->after('ruang_id')->nullable(); 
            $table->foreign('fasum_id')
                  ->references('fasum_id')
                  ->on('m_fasum')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_item', function (Blueprint $table) {
            $table->dropForeign(['fasum_id']);
            $table->dropColumn('fasum_id');
        });
    }
};
