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
        Schema::table('official_resellers', function (Blueprint $table) {
            $table->foreignId('city_id')->after('id')->constrained('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('official_resellers', function (Blueprint $table) {
            // Hapus foreign key dan kolom city_id saat rollback
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
