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
            // Add examination_id if it doesn't exist
            if (!Schema::hasColumn('treatments', 'examination_id')) {
                $table->foreignId('examination_id')->nullable()->after('patient_id')
                    ->constrained('examinations')->nullOnDelete();
            }
            
            // Rename doctor_id to treating_doctor_id if it exists
            if (Schema::hasColumn('treatments', 'doctor_id')) {
                $table->renameColumn('doctor_id', 'treating_doctor_id');
            } else if (!Schema::hasColumn('treatments', 'treating_doctor_id')) {
                $table->foreignId('treating_doctor_id')->after('examination_id')
                    ->constrained('users')->cascadeOnDelete();
            }

            // Add new columns only if they don't exist
            if (!Schema::hasColumn('treatments', 'treatment_type')) {
                $table->string('treatment_type')->after('treatment_date');
            }
            if (!Schema::hasColumn('treatments', 'right_eye_treated')) {
                $table->boolean('right_eye_treated')->default(false)->after('treatment_type');
            }
            if (!Schema::hasColumn('treatments', 'left_eye_treated')) {
                $table->boolean('left_eye_treated')->default(false)->after('right_eye_treated');
            }
            if (!Schema::hasColumn('treatments', 'right_eye_treatment_notes')) {
                $table->text('right_eye_treatment_notes')->nullable()->after('left_eye_treated');
            }
            if (!Schema::hasColumn('treatments', 'left_eye_treatment_notes')) {
                $table->text('left_eye_treatment_notes')->nullable()->after('right_eye_treatment_notes');
            }
            if (!Schema::hasColumn('treatments', 'follow_up_date')) {
                $table->date('follow_up_date')->nullable()->after('left_eye_treatment_notes');
            }
            if (!Schema::hasColumn('treatments', 'post_treatment_instructions')) {
                $table->text('post_treatment_instructions')->nullable()->after('follow_up_date');
            }
            if (!Schema::hasColumn('treatments', 'complications')) {
                $table->text('complications')->nullable()->after('post_treatment_instructions');
            }

            // Drop old columns if they exist
            if (Schema::hasColumn('treatments', 'right_eye_treatment')) {
                $table->dropColumn('right_eye_treatment');
            }
            if (Schema::hasColumn('treatments', 'left_eye_treatment')) {
                $table->dropColumn('left_eye_treatment');
            }
            if (Schema::hasColumn('treatments', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('treatments', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            // Restore old columns
            $table->string('right_eye_treatment')->nullable();
            $table->string('left_eye_treatment')->nullable();
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();

            // Drop new columns
            $table->dropColumn([
                'treatment_type',
                'right_eye_treated',
                'left_eye_treated',
                'right_eye_treatment_notes',
                'left_eye_treatment_notes',
                'follow_up_date',
                'post_treatment_instructions',
                'complications'
            ]);

            // Restore doctor_id if it was renamed
            if (Schema::hasColumn('treatments', 'treating_doctor_id')) {
                $table->renameColumn('treating_doctor_id', 'doctor_id');
            }

            $table->dropConstrainedForeignId('examination_id');
        });
    }
};
