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
        // Update existing comites table: tambah info pembuat, verifikator, status
        Schema::table('comites', function (Blueprint $table) {
            // Hapus relasi lama jika ada
            if (Schema::hasColumn('comites', 'fungsio_id')) {
                $table->dropForeign(['fungsio_id']);
            }

            // Tambah kolom baru
            $table->foreignId('created_by_fungsio_id')->after('work_program_id')->constrained('fungsios')->cascadeOnDelete();
            $table->foreignId('verified_by_fungsio_id')->nullable()->after('created_by_fungsio_id')->constrained('fungsios')->nullOnDelete();

            $table->string('title')->nullable()->after('verified_by_fungsio_id');
            $table->text('description')->nullable()->after('title');

            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft')->after('description');
            $table->timestamp('verified_at')->nullable()->after('status');

            // Hapus kolom sie tunggal karena sekarang akan dipisah per sie
            if (Schema::hasColumn('comites', 'sie')) {
                $table->dropColumn('sie');
            }

            // Hapus kolom fungsio_id lama jika tidak lagi dipakai
            if (Schema::hasColumn('comites', 'fungsio_id')) {
                $table->dropColumn('fungsio_id');
            }
        });

        // Tabel untuk daftar sie (ketua panitia, acara, humas, dll) per kepanitiaan
        Schema::create('comite_sies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comite_id')->constrained('comites')->cascadeOnDelete();
            $table->string('name'); // contoh: "Ketua Panitia", "Sie Acara"
            $table->timestamps();
        });

        // Tabel anggota sie (koor dan anggota) per kepanitiaan
        Schema::create('comite_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comite_id')->constrained('comites')->cascadeOnDelete();
            $table->foreignId('comite_sie_id')->constrained('comite_sies')->cascadeOnDelete();
            $table->foreignId('fungsio_id')->constrained('fungsios')->cascadeOnDelete();
            $table->enum('role', ['ketua', 'koor', 'anggota'])->default('anggota');
            $table->timestamps();

            $table->unique(['comite_sie_id', 'fungsio_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comite_members');
        Schema::dropIfExists('comite_sies');

        Schema::table('comites', function (Blueprint $table) {
            if (Schema::hasColumn('comites', 'created_by_fungsio_id')) {
                $table->dropForeign(['created_by_fungsio_id']);
                $table->dropColumn('created_by_fungsio_id');
            }

            if (Schema::hasColumn('comites', 'verified_by_fungsio_id')) {
                $table->dropForeign(['verified_by_fungsio_id']);
                $table->dropColumn('verified_by_fungsio_id');
            }

            if (Schema::hasColumn('comites', 'title')) {
                $table->dropColumn('title');
            }

            if (Schema::hasColumn('comites', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('comites', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('comites', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
        });
    }
};
