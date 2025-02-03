<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            // Right Eye Fields
            $table->string('right_eye_plus')->nullable();
            $table->json('right_eye_clock_hours')->nullable();
            $table->boolean('right_eye_ap_rop')->default(false);
            $table->string('right_eye_regression_status')->nullable();
            $table->text('right_eye_par')->nullable();
            $table->boolean('right_eye_arteriolar_tortuosity')->default(false);
            $table->boolean('right_eye_venular_dilation')->default(false);
            $table->boolean('right_eye_iris_vessel_dilation')->default(false);
            $table->boolean('right_eye_vitreous_haze')->default(false);
            $table->string('right_eye_funnel_config')->nullable();
            $table->string('right_eye_macular_status')->nullable();
            $table->boolean('right_eye_hemorrhages')->default(false);
            $table->boolean('right_eye_fibrovascular_changes')->default(false);

            // Left Eye Fields
            $table->string('left_eye_plus')->nullable();
            $table->json('left_eye_clock_hours')->nullable();
            $table->boolean('left_eye_ap_rop')->default(false);
            $table->string('left_eye_regression_status')->nullable();
            $table->text('left_eye_par')->nullable();
            $table->boolean('left_eye_arteriolar_tortuosity')->default(false);
            $table->boolean('left_eye_venular_dilation')->default(false);
            $table->boolean('left_eye_iris_vessel_dilation')->default(false);
            $table->boolean('left_eye_vitreous_haze')->default(false);
            $table->string('left_eye_funnel_config')->nullable();
            $table->string('left_eye_macular_status')->nullable();
            $table->boolean('left_eye_hemorrhages')->default(false);
            $table->boolean('left_eye_fibrovascular_changes')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            // Right Eye Fields
            $table->dropColumn([
                'right_eye_plus',
                'right_eye_clock_hours',
                'right_eye_ap_rop',
                'right_eye_regression_status',
                'right_eye_par',
                'right_eye_arteriolar_tortuosity',
                'right_eye_venular_dilation',
                'right_eye_iris_vessel_dilation',
                'right_eye_vitreous_haze',
                'right_eye_funnel_config',
                'right_eye_macular_status',
                'right_eye_hemorrhages',
                'right_eye_fibrovascular_changes'
            ]);

            // Left Eye Fields
            $table->dropColumn([
                'left_eye_plus',
                'left_eye_clock_hours',
                'left_eye_ap_rop',
                'left_eye_regression_status',
                'left_eye_par',
                'left_eye_arteriolar_tortuosity',
                'left_eye_venular_dilation',
                'left_eye_iris_vessel_dilation',
                'left_eye_vitreous_haze',
                'left_eye_funnel_config',
                'left_eye_macular_status',
                'left_eye_hemorrhages',
                'left_eye_fibrovascular_changes'
            ]);
        });
    }
};
