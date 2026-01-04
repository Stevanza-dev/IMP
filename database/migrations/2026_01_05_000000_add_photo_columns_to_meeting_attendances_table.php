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
        Schema::table('meeting_attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('meeting_attendances', 'photo_public_id')) {
                $table->string('photo_public_id')->nullable()->after('notes');
            }

            if (!Schema::hasColumn('meeting_attendances', 'photo_url')) {
                $table->string('photo_url')->nullable()->after('photo_public_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_attendances', function (Blueprint $table) {
            if (Schema::hasColumn('meeting_attendances', 'photo_url')) {
                $table->dropColumn('photo_url');
            }

            if (Schema::hasColumn('meeting_attendances', 'photo_public_id')) {
                $table->dropColumn('photo_public_id');
            }
        });
    }
};
