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
        Schema::create('comites', function (Blueprint $table) {
            $table->id();

            // Relasi ke work_programs dan fungsios
            $table->foreignId('work_program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fungsio_id')->constrained()->cascadeOnDelete();

            $table->string('sie');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comites');
    }
};
