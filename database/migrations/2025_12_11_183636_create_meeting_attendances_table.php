<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meeting_attendances', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel meetings dan members
            $table->foreignId('meeting_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');

            $table->timestamp('check_in_at');

            // Opsional: Simpan jarak peserta saat absen (untuk log/bukti)
            // Misal: "Absen dari jarak 5.4 meter"
            $table->double('distance_in_meters')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_attendances');
    }
};
