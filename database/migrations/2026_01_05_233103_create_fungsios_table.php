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
        Schema::create('fungsios', function (Blueprint $table) {
            $table->id();

            // Relasi ke users, divisions, dan periods
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('division_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_id')->constrained()->cascadeOnDelete();

            // Data profil fungsio
            $table->string('nickname')->nullable();
            $table->string('nim', 30)->nullable();
            $table->string('jabatan');

            $table->string('foto_public')->nullable();
            $table->string('foto_url')->nullable();

            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();

            // status: alumni / aktif
            $table->enum('status', ['alumni', 'aktif'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fungsios');
    }
};
