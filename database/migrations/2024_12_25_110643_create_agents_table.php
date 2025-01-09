<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id(); // ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User ID
            $table->unsignedBigInteger('nominatedStaff')->nullable(); // Nominated staff
            $table->string('agentName');
            $table->string('contactPerson')->nullable();
            $table->string('email')->unique();
            $table->string('location')->nullable();
            $table->string('organization')->nullable();
            $table->string('phone')->unique();
            $table->string('password'); // Use hashed password
            $table->boolean('status')->default(1); // Status (1 = Active, 0 = Inactive)
            $table->timestamps(); // Created_At and Updated_At
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
}
