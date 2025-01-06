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
        Schema::create('assign_staff', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID for the record
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Reference to users table
            $table->unsignedBigInteger('staffId')->nullable();
            $table->string('type', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps(); // Created and updated at timestamps

            // Optionally, if staffid references a staff table, you can add this foreign key constraint:
            // $table->foreign('staffid')->references('id')->on('staff')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_staff');
    }
};
