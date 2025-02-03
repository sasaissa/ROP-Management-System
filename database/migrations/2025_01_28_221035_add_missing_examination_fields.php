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
            // Right Eye Fields
            if (!Schema::hasColumn('examinations', 'right_eye_plus')) {
                $table->string('right_eye_plus')->nullable();
            }
            if (!Schema::hasColumn('examinations', 'right_eye_ap_rop')) {
                $table->boolean('right_eye_ap_rop')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'right_eye_regression_status')) {
                $table->string('right_eye_regression_status')->nullable();
            }
            if (!Schema::hasColumn('examinations', 'right_eye_par')) {
                $table->text('right_eye_par')->nullable();
            }
            if (!Schema::hasColumn('examinations', 'right_eye_arteriolar_tortuosity')) {
                $table->boolean('right_eye_arteriolar_tortuosity')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'right_eye_venular_dilation')) {
                $table->boolean('right_eye_venular_dilation')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'right_eye_iris_vessel_dilation')) {
                $table->boolean('right_eye_iris_vessel_dilation')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'right_eye_vitreous_haze')) {
                $table->boolean('right_eye_vitreous_haze')->default(false);
            }

            // Left Eye Fields
            if (!Schema::hasColumn('examinations', 'left_eye_plus')) {
                $table->string('left_eye_plus')->nullable();
            }
            if (!Schema::hasColumn('examinations', 'left_eye_ap_rop')) {
                $table->boolean('left_eye_ap_rop')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'left_eye_regression_status')) {
                $table->string('left_eye_regression_status')->nullable();
            }
            if (!Schema::hasColumn('examinations', 'left_eye_par')) {
                $table->text('left_eye_par')->nullable();
            }
            if (!Schema::hasColumn('examinations', 'left_eye_arteriolar_tortuosity')) {
                $table->boolean('left_eye_arteriolar_tortuosity')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'left_eye_venular_dilation')) {
                $table->boolean('left_eye_venular_dilation')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'left_eye_iris_vessel_dilation')) {
                $table->boolean('left_eye_iris_vessel_dilation')->default(false);
            }
            if (!Schema::hasColumn('examinations', 'left_eye_vitreous_haze')) {
                $table->boolean('left_eye_vitreous_haze')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            // Right Eye Fields
            $table->dropColumn([
                'right_eye_plus',
                'right_eye_ap_rop',
                'right_eye_regression_status',
                'right_eye_par',
                'right_eye_arteriolar_tortuosity',
                'right_eye_venular_dilation',
                'right_eye_iris_vessel_dilation',
                'right_eye_vitreous_haze'
            ]);

            // Left Eye Fields
            $table->dropColumn([
                'left_eye_plus',
                'left_eye_ap_rop',
                'left_eye_regression_status',
                'left_eye_par',
                'left_eye_arteriolar_tortuosity',
                'left_eye_venular_dilation',
                'left_eye_iris_vessel_dilation',
                'left_eye_vitreous_haze'
            ]);
        });
    }
};
