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
        Schema::create('work_programs', function (Blueprint $table) {
            $table->id();
            
            // Relasi: Proker ini milik divisi apa?
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            
            $table->string('name'); // Misal: "SI SEMAR 2026"
            $table->text('description');
            $table->date('execution_date'); // Tanggal Pelaksanaan
            $table->boolean('is_active')->default(true); // Status: Terlaksana/Belum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_programs');
    }
};
