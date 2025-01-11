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
            $table->foreignId('nominatedStaffId')->nullable()->constrained('staffs')->cascadeOnDelete(); // Nominated staff
            $table->string('contactPerson')->nullable();
            $table->string('location')->nullable();
            $table->string('organization')->nullable();
            $table->timestamps(); // Created_At and Updated_At
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
}
