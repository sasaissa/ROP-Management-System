<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nicus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->integer('capacity')->default(0);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Create pivot table for NICU-Doctor relationship
        Schema::create('nicu_doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nicu_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['nicu_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nicu_doctor');
        Schema::dropIfExists('nicus');
    }
};
