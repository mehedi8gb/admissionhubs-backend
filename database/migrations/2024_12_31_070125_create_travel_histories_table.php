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
        Schema::create('travel_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('purpose', 255)->nullable();
            $table->date('arrival')->nullable();
            $table->date('departure')->nullable();
            $table->date('visaStart')->nullable();
            $table->date('visaExpiry')->nullable();
            $table->string('visaType', 255)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_histories');
    }
};
