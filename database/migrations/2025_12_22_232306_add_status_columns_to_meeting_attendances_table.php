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
        if (!Schema::hasColumn('meeting_attendances', 'status')) {
            Schema::table('meeting_attendances', function (Blueprint $table) {
                $table->string('status')->default('present')->after('check_in_at');
            });
        }

        if (!Schema::hasColumn('meeting_attendances', 'notes')) {
            Schema::table('meeting_attendances', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_attendances', function (Blueprint $table) {
            $table->dropColumn(['status', 'notes']);
        });
    }
};
