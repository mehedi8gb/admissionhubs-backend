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
            $table->string('agent')->nullable()->index();
            $table->string('staff')->nullable()->index();
            $table->boolean('status')->default(true)->index();

//            $table->boolean('visa_need')->default(false);
//            $table->boolean('refused_permission')->default(false);
//            $table->boolean('english_language_required')->default(false);
//            $table->boolean('english_language_required')->default(false);
//            $table->boolean('academic_history_required')->default(false);
//            $table->boolean('work_experience')->default(false);
//            $table->boolean('ukinpast')->default(false);

            $table->string('ref_id')->unique();
            $table->string('name')->index();
            $table->string('email')->index();
            $table->string('phone')->index();
            $table->timestamp('dob')->nullable()->index();

//            $table->string('first_name')->nullable();
//            $table->string('last_name')->nullable();
//            $table->string('maritual_status')->nullable();
//            $table->string('gender_identity')->nullable();
//            $table->string('sexual_orientation')->nullable();
//            $table->string('religion')->nullable();
//            $table->string('gender')->nullable()->index();
//            $table->string('nationality')->nullable();
//            $table->string('country_residence')->nullable();
//            $table->string('country_birth')->nullable();
//            $table->string('ethnicity')->nullable();
//            $table->string('disabilities')->nullable();
//            $table->string('native_language');

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
