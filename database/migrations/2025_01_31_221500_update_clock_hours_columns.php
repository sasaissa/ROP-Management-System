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
        Schema::table('examinations', function (Blueprint $table) {
            // First add temporary columns
            $table->json('temp_right_eye_clock_hours')->nullable();
            $table->json('temp_left_eye_clock_hours')->nullable();
        });

        // Drop original columns and rename temporary ones
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['right_eye_clock_hours', 'left_eye_clock_hours']);
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->renameColumn('temp_right_eye_clock_hours', 'right_eye_clock_hours');
            $table->renameColumn('temp_left_eye_clock_hours', 'left_eye_clock_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            // First add temporary columns
            $table->integer('temp_right_eye_clock_hours')->nullable();
            $table->integer('temp_left_eye_clock_hours')->nullable();
        });

        // Drop JSON columns and rename temporary ones
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['right_eye_clock_hours', 'left_eye_clock_hours']);
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->renameColumn('temp_right_eye_clock_hours', 'right_eye_clock_hours');
            $table->renameColumn('temp_left_eye_clock_hours', 'left_eye_clock_hours');
        });
    }
};
