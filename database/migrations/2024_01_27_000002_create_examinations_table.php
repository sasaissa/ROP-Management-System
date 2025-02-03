<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('examiner_id')->constrained('doctors')->onDelete('cascade');
            $table->timestamp('examination_date');
            $table->string('right_eye_stage')->nullable();
            $table->string('left_eye_stage')->nullable();
            $table->string('right_eye_zone')->nullable();
            $table->string('left_eye_zone')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('scheduled');
            $table->timestamp('follow_up_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
