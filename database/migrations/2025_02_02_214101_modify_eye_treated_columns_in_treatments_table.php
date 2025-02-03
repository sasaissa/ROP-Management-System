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
        Schema::table('treatments', function (Blueprint $table) {
            // Drop existing columns if they exist
            $table->dropColumn(['right_eye_treated', 'left_eye_treated', 'eye_treated']);

            // Add new columns with proper defaults
            $table->boolean('right_eye_treated')->default(false)->after('location');
            $table->boolean('left_eye_treated')->default(false)->after('right_eye_treated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->dropColumn(['right_eye_treated', 'left_eye_treated']);
            $table->string('eye_treated')->nullable();
        });
    }
};
