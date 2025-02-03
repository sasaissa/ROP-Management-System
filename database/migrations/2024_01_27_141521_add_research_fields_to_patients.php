<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Birth and Growth Data
            $table->string('multiple_birth_status')->nullable(); // singleton, twin, triplet, etc.
            $table->decimal('head_circumference', 5, 2)->nullable(); // in cm
            
            // Maternal Data
            $table->boolean('antenatal_steroids_received')->nullable();
            $table->string('mode_of_delivery')->nullable(); // vaginal, c-section
            $table->text('maternal_complications')->nullable();
            
            // NICU Data
            $table->integer('days_on_oxygen')->nullable();
            $table->integer('days_on_ventilation')->nullable();
            $table->decimal('highest_fio2_received', 4, 2)->nullable(); // Fraction of inspired oxygen
            $table->string('surfactant_therapy')->nullable();
            
            // Growth and Development
            $table->decimal('weight_at_examination', 6, 2)->nullable(); // in grams
            $table->decimal('post_menstrual_age', 4, 1)->nullable(); // in weeks
            
            // Research Specific
            $table->string('study_group')->nullable(); // for categorizing patients in research
            $table->text('research_notes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'multiple_birth_status',
                'head_circumference',
                'antenatal_steroids_received',
                'mode_of_delivery',
                'maternal_complications',
                'days_on_oxygen',
                'days_on_ventilation',
                'highest_fio2_received',
                'surfactant_therapy',
                'weight_at_examination',
                'post_menstrual_age',
                'study_group',
                'research_notes'
            ]);
        });
    }
};
