<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First add temporary columns for clock hours
        Schema::table('examinations', function (Blueprint $table) {
            $table->integer('temp_right_eye_clock_hours')->nullable();
            $table->integer('temp_left_eye_clock_hours')->nullable();
        });

        // Convert JSON clock hours to integers in temporary columns
        $examinations = DB::table('examinations')->get();
        foreach ($examinations as $examination) {
            $rightHours = null;
            $leftHours = null;

            if ($examination->right_eye_clock_hours) {
                $decoded = json_decode($examination->right_eye_clock_hours);
                $rightHours = is_array($decoded) ? $decoded[0] : $decoded;
            }

            if ($examination->left_eye_clock_hours) {
                $decoded = json_decode($examination->left_eye_clock_hours);
                $leftHours = is_array($decoded) ? $decoded[0] : $decoded;
            }
            
            DB::table('examinations')
                ->where('id', $examination->id)
                ->update([
                    'temp_right_eye_clock_hours' => $rightHours,
                    'temp_left_eye_clock_hours' => $leftHours
                ]);
        }

        // Drop original clock hours columns and rename temporary ones
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['right_eye_clock_hours', 'left_eye_clock_hours']);
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->renameColumn('temp_right_eye_clock_hours', 'right_eye_clock_hours');
            $table->renameColumn('temp_left_eye_clock_hours', 'left_eye_clock_hours');
        });

        // Handle plus disease columns
        Schema::table('examinations', function (Blueprint $table) {
            // Add new plus disease columns
            $table->boolean('right_eye_plus_disease')->default(false);
            $table->boolean('right_eye_pre_plus')->default(false);
            $table->boolean('left_eye_plus_disease')->default(false);
            $table->boolean('left_eye_pre_plus')->default(false);
        });
    }

    public function down(): void
    {
        // First add temporary columns for clock hours
        Schema::table('examinations', function (Blueprint $table) {
            $table->json('temp_right_eye_clock_hours')->nullable();
            $table->json('temp_left_eye_clock_hours')->nullable();
        });

        // Convert integers back to JSON arrays
        $examinations = DB::table('examinations')->get();
        foreach ($examinations as $examination) {
            $rightHours = $examination->right_eye_clock_hours ? json_encode([$examination->right_eye_clock_hours]) : null;
            $leftHours = $examination->left_eye_clock_hours ? json_encode([$examination->left_eye_clock_hours]) : null;
            
            DB::table('examinations')
                ->where('id', $examination->id)
                ->update([
                    'temp_right_eye_clock_hours' => $rightHours,
                    'temp_left_eye_clock_hours' => $leftHours
                ]);
        }

        // Drop integer clock hours columns and rename temporary ones
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn(['right_eye_clock_hours', 'left_eye_clock_hours']);
        });

        Schema::table('examinations', function (Blueprint $table) {
            $table->renameColumn('temp_right_eye_clock_hours', 'right_eye_clock_hours');
            $table->renameColumn('temp_left_eye_clock_hours', 'left_eye_clock_hours');
        });

        // Drop plus disease columns
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn([
                'right_eye_plus_disease',
                'right_eye_pre_plus',
                'left_eye_plus_disease',
                'left_eye_pre_plus'
            ]);
        });
    }
};
