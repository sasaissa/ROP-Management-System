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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('treating_doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('examiner_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->dateTime('treatment_date');
            $table->string('treatment_type');
            $table->string('eye_treated');
            $table->text('notes')->nullable();
            $table->dateTime('follow_up_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
