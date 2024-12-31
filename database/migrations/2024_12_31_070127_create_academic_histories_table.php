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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to users table
            $table->string('institution');       // Institution name
            $table->string('course');            // Course name
            $table->string('study_level');       // Study level (e.g., Diploma)
            $table->float('result_score', 5, 2); // Result score
            $table->float('out_of', 5, 2);       // Maximum score
            $table->date('start_date');          // Start date of the course
            $table->date('end_date');            // End date of the course
            $table->string('status');            // Status (e.g., Completed)
            $table->string('academic_year');     // Academic year (e.g., 2021-2022)
            $table->string('term');              // Term (e.g., First Term)
            $table->timestamps();                // Laravel's created_at and updated_at
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
