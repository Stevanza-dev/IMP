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
        Schema::create('medpart_package_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medpart_package_id')->constrained('medpart_packages')->onDelete('cascade');
            $table->enum('type', ['requirement', 'feedback']);
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medpart_package_details');
    }
};
