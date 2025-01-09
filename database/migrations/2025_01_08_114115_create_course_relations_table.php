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
        Schema::create('course_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade'); // Foreign key to institutes table
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Foreign key to courses table
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade'); // Foreign key to terms table
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade'); // Foreign key to academic_years table
            $table->boolean('local')->default(false); // Local course indicator
            $table->decimal('local_amount', 10, 2)->nullable(); // Local amount
            $table->boolean('international')->default(false); // International course indicator
            $table->decimal('international_amount', 10, 2)->nullable(); // International amount
            $table->boolean('status')->default(true); // Status (0 or 1)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_relations');
    }
};
