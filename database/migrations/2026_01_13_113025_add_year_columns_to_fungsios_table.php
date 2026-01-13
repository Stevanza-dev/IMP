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
        Schema::table('fungsios', function (Blueprint $table) {
            //menambahkan kolom year ke tabel fungsio
            $table->integer('year')->nullable()->after('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fungsios', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};
