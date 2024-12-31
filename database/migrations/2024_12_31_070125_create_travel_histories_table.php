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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relationship with users
            $table->string('purpose');          // Purpose of travel
            $table->date('arrival');            // Arrival date
            $table->date('departure')->nullable(); // Departure date (nullable if not applicable)
            $table->date('visa_start')->nullable(); // Visa start date
            $table->date('visa_expiry')->nullable(); // Visa expiry date
            $table->string('visa_type');        // Visa type (e.g., Tourist, Business)
            $table->timestamps();               // Created and updated timestamps
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
