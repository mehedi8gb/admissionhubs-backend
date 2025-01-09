<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//            $table->foreignId('institute_id')->nullable()->index();
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->foreignId('academic_year_id')->nullable()->index();
            $table->foreignId('term_id')->nullable()->index();
            $table->foreignId('agent_id')->nullable()->index();
            $table->foreignId('staff_id')->nullable()->index();
            $table->boolean('status')->default(true)->index();

            $table->string('ref_id')->unique();
            $table->string('name')->index();
            $table->string('email')->index();
            $table->string('phone')->index();
            $table->timestamp('dob')->nullable()->index();

            $table->json('student_data');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
