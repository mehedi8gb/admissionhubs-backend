<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnglishLanguageExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('english_language_exams', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // User ID
            $table->string('exam'); // Exam name
            $table->date('examDate'); // Exam date
            $table->integer('score'); // Exam score
            $table->boolean('status')->default(true); // Active (1) or inactive (0)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('english_language_exams');
    }
}
