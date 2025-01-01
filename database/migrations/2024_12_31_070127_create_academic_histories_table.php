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
        Schema::create('academic_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Reference to users table
            $table->string('institution', 255)->nullable();
            $table->string('course', 255)->nullable();
            $table->string('academicYearId', 255)->nullable();
            $table->string('termId', 255)->nullable();
            $table->string('studyLevel', 255)->nullable();
            $table->decimal('resultScore', 10, 2)->nullable();
            $table->decimal('outOf', 10, 2)->nullable();
            $table->timestamp('startDate')->nullable();
            $table->timestamp('endDate')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_histories');
    }
};
