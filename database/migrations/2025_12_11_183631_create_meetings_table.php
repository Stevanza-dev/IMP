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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Rapat, misal "Rapat Pleno 1"
            $table->date('date');
            
            // Titik Pusat Lokasi Rapat (Koordinat Admin saat buat rapat)
            $table->decimal('latitude', 10, 8); 
            $table->decimal('longitude', 11, 8);
            
            // Token unik untuk Link QR (agar tidak bisa ditebak url-nya)
            // Contoh: imp-pati.org/absen-rapat/rahasia-x7z99
            $table->string('token')->unique(); 
            
            $table->boolean('is_active')->default(true); // Admin bisa tutup absen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
