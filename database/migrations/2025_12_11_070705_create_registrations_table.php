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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            // Data Diri Peserta
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone'); // Penting: Backup jika email tidak masuk/valid
            $table->string('institution')->nullable(); // Asal Sekolah/Kampus/Instansi

            // Data Pembayaran
            $table->string('payment_method'); // Contoh: "Transfer BCA", "QRIS"
            $table->string('payment_proof'); // Menyimpan path/lokasi file gambar

            // Status Sistem
            // ticket_code: Kosong saat daftar, diisi otomatis saat Admin Approve
            $table->string('ticket_code')->unique()->nullable();

            // status: 'pending' (baru daftar), 'confirmed' (sudah bayar & valid), 'rejected' (bukti palsu)
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');

            // Absensi Hari H
            $table->timestamp('checked_in_at')->nullable(); // Jika terisi = Sudah hadir

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
