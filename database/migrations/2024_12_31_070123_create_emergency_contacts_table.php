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

        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Associate with the user
            $table->string('name');          // Full name
            $table->string('phone');         // Phone number
            $table->string('email');         // Email address
            $table->string('address');       // Full address
            $table->string('relationship'); // Relationship (e.g., Spouse, Parent)
            $table->string('status');        // Status (e.g., Active)
            $table->timestamps();            // Created and updated timestamps
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};
