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
        Schema::create('sisemars', function (Blueprint $table) {
            $table->id();

            // Data Peserta SISEMAR
            $table->string('email')->unique();
            $table->string('name');
            $table->string('school');
            $table->string('wa_number');
            $table->string('major_preference_1');
            $table->string('major_preference_2');
            $table->enum('free_consultation', ['Iya', 'Tidak'])->default('Tidak');

            // Data Pembayaran
            $table->string('payment'); // Metode pembayaran
            $table->enum('payment_status', ['DP', 'LUNAS'])->default('DP');

            // Status & Tiket Digital
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->string('e_ticket_code')->unique()->nullable(); // Untuk Absen
            
            // Absensi Hari H
            $table->timestamp('checked_in_at')->nullable(); // waktu scan masuk event

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisemars');
    }
};